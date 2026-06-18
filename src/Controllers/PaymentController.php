<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Mailer;
use App\Core\Payment;
use App\Core\View;
use App\Models\ItemListing;
use App\Models\PropertyListing;

class PaymentController extends BaseController
{
    public function initiateFeature(): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        $table = $_POST['listing_table'] === 'property' ? 'property' : 'item';
        $listing = $table === 'property' ? PropertyListing::find((int) $_POST['listing_id']) : ItemListing::find((int) $_POST['listing_id']);
        if (!$listing || (int) $listing['user_id'] !== (int) $user['id'] || $listing['status'] !== 'active') {
            $_SESSION['flash'] = 'Only owners can feature active listings.';
            $this->redirect('/profile');
        }
        $amount = $table === 'property' ? $this->config['property_feature_fee'] : $this->config['item_feature_fee'];
        $reference = 'feat_' . uniqid('', true);
        $_SESSION['feature_intents'][$reference] = ['listing_table' => $table, 'listing_id' => (int) $listing['id'], 'user_id' => (int) $user['id'], 'amount' => $amount];
        $url = Payment::initialize($user['email'], $amount * 100, $reference, $this->config['app_url'] . '/payments/callback');
        if (!$url) {
            $_SESSION['flash'] = 'Payment could not be started. Confirm Paystack test keys are configured.';
            $this->redirect('/profile');
        }
        header('Location: ' . $url);
        exit;
    }

    public function handleCallback(): void
    {
        $reference = $_GET['reference'] ?? '';
        $intent = $_SESSION['feature_intents'][$reference] ?? null;
        $verified = $reference ? Payment::verify($reference) : null;
        if (!$intent || !$verified) {
            $this->render('payments/callback', ['success' => false]);
            return;
        }
        Database::getConnection()->prepare("INSERT INTO featured_listings (listing_id, listing_table, user_id, amount, paystack_reference, featured_until) VALUES (?,?,?,?,?,NOW() + (? || ' days')::interval)")
            ->execute([$intent['listing_id'], $intent['listing_table'], $intent['user_id'], $intent['amount'], $reference, (string) $this->config['feature_days']]);
        unset($_SESSION['feature_intents'][$reference]);
        $user = Auth::currentUser();
        if ($user) {
            Mailer::send($user['email'], $user['full_name'], 'Featured listing payment confirmed', View::email('notice', ['name' => $user['full_name'], 'message' => 'Your featured listing payment of ₦' . number_format($intent['amount']) . ' was confirmed.']));
        }
        $this->render('payments/callback', ['success' => true, 'reference' => $reference]);
    }
}

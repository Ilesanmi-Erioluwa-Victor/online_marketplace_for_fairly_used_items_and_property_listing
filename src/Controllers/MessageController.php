<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Mailer;
use App\Core\View;
use App\Models\Conversation;
use App\Models\ItemListing;
use App\Models\Message;
use App\Models\PropertyListing;
use App\Models\User;

class MessageController extends BaseController
{
    public function inbox(): void
    {
        $user = Auth::requireAuth();
        $this->render('messages/inbox', ['conversations' => Conversation::forUser((int) $user['id'])]);
    }

    public function thread(string $id): void
    {
        $user = Auth::requireAuth();
        $conversation = Conversation::findForUser((int) $id, (int) $user['id']);
        if (!$conversation) { http_response_code(404); require __DIR__ . '/../../views/errors/404.php'; return; }
        Message::markConversationAsRead((int) $id, (int) $user['id']);
        $this->render('messages/thread', ['conversation' => $conversation, 'messages' => Message::forConversation((int) $id)]);
    }

    public function start(): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        if (!$user['is_verified']) { $_SESSION['flash'] = 'Verify your email to send messages.'; $this->redirect('/'); }
        $table = $_POST['listing_table'] === 'property' ? 'property' : 'item';
        $listing = $table === 'property' ? PropertyListing::find((int) $_POST['listing_id']) : ItemListing::find((int) $_POST['listing_id']);
        if (!$listing || (int) $listing['user_id'] === (int) $user['id']) {
            $this->redirect('/');
        }
        $id = Conversation::findOrCreate($table, (int) $_POST['listing_id'], (int) $user['id'], (int) $listing['user_id']);
        if (!empty($_POST['body'])) {
            $this->sendMessage($id, $user, $_POST['body'], $listing);
        }
        $this->redirect('/messages/' . $id);
    }

    public function send(string $id): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        if (!$user['is_verified']) { $_SESSION['flash'] = 'Verify your email to send messages.'; $this->redirect('/'); }
        $conversation = Conversation::findForUser((int) $id, (int) $user['id']);
        if (!$conversation) { http_response_code(404); return; }
        $listing = $conversation['listing_table'] === 'property' ? PropertyListing::find((int) $conversation['listing_id']) : ItemListing::find((int) $conversation['listing_id']);
        $this->sendMessage((int) $id, $user, $_POST['body'] ?? '', $listing ?: []);
        $this->redirect('/messages/' . $id);
    }

    private function sendMessage(int $conversationId, array $sender, string $body, array $listing): void
    {
        if (trim($body) === '' || !Message::recentAllowed((int) $sender['id'])) {
            $_SESSION['flash'] = 'Please wait before sending another message.';
            return;
        }
        Message::create($conversationId, (int) $sender['id'], trim($body));
        $conversation = Database::getConnection()->prepare('SELECT * FROM conversations WHERE id=?');
        $conversation->execute([$conversationId]);
        $conv = $conversation->fetch();
        $recipientId = (int) $conv['buyer_id'] === (int) $sender['id'] ? (int) $conv['seller_id'] : (int) $conv['buyer_id'];
        $recipient = User::find($recipientId);
        if ($recipient) {
            Mailer::send($recipient['email'], $recipient['full_name'], 'New message about ' . ($listing['title'] ?? 'a listing'), View::email('notice', ['name' => $recipient['full_name'], 'message' => 'You have a new message about ' . htmlspecialchars($listing['title'] ?? 'a listing') . '.']));
        }
    }
}

<?php
namespace App\Core;

class Payment
{
    public static function initialize(string $email, int $amountKobo, string $reference, string $callbackUrl): ?string
    {
        $secretKey = $_ENV['PAYSTACK_SECRET_KEY'] ?? '';
        if (!str_starts_with($secretKey, 'sk_test_')) {
            error_log('Paystack initialization blocked: test secret key required.');
            return null;
        }
        $payload = json_encode(['email' => $email, 'amount' => $amountKobo, 'reference' => $reference, 'callback_url' => $callbackUrl]);
        $ch = curl_init('https://api.paystack.co/transaction/initialize');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $secretKey, 'Content-Type: application/json'],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $data = json_decode($response, true);
        if ($httpCode !== 200 || empty($data['status'])) {
            error_log("Paystack init failed [{$httpCode}]: {$response}");
            return null;
        }
        return $data['data']['authorization_url'];
    }

    public static function verify(string $reference): ?array
    {
        $secretKey = $_ENV['PAYSTACK_SECRET_KEY'] ?? '';
        if (!str_starts_with($secretKey, 'sk_test_')) {
            error_log('Paystack verification blocked: test secret key required.');
            return null;
        }
        $ch = curl_init("https://api.paystack.co/transaction/verify/{$reference}");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $secretKey],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $data = json_decode($response, true);
        if ($httpCode !== 200 || empty($data['status']) || ($data['data']['status'] ?? '') !== 'success') {
            error_log("Paystack verify failed/incomplete [{$httpCode}]: {$response}");
            return null;
        }
        return $data['data'];
    }
}

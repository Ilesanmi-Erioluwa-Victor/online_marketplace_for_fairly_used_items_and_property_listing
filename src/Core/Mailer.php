<?php
namespace App\Core;

class Mailer
{
    public static function send(string $toEmail, string $toName, string $subject, string $htmlBody): bool
    {
        $apiKey = $_ENV['BREVO_API_KEY'] ?? '';
        $senderEmail = $_ENV['BREVO_SENDER_EMAIL'] ?? '';
        if (!$apiKey || !$senderEmail) {
            error_log('Brevo email skipped: missing configuration.');
            return false;
        }
        $payload = json_encode([
            'sender' => ['name' => 'Fairly Marketplace', 'email' => $senderEmail],
            'to' => [['email' => $toEmail, 'name' => $toName]],
            'subject' => $subject,
            'htmlContent' => $htmlBody,
        ]);
        $ch = curl_init('https://api.brevo.com/v3/smtp/email');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['accept: application/json', 'api-key: ' . $apiKey, 'content-type: application/json'],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode >= 400) {
            error_log("Brevo send failed [{$httpCode}]: {$response}");
            return false;
        }
        return true;
    }
}

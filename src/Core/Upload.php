<?php
namespace App\Core;

class Upload
{
    public static function uploadFile(string $tmpPath, string $destFileName, string $mimeType): ?string
    {
        $supabaseUrl = rtrim($_ENV['SUPABASE_URL'] ?? '', '/');
        $bucket = $_ENV['SUPABASE_STORAGE_BUCKET'] ?? '';
        $serviceKey = $_ENV['SUPABASE_SERVICE_KEY'] ?? '';
        if (!$supabaseUrl || !$bucket || !$serviceKey) {
            error_log('Supabase upload skipped: missing configuration.');
            return null;
        }
        $endpoint = "{$supabaseUrl}/storage/v1/object/{$bucket}/{$destFileName}";
        $fileData = file_get_contents($tmpPath);
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fileData,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $serviceKey, 'Content-Type: ' . $mimeType, 'x-upsert: true'],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode !== 200) {
            error_log("Supabase upload failed [{$httpCode}]: {$response}");
            return null;
        }
        return "{$supabaseUrl}/storage/v1/object/public/{$bucket}/{$destFileName}";
    }

    public static function safeName(string $original): string
    {
        $name = preg_replace('/[^a-zA-Z0-9._-]+/', '-', basename($original));
        return uniqid('', true) . '-' . trim($name, '-');
    }
}

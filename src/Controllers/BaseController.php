<?php
namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Upload;
use App\Core\View;

abstract class BaseController
{
    public function __construct(protected array $config)
    {
    }

    protected function render(string $view, array $data = [], string $title = 'Fairly Marketplace'): void
    {
        View::render($view, $data + ['config' => $this->config], $title);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function backWith(string $message): void
    {
        $_SESSION['flash'] = $message;
    }

    protected function handleImages(array $files, callable $save, string $prefix): void
    {
        if (empty($files['name'][0])) {
            return;
        }
        $count = min(count($files['name']), $this->config['max_images']);
        for ($i = 0; $i < $count; $i++) {
            if (($files['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                continue;
            }
            $mime = mime_content_type($files['tmp_name'][$i]);
            if (!in_array($mime, $this->config['allowed_mimes'], true) || $files['size'][$i] > $this->config['max_upload_bytes']) {
                continue;
            }
            $dest = $prefix . '/' . Upload::safeName($files['name'][$i]);
            $url = Upload::uploadFile($files['tmp_name'][$i], $dest, $mime);
            if ($url) {
                $save($url);
            }
        }
    }

    protected function verifyCsrf(): void
    {
        Csrf::verify();
    }
}

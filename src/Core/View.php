<?php
namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], string $title = 'Fairly Marketplace'): void
    {
        extract($data);
        require __DIR__ . '/../../views/layout/header.php';
        require __DIR__ . '/../../views/' . $view . '.php';
        require __DIR__ . '/../../views/layout/footer.php';
    }

    public static function email(string $template, array $data = []): string
    {
        extract($data);
        ob_start();
        require __DIR__ . '/../../views/emails/' . $template . '.php';
        return ob_get_clean();
    }
}

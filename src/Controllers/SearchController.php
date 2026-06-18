<?php
namespace App\Controllers;

use App\Models\ItemListing;
use App\Models\PropertyListing;

class SearchController extends BaseController
{
    public function index(): void
    {
        $this->render('search/index', [
            'items' => ItemListing::all($_GET, 20, 0),
            'properties' => PropertyListing::all($_GET, 20, 0),
            'query' => $_GET['q'] ?? '',
        ]);
    }
}

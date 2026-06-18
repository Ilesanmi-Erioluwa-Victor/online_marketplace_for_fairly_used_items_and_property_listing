<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\ItemListing;
use App\Models\PropertyListing;

class HomeController extends BaseController
{
    public function index(): void
    {
        $db = Database::getConnection();
        $db->exec('DELETE FROM featured_listings WHERE featured_until <= NOW()');
        $featured = $db->query("SELECT f.*, COALESCE(i.title,p.title) title, COALESCE(ii.image_url,pi.image_url) image_url
            FROM featured_listings f
            LEFT JOIN item_listings i ON f.listing_table='item' AND f.listing_id=i.id
            LEFT JOIN property_listings p ON f.listing_table='property' AND f.listing_id=p.id
            LEFT JOIN LATERAL (SELECT image_url FROM listing_images WHERE listing_table='item' AND listing_id=i.id LIMIT 1) ii ON true
            LEFT JOIN LATERAL (SELECT image_url FROM listing_images WHERE listing_table='property' AND listing_id=p.id LIMIT 1) pi ON true
            WHERE f.featured_until > NOW() ORDER BY f.created_at DESC LIMIT 6")->fetchAll();

        $itemsRecently = ItemListing::all([], 8, 0);
        $propertiesRecently = PropertyListing::all([], 8, 0);
        $itemsElectronics = ItemListing::all(['category' => 'Electronics'], 4, 0);
        $itemsFurniture = ItemListing::all(['category' => 'Furniture'], 4, 0);
        $itemsFashion = ItemListing::all(['category' => 'Fashion'], 4, 0);
        $itemsAppliances = ItemListing::all(['category' => 'Appliances'], 4, 0);
        $propertiesRent = PropertyListing::all(['listing_type' => 'rent'], 4, 0);
        $propertiesSale = PropertyListing::all(['listing_type' => 'sale'], 4, 0);

        $this->render('home/index', [
            'featured' => $featured,
            'itemsRecently' => $itemsRecently,
            'propertiesRecently' => $propertiesRecently,
            'itemsElectronics' => $itemsElectronics,
            'itemsFurniture' => $itemsFurniture,
            'itemsFashion' => $itemsFashion,
            'itemsAppliances' => $itemsAppliances,
            'propertiesRent' => $propertiesRent,
            'propertiesSale' => $propertiesSale,
        ]);
    }
}

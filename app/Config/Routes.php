<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'PagesController::beranda');

$routes->group('admin', ['filter' => 'isLoggedIn'], function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');

    $routes->get('kategori', 'Admin\KategoriController::index');
    $routes->post('kategori/data', 'Admin\KategoriController::datatables'); // load data
    $routes->post('kategori', 'Admin\KategoriController::save'); // save data

    $routes->get('kategori/edit/(:num)', 'Admin\KategoriController::edit/$1'); // edit data
    $routes->post('kategori/edit/(:num)', 'Admin\KategoriController::update/$1'); // update data
    
    $routes->get('kategori/delete/(:num)', 'Admin\KategoriController::delete/$1'); // delete data
    
    
    $routes->get('spesifikasi', 'Admin\SpesifikasiController::index');
    $routes->post('spesifikasi/data', 'Admin\SpesifikasiController::datatables'); // load data
    
    $routes->get('spesifikasi/add', 'Admin\SpesifikasiController::add');
    $routes->post('spesifikasi/add', 'Admin\SpesifikasiController::save'); // save data
    
    $routes->get('spesifikasi/edit/(:num)', 'Admin\SpesifikasiController::edit/$1'); // edit data
    $routes->post('spesifikasi/edit/(:num)', 'Admin\SpesifikasiController::update/$1'); // update data
    
    $routes->get('spesifikasi/delete/(:num)', 'Admin\SpesifikasiController::delete/$1'); // delete data
    
    $routes->get('produk', 'Admin\ProdukController::index');
    $routes->post('produk/data', 'Admin\ProdukController::datatables');
    $routes->get('produk/add', 'Admin\ProdukController::add');
    $routes->post('produk/save', 'Admin\ProdukController::save');
    $routes->post('produk/fecthsubkategori', 'Admin\ProdukController::fecthSubKategori');
    $routes->post('produk/fecthspesifiksai', 'Admin\ProdukController::fecthSpesifiksai');
    
    $routes->post('produk/upload', 'HelperController::fileponduploads');
    $routes->delete('produk/revert', 'HelperController::filepondrevert');
    
    $routes->post('produk/detail', 'Admin\ProdukController::detail_produk/');
    
    $routes->get('produk/edit/(:num)', 'Admin\ProdukController::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin\ProdukController::update/$1');
    $routes->post('produk/delete/(:num)', 'Admin\ProdukController::delete/$1');

    $routes->get('produk/promo', 'Admin\ProdukPromoController::index');
    $routes->post('produk/promo/data', 'Admin\ProdukPromoController::datatables');
    $routes->get('produk/promo/add', 'Admin\ProdukPromoController::add');
    $routes->post('produk/promo/add', 'Admin\ProdukPromoController::save');
    $routes->post('produk/promo/update/(:num)', 'Admin\ProdukPromoController::update/$1');
    $routes->get('produk/promo/item/(:num)', 'Admin\ProdukPromoController::item/$1');
    $routes->post('produk/promo/promosave', 'Admin\ProdukPromoController::promosave');
    $routes->post('produk/promo/detail_promo', 'Admin\ProdukPromoController::detail_promo');
    $routes->post('produk/promo/delete/(:num)', 'Admin\ProdukPromoController::delete/$1');

    $routes->get('produk/promo/delete-item/(:num)/(:num)', 'Admin\ProdukPromoController::delete_item/$1/$2');
    
    $routes->post('produk/promo-dataproduk', 'Admin\ProdukPromoController::fecthProduk');
    $routes->post('produk/promo-status/(:num)', 'Admin\ProdukPromoController::changeStatus/$1');
    $routes->post('produk/promo/(:num)/(:num)/add', 'Admin\ProdukPromoController::add_item/$2/$1');

    $routes->get('produk-paket', 'Admin\PaketController::index');
    $routes->post('produk-paket/data', 'Admin\PaketController::datatables');
    $routes->get('produk-paket/add', 'Admin\PaketController::add');
    $routes->post('produk-paket/add', 'Admin\PaketController::save');
    $routes->get('produk-paket/(:num)/detail', 'Admin\PaketController::detail/$1');
    
    $routes->post('produk-paket/add/(:num)', 'Admin\PaketController::update/$1');
    $routes->post('produk-paket/upload', 'HelperController::filepondupload');
    
    $routes->post('produk-paket/fecthProduk', 'Admin\PaketController::fecthProduk');
    $routes->post('produk-paket/(:any)/(:any)/(:any)/item-add', 'Admin\PaketController::add_item/$1/$2/$3');
    $routes->post('produk-paket/item-get/(:any)', 'Admin\PaketController::get_item/$1');
    $routes->post('produk-paket/item-remove/(:any)', 'Admin\PaketController::remove_item/$1');

    $routes->post('produk-paket/delete/(:num)', 'Admin\PaketController::delete/$1');
    

    $routes->get('banner', 'Admin\BannerController::index');    
    $routes->post('banner', 'Admin\BannerController::save');    
    $routes->post('banner/data', 'Admin\BannerController::datatables');   

    $routes->get('banner/edit/(:num)', 'Admin\BannerController::edit/$1'); // edit data
    $routes->post('banner/edit/(:num)', 'Admin\BannerController::update/$1'); // edit data
    $routes->post('banner/delete/(:num)', 'Admin\BannerController::delete/$1'); // delete data
    
    $routes->post('banner/status/(:num)', 'Admin\BannerController::status/$1'); // edit data


    $routes->get('layanan', 'Admin\LayananController::index');
    $routes->post('layanan/data', 'Admin\LayananController::datatables'); // load data
    $routes->post('layanan', 'Admin\LayananController::save'); // save data

    $routes->get('layanan/edit/(:num)', 'Admin\LayananController::edit/$1'); // edit data
    $routes->post('layanan/edit/(:num)', 'Admin\LayananController::update/$1'); // update data
    
    $routes->get('layanan/delete/(:num)', 'Admin\LayananController::delete/$1'); // delete data


    $routes->get('patner', 'Admin\PatnerController::index');
    $routes->post('patner/data', 'Admin\PatnerController::datatables'); // load data
    $routes->post('patner', 'Admin\PatnerController::save'); // save data
    
    $routes->get('patner/edit/(:num)', 'Admin\PatnerController::edit/$1'); // edit data
    $routes->post('patner/edit/(:num)', 'Admin\PatnerController::update/$1'); // update data
    
    $routes->get('patner/delete/(:num)', 'Admin\PatnerController::delete/$1'); // delete data
    
    
    $routes->get('kontak', 'Admin\KontakController::index');
    $routes->post('kontak', 'Admin\KontakController::update');

    $routes->get('about', 'Admin\AboutController::index');
    $routes->post('about', 'Admin\AboutController::update');
    
    $routes->get('pesan', 'Admin\PesanController::index');
    $routes->post('pesan/data', 'Admin\PesanController::datatables'); // load data
    $routes->get('pesan/delete/(:num)', 'Admin\PesanController::delete/$1'); // delete data

    $routes->get('orders', 'Admin\OrdersController::index');
    $routes->get('orders/setting', 'Admin\OrdersController::setting');
    $routes->post('orders/setting', 'Admin\OrdersController::update');

    $routes->post('orders/data_sales', 'Admin\OrdersController::data_sales');
    $routes->post('orders/save_sales', 'Admin\OrdersController::save_sales'); // save data

    $routes->get('orders/edit_sales/(:num)', 'Admin\OrdersController::edit_sales/$1'); // edit data
    $routes->post('orders/edit_sales/(:num)', 'Admin\OrdersController::update_sales/$1'); // update data

    $routes->get('orders/delete_sales/(:num)', 'Admin\OrdersController::delete_sales/$1'); // delete data

    $routes->post('orders/data', 'Admin\OrdersController::datatables'); // load data
    $routes->post('orders/detail_order', 'Admin\OrdersController::detail_order');
    $routes->get('orders/delete/(:num)', 'Admin\OrdersController::delete/$1'); // delete data


    $routes->get('users', 'Admin\UsersController::index');
    $routes->post('users/data', 'Admin\UsersController::datatables'); // load data
    $routes->post('users', 'Admin\UsersController::save'); // save data

    $routes->get('users/edit/(:num)', 'Admin\UsersController::edit/$1'); // edit data
    $routes->post('users/edit/(:num)', 'Admin\UsersController::update/$1'); // update data
    
    $routes->get('users/delete/(:num)', 'Admin\UsersController::delete/$1'); // delete data
});





/// pages 
$routes->group('/', static function($routes){
    $routes->get('/beranda', 'PagesController::beranda');
    $routes->get('/tentang-kami', 'PagesController::about');
    $routes->get('/kontak', 'PagesController::kontak');
    $routes->post('/kontak', 'Admin\PesanController::save');

    $routes->get('/produk', 'PagesController::produk');
    $routes->get('/produk/kategori/(:any)', 'PagesController::produk_kategori/$1');

    $routes->get('/produk/(:num)/(:any)/(:any)', 'PagesController::produk_detail/$1/$2/$3');
    
    $routes->get('/keranjang', 'PagesController::keranjang');
    $routes->post('/keranjang-checkout', 'HelperController::Orders');
    $routes->post('/keranjang-refresh', 'HelperController::refreshproduk');

    $routes->post('/check-kode-sales', 'HelperController::hendleSalesCode');

    $routes->get('/login', 'AuthController::login');
    $routes->post('/login', 'AuthController::proses_login');
    $routes->get('/logout', 'AuthController::logout');
});
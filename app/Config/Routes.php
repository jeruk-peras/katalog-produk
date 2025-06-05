<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', function ($routes) {
    $routes->get('kategori', 'Admin\KategoriController::index');
    $routes->post('kategori/data', 'Admin\KategoriController::datatables'); // load data
    $routes->post('kategori', 'Admin\KategoriController::save'); // save data

    $routes->get('kategori/edit/(:num)', 'Admin\KategoriController::edit/$1'); // edit data
    $routes->post('kategori/edit/(:num)', 'Admin\KategoriController::update/$1'); // update data
    
    $routes->get('kategori/delete/(:num)', 'Admin\KategoriController::delete/$1'); // delete data
    

    $routes->get('sub-kategori', 'Admin\SubKategoriController::index');
    $routes->post('sub-kategori/data', 'Admin\SubKategoriController::datatables'); // load data
    $routes->post('sub-kategori', 'Admin\SubKategoriController::save');
    
    $routes->get('sub-kategori/edit/(:num)', 'Admin\SubKategoriController::edit/$1'); // edit data
    $routes->post('sub-kategori/edit/(:num)', 'Admin\SubKategoriController::update/$1'); // update data
   
    $routes->get('sub-kategori/delete/(:num)', 'Admin\SubKategoriController::delete/$1'); // delete data


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

    $routes->post('produk/upload', 'HelperController::filepondupload');
    $routes->delete('produk/revert', 'HelperController::filepondrevert');


});
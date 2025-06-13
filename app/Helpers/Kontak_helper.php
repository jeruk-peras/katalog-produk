<?php

/**
 * Kontak Helper
 * helper fungsi ini unuk mengambil data kontak dari database
 * @param string $kontak
 * @return string 
 */
function getKontak($kontak) 
{
    $KontakModel = new \App\Models\KontakModel();
    $data = $KontakModel->where(['kontak' => $kontak])->first();
    return $data['data'] ?? '';
}

/**
 * about Helper
 * helper fungsi ini unuk mengambil data about dari database
 * @param string $about
 * @return string 
 */
function getAbout($about) 
{
    $aboutModel = new \App\Models\AboutModel();
    $data = $aboutModel->where(['data' => $about])->first();
    return $data['nilai'] ?? '';
}


/**
 *kategori Helper
 * helper fungsi ini unuk mengambil data dari database
 * @return array 
 */
function getKategori() 
{
    $kategori = new \App\Models\KategoriModel();

    $data = $kategori->findAll();
    return $data;
}

function no_pengirim(){
     $data = new \App\Models\OrderSettModel();

     return $data->where('setting', 'nomor_penerima_order')->first()['data'];
}
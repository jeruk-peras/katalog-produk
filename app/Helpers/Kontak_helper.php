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
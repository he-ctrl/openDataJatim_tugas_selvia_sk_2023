<?php

// API URL untuk mendapatkan data jumlah kejadian bencana berdasarkan jenisnya di Jawa Timur
$apiUrl = 'https://opendata.jatimprov.go.id/api/cleaned-bigdata/dinas_kepemudaan_dan_olahraga_provinsi_jawa_timur/ktrsdn_fslts_lhrglpngn_lhrggdng_lhrg_st_pmrnth_prvns_jw_tmr?where=%7B%22periode_update%22%3A%5B%222025%22%2C%222024%22%2C%222023%22%2C%222022%22%2C%222021%22%5D%7D';
//membuat header untuk menghidari 403
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Accept: application/json',
            'Accept-Language: en-US,en;q=0.9',
            'Referer: https://opendata.jatimprov.go.id/',
        ],
        'timeout' => 30
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]);

// Fetch data dengan header
$jsonData = file_get_contents($apiUrl, false, $context);

// cek jika data berhasil diambil
if ($jsonData === false) {
    die('Failed to fetch data from API');
}

// ubah JSON menjadi array
$arrayData = json_decode($jsonData, true);
// cek jika JSON berhasil di-decode
if ($arrayData === null) {
    die('Failed to decode JSON data');
}

// ekstrak data yang diinginkan dari array

$result = [
    'data' => $arrayData['results'] ?? $arrayData, 
];

// tampilkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($result['data']['data'], JSON_PRETTY_PRINT);

?>

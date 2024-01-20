<?php
//Для отсеивания сторонних запросов будем использовать Low security token.
const TOKEN = 'GT2Xw0swap!3zmyT/zIhkDf?xzdo6uUi5rNyffF7uzKH!GHKCxYSAG4e9z?HWhy5';
//Для проверки целостности файла будем использовать Хэш файла через стандартные функции php.
$hash = hash_file('sha256', 'test.jpg');
$file = curl_file_create('test.jpg', 'image/jpg', 'test');
$data = array('file' => $file, 'TOKEN' => TOKEN, 'hash' => $hash);

if ($ch = curl_init()) {
    curl_setopt($ch, CURLOPT_URL, 'https://httpbin.org/anything');
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect: '));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $res_curl = curl_exec($ch);

    if (!curl_errno($ch)) {
        p($res_curl);
    }
    curl_close($ch);
}

function p($result): void
{
    //Зафиксируем отправленный json
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/print_response.json', print_r($result, true));
    $data = json_decode($result);
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
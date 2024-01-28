<?php
declare(strict_types=1);

use Classes\CodingData;
use Classes\HelpFunctions;
use Classes\PostApi;
use Classes\PostFile;


//Вызов метода создания ключей осуществляется 1 раз
CodingData::createKeys();
//Соберем данные для отправки
$data = (new PostFile('test.jpg'))->getPostData();

//Попытаемся отправить все необходимые данные
try {
    $post = (new PostApi())->post($data);
} catch (Exception $e) {
    HelpFunctions::p($e->getMessage());
}

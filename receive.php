<?php
//Для отсеивания сторонних запросов будем использовать Low security token.
const TOKEN = 'GT2Xw0swap!3zmyT/zIhkDf?xzdo6uUi5rNyffF7uzKH!GHKCxYSAG4e9z?HWhy5';
if (array_key_exists('TOKEN', $_POST) && $_POST['TOKEN'] === TOKEN) {
    //Добавим дополнительную проверку на тип отправленного файла
    $allowed_types = array(
        'application/pdf' => '.pdf',
        'image/jpeg' => '.jpeg',
        'image/jpg' => '.jpg',
        'image/png' => '.png');
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $detected_type = finfo_file($fileInfo, $_FILES['file']['tmp_name']);
    if (array_key_exists($detected_type, $allowed_types)) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/files/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $upload_file = $upload_dir . basename($_FILES['file']['name']) . $allowed_types[$detected_type];
        finfo_close($fileInfo);
        move_uploaded_file($_FILES['file']['tmp_name'], $upload_file);
        if (file_exists($upload_file)) {
            $hash = hash_file('sha256', $upload_file);
            if ($hash === $_POST['hash']) {
                echo 'Данные не были повреждены в процессе
пересылки по сети';
                l($upload_file);
            } else {
                //В случае если целостность файла нарушена, удалим его
                unlink($upload_file);
            }
        }
    }
}
function l($path): void
{
    $text = date('d.m.Y H:i:s') . ": Был создан новый файл (" . $path . "). Данные не были повреждены в процессе пересылки по сети \n";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log.log', $text, FILE_APPEND);
}
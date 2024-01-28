<?php

declare(strict_types=1);

namespace Classes;

require_once(__DIR__ . "/../config.php");

class ReceiveFile
{
    protected array $post;

    public function __construct(array $post_data)
    {
        $this->post = $post_data;
        $this->validate();
    }

    protected function validate(): void
    {
        $coding_class = new CodingData();
        $post_token = $coding_class->decodeData($_POST['TOKEN']);
        if (array_key_exists('TOKEN', $_POST) && $post_token === TOKEN) {
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
                    if (hash_equals($hash, $_POST['hash'])) {
                        echo 'Данные не были повреждены в процессе
пересылки по сети';
                        HelpFunctions::l($upload_file);
                    } else {
                        //В случае если целостность файла нарушена, удалим его
                        unlink($upload_file);
                    }
                }
            }
        }

    }

}

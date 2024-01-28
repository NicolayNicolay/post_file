<?php
declare(strict_types=1);

namespace Classes;

require_once(__DIR__ . "/../config.php");

class CodingData
{

    //Функция для создания приватного и публичного ключа
    static public function createKeys(): array
    {
        $res = openssl_pkey_new(CONFIG_PRIVATE);
        $privateKey = "";
        //Генерация приватного ключа
        openssl_pkey_export($res, $privateKey);
        //Сохранение ключа в файл
        if (!file_exists(KEY_PATH . "private.txt")) {
            $fpr = fopen(KEY_PATH . "private.txt", "w");
            fwrite($fpr, $privateKey);
            fclose($fpr);
        }
        //Для получение публичного ключа сгенерируем сертификат
        $csr = openssl_csr_new(CONFIG_SSL, $privateKey);
        $cert = openssl_csr_sign($csr, null, $privateKey, 3);
        openssl_x509_export($cert, $str_cert);
        //Теперь используем временный сертификат для получения ключа
        $public_key = openssl_pkey_get_public($str_cert);
        $public_key_details = openssl_pkey_get_details($public_key);
        $public_key_data = $public_key_details['key'];
        //Далее запишем наш публичный ключ в файл
        if (!file_exists(KEY_PATH . "public.txt")) {
            $fpr_public = fopen(KEY_PATH . "public.txt", "w");
            fwrite($fpr_public, $public_key_data);
            fclose($fpr_public);
        }

        return [
            "private" => $privateKey,
            "public" => $public_key_data,
        ];
    }

    //Кодирование данных с помощью публичного ключа
    public function encodeData(string $data): string
    {
        $path = KEY_PATH . "public.txt";
        $public_key = file_get_contents($path);
        //Зашифруем переданные данные с помощью публичного ключа
        openssl_public_encrypt($data, $result, $public_key);
        return $result;
    }

    //Декодирование данных с помощью приватного ключа
    public function decodeData(string $data): string
    {
        $path = KEY_PATH . "private.txt";
        $private_key = file_get_contents($path);
        openssl_private_decrypt($data, $result, $private_key);
        return $result;
    }
}
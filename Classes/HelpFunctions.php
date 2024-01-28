<?php
declare(strict_types=1);

namespace Classes;
class HelpFunctions
{
    public static function p($result): void
    {
        //Зафиксируем отправленный json
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/print_response.json', print_r($result, true));
        $data = json_decode($result);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function l($path): void
    {
        $text = date('d.m.Y H:i:s') . ": Был создан новый файл (" . $path . "). Данные не были повреждены в процессе пересылки по сети \n";
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log.log', $text, FILE_APPEND);
    }
}
<?php

declare(strict_types=1);

namespace Classes;

require_once(__DIR__ . "/../config.php");

class PostFile
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    private function getHash(): string
    {
        $hash = hash_file('sha256', $this->path);
        return crypt(file_get_contents($this->path), $hash);
    }

    private function getPostToken(): string
    {
        $coding_class = new CodingData();
        $file = file_get_contents(TOKEN);
        return $coding_class->encodeData($file);
    }

    public function getPostData(): array
    {
        $file = curl_file_create($this->path, 'image/jpg', 'test');
        return [
            'file' => $file,
            'TOKEN' => self::getPostToken(),
            'hash' => self::getHash()
        ];
    }
}

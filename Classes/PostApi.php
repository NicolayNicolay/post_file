<?php

declare(strict_types=1);

namespace Classes;

require_once(__DIR__ . "/../config.php");

class PostApi
{
    protected array $header = [];

    protected string $host;
    protected string $path;

    public function __construct(string $host = '', string $path = '')
    {
        $this->host = $host ?? HOST;
        $this->path = $path ?? PATH;
    }

    public function getHost(): string
    {
        $scheme = 'https';
        return $scheme . '://' . $this->host;
    }

    /**
     * @throws Exception
     */
    public function sendRequest(string $requestMethod = 'GET', array $params = [], bool $contentType = false): ?array
    {
        $apiUrl = $this->getHost() . $this->path;
        //Добавляем в заголовок bearer token
        $post_data = http_build_query($params);
        if ($contentType) {
            $this->header['http']['header'][] = CONTENT_TYPE;
        }
        $this->header['http']['method'] = $requestMethod;
        if ($requestMethod === 'GET') {
            $context = stream_context_create($this->header);
            $query = $apiUrl . '?' . http_build_query($params);
        } else {
            $this->header['http']['content'] = $post_data;
            $context = stream_context_create($this->header);
            $query = $apiUrl;
        }
        $result = file_get_contents($query, false, $context);
        return $result ? json_decode($result, true) : null;
    }

    /**
     * @throws Exception
     */
    public function post(array $params = []): ?array
    {
        return $this->sendRequest('POST', $params, true);
    }

    /**
     * @throws Exception
     */
    public function get(array $params = []): ?array
    {
        return $this->sendRequest('GET', $params);
    }
}

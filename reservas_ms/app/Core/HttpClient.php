<?php
/**
 * Cliente HTTP simple para comunicación entre microservicios.
 * POO: encapsulamiento, responsabilidad única.
 */
class HttpClient {
    private int $timeout;

    public function __construct(int $timeout = 5) {
        $this->timeout = $timeout;
    }

    public function get(string $url): ?array {
        $ctx = stream_context_create(['http' => [
            'method'  => 'GET',
            'timeout' => $this->timeout,
        ]]);
        $res = @file_get_contents($url, false, $ctx);
        return $res ? json_decode($res, true) : null;
    }

    public function patch(string $url, array $body): ?array {
        $ctx = stream_context_create(['http' => [
            'method'  => 'PATCH',
            'header'  => "Content-Type: application/json\r\n",
            'content' => json_encode($body),
            'timeout' => $this->timeout,
        ]]);
        $res = @file_get_contents($url, false, $ctx);
        return $res ? json_decode($res, true) : null;
    }
}

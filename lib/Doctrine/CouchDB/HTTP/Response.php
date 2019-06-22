<?php

namespace Doctrine\CouchDB\HTTP;

/**
 * HTTP response.
 *
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 *
 * @link        www.doctrine-project.com
 * @since       1.0
 *
 * @author      Kore Nordmann <kore@arbitracker.org>
 */
class Response
{
    /**
     * HTTP response status.
     *
     * @var int
     */
    public $status;

    /**
     * HTTP response headers.
     *
     * @var array
     */
    public $headers;

    /**
     * Decoded JSON response body.
     *
     * @var array
     */
    public $body;

    /**
     * Construct response.
     *
     * @param $status
     * @param array  $headers
     * @param string $body
     * @param bool   $raw
     *
     * @return void
     */
    public function __construct($status, array $headers, $body, $raw = false)
    {
        if ($raw) {
            $parsed_body = $body;
        } else {
            $parsed_body = str_replace(["\r\n", "\n"], "", $body);
            $parsed_body = json_decode($parsed_body, true);
            if ($parsed_body === null && json_last_error()) {
                throw JsonDecodeException::fromLastJsonError();
            }
        }

        $this->status = (int)$status;
        $this->headers = $headers;
        $this->body = $parsed_body;
    }
}

<?php
if (!defined('prevent_direct_access'))
{
    // prevent direct access to this file
    die();
}
function sendHttpQuery($url, $data) : string
{

    $headers = ["Content-type: application/x-www-form-urlencoded"];

    // use key 'http' even if you send the request to https://...
    $options = [
        'http' => [
            'header' => $headers,
            'method' => 'POST',
            'content' => http_build_query($data),
            'ignore_errors' => true,
        ],
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if (version_compare(PHP_VERSION, '8.4.0') >= 0) {
        $status_line = http_get_last_response_headers()[0];
    } else {
        /* @var array $http_response_header is a deprecated magic var */
        $status_line = $http_response_header[0];
    }

    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = $match[1];
    if ($status !== "200") {
        throw new RuntimeException(
            "Unexpected response status: $status_line\n$response"
        );
    }
    return $response;
}




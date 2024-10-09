<?php

use Google\CloudFunctions\FunctionsFramework;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\Psr7\Response;


// Register the function with Functions Framework.
// This enables omitting the `FUNCTIONS_SIGNATURE_TYPE=http` environment
// variable when deploying. The `FUNCTION_TARGET` environment variable should
// match the first parameter.
FunctionsFramework::http('helloHttp', 'helloHttp');

function helloHttp(ServerRequestInterface $request)
{
    $headers = ['Access-Control-Allow-Origin' => '*'];
    $statusCode = 204;

    if ($request->getMethod() === 'OPTIONS') {
        // Send response to OPTIONS requests
        $headers = array_merge($headers, [
            'Access-Control-Allow-Methods' => 'GET',
            'Access-Control-Allow-Headers' => 'Content-Type',
            'Access-Control-Max-Age' => '3600'
        ]);
        return new Response($statusCode, $headers, '');
    }
    $name = 'World';
    $body = $request->getBody()->getContents();
    if (!empty($body)) {
        $json = json_decode($body, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new RuntimeException(sprintf(
                'Could not parse body: %s',
                json_last_error_msg()
            ));
        }
        $name = $json['name'] ?? $name;
    }
    $queryString = $request->getQueryParams();
    $name = $queryString['name'] ?? $name;
    $statusCode = 200;

    return new Response($statusCode, $headers, json_encode(['message' => sprintf('Hello, %s!', htmlspecialchars($name))]), '');
}

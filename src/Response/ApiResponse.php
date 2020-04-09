<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 09/04/2020
 * Time: 15:04
 */

namespace App\Response;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

class ApiResponse extends JsonResponse
{
    /**
     * ApiResponse constructor.
     * @param $message
     * @param null $data
     * @param array $errors
     * @param int $status
     * @param array $headers
     * @param bool $json
     */
    public function __construct(string $message = "Success", $data = null, $errors = null, int $status = 200, array $headers = [], bool $json = false)
    {
        $response = [
            'message' => $message,
            'data' => $data
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return parent::__construct($response, $status, $headers, $json);
    }
}
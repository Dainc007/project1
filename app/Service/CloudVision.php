<?php

namespace App\Service;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use stdClass;

class CloudVision
{

    /**
     * Metoda zwraca tekst znaleziony na podanym obrazku.
     *
     * @param  string  $image
     * @return PromiseInterface|Response
     */
    public function getTextFromImg(string $image): PromiseInterface|Response
    {
        return Http::withHeaders([
            'x-goog-user-project' => env('GOOGLE_CLOUD_CLIENT_ID'),
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer '.env('GOOGLE_CLOUD_API_TOKEN')
        ])->withBody(json_encode([
            'requests' => [
                [
                    'image' => [
                        'content' => $image
                    ],
                    'features' => [
                        "type" => "TEXT_DETECTION"
                    ]
                ]
            ]
        ]))->post('https://vision.googleapis.com/v1/images:annotate');
    }
}

<?php

namespace App\Service\Prototypes;

use Illuminate\Support\Facades\Storage;

class PlayerStats
{
    public function getFromImage($filePath = 'stats_eng.json')
    {
        $file = Storage::disk('public')->get($filePath);
        $arr  = json_decode($file, true);
        //dane przygotowane do przetworzenia
        $data = ($arr['responses'][0]['fullTextAnnotation']['text']);
        $data = explode(PHP_EOL , $data);

        //wycinamy fragmenty które api poprawnie przetworzyło i usuwamy błędy
        $rightSideTableKeys   = array_slice($data, 68, 15);
        $rightSideTableValues = array_slice($data, 84, 16);

        unset($rightSideTableKeys[6], $rightSideTableValues[4], $rightSideTableValues[9]);
        $stats = (array_combine($rightSideTableKeys, $rightSideTableValues));

        $model = new \stdClass();
        $model->overall  = $data[1];
        $model->position = $data[4];
        $model->name     = $data[15];
        $model->surname  = $data[16];
        $model->knownAs  = $data[18];
        $model->matchRating = $data[32];

        foreach($stats as $key => $value)
        {
            $model->$key = str_replace(' ', '/', $value);
        }

        return $model;
    }
}

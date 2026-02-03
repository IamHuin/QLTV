<?php

namespace App\Service;

use App\Contract\FillterInterface;

class FillterService implements FillterInterface
{

    public function fill($request)
    {
        // TODO: Implement fill() method.
        return [
            'key' => $request->input('key', 'title'),
            'filled' => $request->input('filled', 'asc'),
        ];
    }
}

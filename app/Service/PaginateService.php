<?php

namespace App\Service;

use App\Contract\PaginateInterface;

class PaginateService implements PaginateInterface
{

    public function paginate($request)
    {
        // TODO: Implement paginate() method.
        return [
            'limit' => max(1, (int)$request->input('limit', 5)),
            'page' => max(1, (int)$request->input('page', 1)),
            'maxPage' => max(1, (int)$request->input('maxPage', 20)),
            'lang' => $request->input('lang', config('translate.default_lang')),
        ];
    }
}

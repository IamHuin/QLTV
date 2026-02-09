<?php

namespace App\Contract;

interface PaginateInterface
{
    public function paginate($request);

    public function dataPaginate($paginate);
}

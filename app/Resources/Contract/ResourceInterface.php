<?php

namespace App\Resources\Contract;

use App\DataTable\Table;
use Illuminate\Database\Eloquent\Builder;

interface ResourceInterface
{
    public function getView(string $key);

    public function queryCallback() : Builder;

    public function getTable() : Table;

    public function modelClass() : string;

    public function getResourceName() : string;

    public function getForm(string $action) : array;
}

<?php

namespace App\Resources;

use App\DataTable\Column;
use App\DataTable\Table;
use App\Models\Competition;
use Illuminate\Database\Eloquent\Builder;

class CompetitionResource extends Resource
{
    public function queryCallback(): Builder
    {
        return Competition::query();
    }

    public function modelClass(): string
    {
        return Competition::class;
    }

    public function getTable(): Table
    {
        return parent::getTable()
            ->addColumn(Column::make(name: 'id', title: 'ID'))
            ->addColumn(Column::make(name: 'name', title: 'Name'));
    }

    public function getForm(string $action): array
    {
        return [
            [
                '$formkit' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'children' => '$name',
                'placeholder' => 'Enter competition name',
                'validation' => 'required|length:6,255'
            ],
            [
                '$formkit' => 'text',
                'name' => 'test',
                'label' => 'Test',
                'children' => '$test',
                'placeholder' => 'Enter test name',
                'validation' => 'required|length:6,255'
            ]
        ];
    }

}

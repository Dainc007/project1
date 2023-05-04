<?php

namespace App\Resources;

use App\DataTable\Column;
use App\DataTable\Table;
use App\Models\UserAsTeam;
use Illuminate\Database\Eloquent\Builder;

class UserAsTeamResource extends Resource
{

    public function queryCallback(): Builder
    {
        return UserAsTeam::query();
    }

    public function modelClass(): string
    {
        return UserAsTeam::class;
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
            ]
        ];
    }
}

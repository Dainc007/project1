<?php

namespace App\Resources;

use App\DataTable\Action;
use App\DataTable\Table;
use App\Resources\Contract\ResourceInterface;
use Exception;
use Illuminate\Support\Str;

abstract class Resource implements ResourceInterface
{
    public const INDEX_ACTION = 'index';
    public const CREATE_ACTION = 'create';
    public const SHOW_ACTION = 'show';
    public const EDIT_ACTION = 'edit';

    private array $views = [
        self::INDEX_ACTION => 'Crud/Index',
        self::CREATE_ACTION => 'Crud/Create',
        self::SHOW_ACTION => 'Crud/Show',
        self::EDIT_ACTION => 'Crud/Edit',
    ];

    private ?string $resourceName = null;

    /**
     * Return view basen on action key
     *
     * @param  string  $key
     * @return string
     * @throws Exception
     */
    public function getView(string $key): string
    {
        if (isset($this->views[$key])) {
            return $this->views[$key];
        }

        throw new Exception('View not exist');
    }

    public function setView(string $key, string $view): ResourceInterface
    {
        $this->views[$key] = $view;

        return $this;
    }

    public function getResourceName(): string
    {
        if (null === $this->resourceName) {
            $this->resourceName = Str::snake(Str::replaceFirst('Resource', '', Str::afterLast(static::class, '\\')));
        }

        return $this->resourceName;
    }

    public function getTable(): Table
    {
        return (new Table())
            ->setDataUrl(route($this->getResourceName().'.data'))
            ->setObjectType($this->getResourceName())
            ->setPerPage(20)
            ->addAction(
                (new Action())
                    ->setName($this->getResourceName().'.edit')
                    ->setHref(
                        route(
                            $this->getResourceName().'.edit',
                            [$this->getResourceName() => '#id#'],
                            false
                        )
                    )
                    ->setText('<i class="fas fa-pencil-alt"></i>')

            )->addAction(
                (new Action())
                    ->setName($this->getResourceName().'.show')
                    ->setHref(
                        route(
                            $this->getResourceName().'.show',
                            [$this->getResourceName() => '#id#'],
                            false
                        )
                    )
                    ->setText('<i class="fa-solid fa-magnifying-glass"></i>')

            )->addAction(
                (new Action())
                    ->setName($this->getResourceName().'.destroy')
                    ->setMethod(Action::METHOD_DELETE)
                    ->setHref(
                        route(
                            $this->getResourceName().'.destroy',
                            [$this->getResourceName() => '#id#'],
                            false
                        )
                    )
                    ->setText('<i class="fas fa-trash-alt"></i>')
            );
    }

    public function getForm(string $action) : array
    {
        return [];
    }
}

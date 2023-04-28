<?php

namespace App\DataTable;

class Table implements \JsonSerializable
{
    /** @var array<int, Action> */
    private array $actions = [];

    /** @var array<int, Column> */
    private array $columns = [];

    private int $perPage = 10;

    private array $search = [];

    private array $order = [];

    private ?string $dataUrl = null;

    private string $objectType = '';

    private string $objectKey = 'id';

    /** @var array<string> */
    private array $select = [];

    public function addAction(Action $action): Table
    {
        $this->actions[] = $action;
        return $this;
    }

    /**
     * @return Action[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function addColumn($column): Table
    {
        $this->columns[] = $column;
        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param  int  $perPage
     * @return Table
     */
    public function setPerPage(int $perPage): Table
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'columns' => $this->getColumns(),
            'dataUrl' => $this->getDataUrl(),
            'search' => $this->getSearch(),
            'objectName' => $this->getObjectType(),
            'objectKey' => $this->getObjectKey(),
            'order' => $this->getOrder(),
            'actions' => $this->getActions(),
            'perPage' => $this->getPerPage()
        ];
    }

    /**
     * @return array
     */
    public function getSearch(): array
    {
        return $this->search;
    }

    /**
     * @param  array  $search
     * @return Table
     */
    public function setSearch(array $search): Table
    {
        $this->search = $search;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDataUrl(): ?string
    {
        return $this->dataUrl;
    }

    /**
     * @param  string|null  $dataUrl
     * @return Table
     */
    public function setDataUrl(?string $dataUrl): Table
    {
        $this->dataUrl = $dataUrl;
        return $this;
    }

    public function getObjectType(): string
    {
        return $this->objectType;
    }

    public function setObjectType(string $objectType): Table
    {
        $this->objectType = $objectType;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
    }

    /**
     * @param  array  $order
     * @return Table
     */
    public function setOrder(array $order): Table
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getSelect(): array
    {
        return $this->select;
    }

    /**
     * @param  string[]  $select
     */
    public function setSelect(array $select): Table
    {
        $this->select = $select;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectKey(): string
    {
        return $this->objectKey;
    }

    /**
     * @param  string  $objectKey
     */
    public function setObjectKey(string $objectKey): void
    {
        $this->objectKey = $objectKey;
    }

}

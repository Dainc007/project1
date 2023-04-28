<?php

namespace App\DataTable;

use Illuminate\Support\Arr;
use JsonSerializable;

class Column implements JsonSerializable
{

    private function __construct(
        private readonly string $name,
        private readonly string $title,
        private readonly bool   $visible = true,
        private                 $transform = null,
        private readonly bool   $sortable = true
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function getTransform(): callable|null
    {
        return $this->transform;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function jsonSerialize(): array
    {
        return Arr::except(get_object_vars($this), ['transform']);
    }

    public static function make(string $name, string $title, bool $visible = true, ?callable $transform = null, bool $sortable = true): Column
    {
        $transform = $transform ?? fn($v) => $v ?? __('-/-');

        return new self($name, $title, $visible, $transform, $sortable);
    }

}

<?php

namespace App\DataTable;

use App\Resources\Contract\ResourceInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TableDataResponse extends JsonResource
{
    private ?Table $table = null;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $this->resource->through(
            [$this, 'transformData']
        );

        return parent::toArray($request);
    }

    public function transformData(Model $resource): Model
    {
        foreach ($this->table->getColumns() as $column) {
            if (is_callable($column->getTransform())) {
                $resource[$column->getName()] = call_user_func($column->getTransform(), $resource[$column->getName()], $resource);
            }
        }

        return $resource;
    }

    private function table(Table $table): static
    {
        $this->table = $table;
        return $this;
    }

    public static function create(Table $table, ResourceInterface $resource, Request $request): TableDataResponse|JsonResponse
    {
        $body = json_decode($request->getContent(), true);


        $query = $resource
            ->queryCallback()
            ->select(
                array_map(
                    fn($columnName) => sprintf('%s as %s', $columnName, $columnName),
                    array_merge(
                        array_map(fn(Column $c) => $c->getName(), $resource->getTable()->getColumns()),
                        $resource->getTable()->getSelect()
                    )
                )
            );

        if ($body['search']) {
            $query->where(function ($query) use ($body, $resource) {
                /** @var Column $column */
                foreach ($resource->getTable()->getColumns() as $column) {
                    //FIXME Zastanowić się co z datami ? Każda kolumna powinna mieć typ i na tej podstawie powinien być warunek
                    $query->orWhere($column->getName(), 'like', sprintf('%%%s%%', $body['search']));
                }
            });
        }

        foreach ($body['order'] as $order) {
            $query->orderBy($order['column'], $order['dir']);
        }

        return (new self($query->paginate($resource->getTable()->getPerPage())))->table($table);
    }
}

<?php

namespace App\Resources\Actions;

use App\DataTable\TableDataResponse;
use App\Resources\Contract\ResourceInterface;
use App\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ResourceActions
{
    protected ResourceInterface $resource;

    protected string $routeBase = 'object.';

    public function data(Request $request): TableDataResponse|JsonResponse
    {
        return TableDataResponse::create(
            $this->resource->getTable(),
            $this->resource,
            $request
        );
    }

    public function index() : Response
    {
        return Inertia::render($this->resource->getView(Resource::INDEX_ACTION), [
            'table' => $this->resource->getTable(),
            'objectName' => $this->resource->getResourceName()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return Inertia::render($this->resource->getView(Resource::CREATE_ACTION),[
            'form' => $this->resource->getForm(Resource::CREATE_ACTION)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request): RedirectResponse
    {
        /** @var Model $model */
        $model = new ($this->resource->modelClass())();
        $model->fill($request->validated());

        if ($model->save()){
            return to_route($this->getRoute(Resource::EDIT_ACTION),['competition' => $model->getKey()]);
        }

        return to_route($this->getRoute(Resource::INDEX_ACTION));
    }

    public function edit(Model $model): Response
    {
        return Inertia::render($this->resource->getView(Resource::EDIT_ACTION), [
            'model' => $model,
            'form' => $this->resource->getForm(Resource::EDIT_ACTION),
            'objectName' => $this->resource->getResourceName()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model $model): RedirectResponse
    {
        $model->delete();

        return to_route($this->getRoute(Resource::INDEX_ACTION));
    }

    public function update(FormRequest $request, Model $model): RedirectResponse
    {
        $model->fill($request->validated());

        if ($model->save()){
            return to_route($this->getRoute(Resource::EDIT_ACTION),['competition' => $model->getKey()]);
        }

        return to_route($this->getRoute(Resource::INDEX_ACTION));
    }

    public function show(Model $model): Response
    {
        return Inertia::render($this->resource->getView(Resource::SHOW_ACTION), [
            'model' => $model,
            'form' => $this->resource->getForm(Resource::SHOW_ACTION)
        ]);
    }

    public function getRoute(string $action) : string
    {
        return $this->routeBase.$action;
    }

    public function getResource(): ResourceInterface
    {
        return $this->resource;
    }

    public function setResource(ResourceInterface $resource): ResourceActions
    {
        $this->resource = $resource;
        return $this;
    }

    public function getRouteBase(): string
    {
        return $this->routeBase;
    }

    public function setRouteBase(string $routeBase): ResourceActions
    {
        $this->routeBase = $routeBase;
        return $this;
    }

}

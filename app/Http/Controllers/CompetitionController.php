<?php

namespace App\Http\Controllers;

use App\DataTable\TableDataResponse;
use App\Http\Requests\Competition\StoreRequest;
use App\Http\Requests\Competition\UpdateRequest;
use App\Models\Competition;
use App\Resources\Actions\ResourceActions;
use App\Resources\CompetitionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class CompetitionController extends Controller
{
    protected array $permissions;

    protected ResourceActions $actions;

    public function __construct(CompetitionResource $competitionResource, ResourceActions $resourceActions)
    {
        $this->actions = $resourceActions->setResource($competitionResource)->setRouteBase('competition.');
    }

    public function index(): Response
    {
        return $this->actions->index();
    }

    public function data(Request $request): JsonResponse|TableDataResponse
    {
        return $this->actions->data($request);
    }

    public function create(): Response
    {
        return $this->actions->create();
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        return $this->actions->store($request);
    }

    public function edit(Competition $competition): Response
    {
        return $this->actions->edit($competition);
    }

    public function update(UpdateRequest $request, Competition $competition): RedirectResponse
    {
        return $this->actions->update($request, $competition);
    }

    public function destroy(Competition $competition): RedirectResponse
    {
        return $this->actions->destroy($competition);
    }

    /**
     * Display the specified resource.
     */
    public function show(Competition $competition): Response
    {
        $response =  $this->actions->show($competition);

        $response->with('assignTeamForm', [
        [
            '$formkit' => 'select',
            'name' => 'name',
            'label' => 'Name',
            'children' => '$name',
            'placeholder' => 'Select users',
            'validation' => 'required'
        ]
    ]);

        return $response;
    }

}

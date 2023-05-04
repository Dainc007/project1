<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAsTeam\StoreRequest;
use App\Models\UserAsTeam;
use App\Resources\Actions\ResourceActions;
use App\Resources\UserAsTeamResource;
use Inertia\Response;


class UserAsTeamController extends Controller
{
    protected array $permissions;

    protected ResourceActions $actions;

    public function __construct(UserAsTeamResource $competitionResource, ResourceActions $resourceActions)
    {
        $this->actions = $resourceActions->setResource($competitionResource)->setRouteBase('userAsTeam.');
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

    public function edit(UserAsTeam $userAsTeam): Response
    {
        return $this->actions->edit($userAsTeam);
    }

    public function update(UpdateRequest $request, UserAsTeam $userAsTeam): RedirectResponse
    {
        return $this->actions->update($request, $userAsTeam);
    }

    public function destroy(UserAsTeam $userAsTeam): RedirectResponse
    {
        return $this->actions->destroy($userAsTeam);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAsTeam $userAsTeam): Response
    {
        return $this->actions->show($userAsTeam);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Traits\ApiResponsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponsable;

    public function __construct(private UserInterface $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request) : JsonResponse
    {;
        return $this->respondWithSuccess($this->userService->index($request), 'Success');
    }
    public function store(StoreUserRequest $request)
    {
        return $this->respondCreated($this->userService->store($request));
    }
    public function edit(string $id)
    {
        return $this->respondWithSuccess($this->userService->edit($id), 'Success');
    }
    public function update(UpdateUserRequest $request, string $id)
    {
        return $this->respondWithSuccess($this->userService->update($request, $id), 'User updated successfully');
    }
    public function destroy(string $id)
    {
        return $this->respondNoContent($this->userService->destroy($id));
    }
}

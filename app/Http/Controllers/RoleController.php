<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * get all roles
     * * 200 [roles]
     * * 401 [message]
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles], 200);
    }

    /**
     * get one role
     * * 200 [role]
     * * 401 [message]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): JsonResponse
    {
        $role = Role::find($request->id);
        return response()->json(['role' => $role], 200);
    }

    /**
     * create new role
     * * 201 [role]
     * * 422 [message, errors => nameofinput]
     * * 401 [message]
     *
     * @param RoleCreateRequest $request
     * @return JsonResponse
     */
    public function create(RoleCreateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $role = Role::create($validate);
        return response()->json(['role' => $role], 201);
    }

    /**
     * update a role
     * * 200 [role]
     * * 422 [message, errors => nameofinput]
     * * 401 [message]
     *
     * @param RoleUpdateRequest $request
     * @return JsonResponse
     */
    public function update(RoleUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $role = Role::find($request->id);
        $role->update($validate);
        return response()->json(['role' => $role], 200);
    }

    /**
     * delete one role
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $role = Role::findOrFail($request->id);

        if ($role->users()) {
            return response()->json([
                'message' => 'Des utilisateurs ont ce role, impossible de le supprimer',
                'delete' => false,
            ], 200);
        }

        $role->delete();
        return response()->json([
            'message' => 'Le role a été supprimé',
            'delete' => true,
        ], 200);
    }
}

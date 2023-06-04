<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TenantCreateRequest;
use App\Http\Requests\TenantUpdateRequest;

class TenantController extends Controller
{
    /**
     * get all.
     * * 200 [tenants]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $tenant = Tenant::all();
        return response()->json(['tenants' => $tenant], 200);
    }

    /**
     * get one.
     * * 200 [tenant]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne(Request $request): JsonResponse
    {
        $tenant = Tenant::find($request->id);
        return response()->json(['tenant' => $tenant], 200);
    }

    /**
     * create tenant.
     * * 200 [tenant]
     * * 401 [message]
     * * 422 [message, errors=>inputname]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TenantCreateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $tenant = Tenant::create($validate);
        return response()->json(['tenant' => $tenant], 201);
    }

    /**
     * Update the specified resource in storage.
     * * 200 [tenant]
     * * 401 [message]
     * * 422 [message, errors=>inputname]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TenantUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $tenant = Tenant::find($request->id);
        $tenant->forceFill($validate)->save();
        return response()->json(['tenant' => $tenant], 200);
    }

    /**
     * Remove the specified resource from storage.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $tenant = Tenant::findOrFail($request->id);

        // detach relation with house
        if ($tenant->houses()) {
            foreach ($tenant->houses as $house) {
                $house->tenant()->dissociate();
                $house->save();
            }
        }
        $tenant->delete();
        return response()->json([
            'message' => 'Le locatataire a été supprimé',
            'delete' => true,
        ], 200);
    }
}

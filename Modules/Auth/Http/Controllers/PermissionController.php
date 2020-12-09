<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use const App\Providers\HTTP_OK;

/**
 * @group Auth_Permission
*/
class PermissionController extends Controller
{
    /**
     * permission list.
     * @authenticated
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        return response(Permission::all(),HTTP_OK);
    }


    /**
     * Store a permission.
     * @authenticated
     * @bodyParam name string define permission by name.Example : write,read
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $permission = Permission::create(['name' => $request->get("name")]);
        $permission->save();
        return response($permission,HTTP_OK);
    }

    /**
     * find permission by id.
     * @authenticated
     * @urlParam id integer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function find($id)
    {
        return response(Permission::findById($id),HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @authenticated
     * @urlParam id integer.
     * @return array
     */
    public function update(Request $request, $id)
    {
        $role = Role::findById($id);
        $role->update(["name" => $request->get("name")]);
        return $role->jsonSerialize();
    }

    /**
     * Remove permission by id.
     * @authenticated
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(Role::findById($id)->delete(),HTTP_OK);
    }

    /**
     * assign permission to role.
     * @param Request $request
     * @authenticated
     * @bodyParam role_id integer
     * @bodyParam permission_id integer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function assignPermissionToRole(Request $request)
    {
        $role_id = $request->get("role_id");
        $permission_id = $request->get("permission_id");
        $permissionName = Permission::findById($permission_id)->name;
        return response(Role::findById($role_id)->givePermissionTo($permissionName),HTTP_OK);
    }
}

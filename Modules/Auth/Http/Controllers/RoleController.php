<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PharIo\Manifest\Application;
use Psy\Util\Json;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use const App\Providers\HTTP_OK;

/**
 * @group Auth_Role
 */
class RoleController extends Controller
{
    /**
     * role list.
     * @authenticated
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        return response(Role::all(), HTTP_OK);
    }


    /**
     * find role by id.
     * @authenticated
     * @urlParam  id integer
     * @param int $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function find(int $id)
    {
        return response(Role::findById($id), HTTP_OK);
    }

    /**
     * Store role.
     * @authenticated
     * @bodyParam  name string define role by name. Example : admin
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $role = Role::create(['name' => $request->get("name")]);
        return response($role, HTTP_OK);
    }

    /**
     * Update role name by id.
     * @authenticated
     * @param Request $request
     * @urlParam  id integer.
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $role = Role::findById($id);
        $role->update(["name" => $request->get("name")]);
        return response($role, HTTP_OK);
    }

    /**
     * Remove role by id.
     * @authenticated
     * @urlParam  id integer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return response(Role::findById($id)->delete(), HTTP_OK);
    }
}

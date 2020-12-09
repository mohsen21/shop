<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Models\User;
use Spatie\Permission\Models\Role;
use const App\Providers\HTTP_OK;

/**
 * @group  Auth_User
 *
 * APIs for managing users
 */
class UserController extends Controller
{
    /**
     * users list.
     * @authenticated
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function index()
    {
        return response([
                "user_info" => User::all(),
                "action" => boolval(1),
                "message" => ""
            ]
            , HTTP_OK)->header('Content-Type', 'application/json');

    }

    /**
     * find user by id.
     * @authenticated
     * @urlParam  id int required The id of the user. Example : 9
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function find(int $id=1)
    {
        return response(User::find($id)
            , HTTP_OK)->header('Content-Type', 'application/json');

    }

    /**
     * Update user by id.
     * @param Request $request
     * @authenticated
     * @bodyParam first_name string  .
     * @bodyParam last_name string  .
     * @bodyParam email string  .
     * @bodyParam mobile string  .
     * @bodyParam gender string  .
     * @urlParam  id integer .
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where(["id" => $id]);
        if ($user) {
            $action = $user->update($request->all());
            $userInfo = $user->get();
            return response($userInfo
                , HTTP_OK)->header('Content-Type', 'application/json');
        }
        return response([
                "user_info" => [],
                "action" => boolval(0),
                "message" => ""
            ]
            , HTTP_OK)->header('Content-Type', 'application/json');

    }

    /**
     * Remove user by id.
     * @authenticated
     * @urlParam  id integer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where(["id" => $id]);
        $userInfo = $user->get();
        $action = $user->delete();
        return response($userInfo
            , HTTP_OK)->header('Content-Type', 'application/json');
    }

    /**
     * set role user
     * @authenticated
     * @bodyParam user_id int required .
     * @bodyParam role_id int required .
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function setRoleUser(Request $request)
    {

        $user = User::find($request->get("user_id"));
        $role = Role::findById($request->get("role_id"));

        if ($user) {
            return response($user->assignRole($role)
                , HTTP_OK)->header('Content-Type', 'application/json');
        }

        return response([
                "user_info" => [],
                "action" => boolval($user),
                "message" => ""
            ]
            , HTTP_OK)->header('Content-Type', 'application/json');
    }

    /**
     * find users info by query param
     * @authenticated
     * @queryParam first_name string  .
     * @queryParam last_name string  .
     * @queryParam email string  .
     * @queryParam mobile string  .
     * @queryParam gender string  .
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getUsers(Request $request)
    {
        return response([
                "user_info" => User::where($request->all())->get(),
                "action" => boolval(1),
                "message" => ""
            ]
            , HTTP_OK)->header('Content-Type', 'application/json');

    }
}

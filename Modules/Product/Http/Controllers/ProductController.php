<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Models\Product;
use const App\Providers\HTTP_BAD_REQUEST;
use const App\Providers\HTTP_OK;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Application|ResponseFactory|Renderable|Response
     */
    public function index()
    {
        return  response(Product::all(),HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Application|ResponseFactory|Renderable|Response
     */
    public function store(Request $request)
    {
        if(Product::create($request->toArray())){
            return response(["message"=>trans("message.success")],HTTP_OK);
        }
        return response(["message"=>trans("message.error.bad")],HTTP_BAD_REQUEST);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Application|ResponseFactory|Renderable|Response
     */
    public function show(int $id)
    {
        return response( Product::find($id), HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Application|ResponseFactory|Renderable|Response
     */
    public function update(Request $request, int $id)
    {
        return response(Product::where(['id' => $id])->update($request->toArray()));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Application|ResponseFactory|Renderable|Response
     */
    public function destroy(int $id)
    {
        if (Product::find($id)->delete()) {

            $response = ['message' => trans('message.success')];
            return response($response, HTTP_OK);
        }
        $response = ['message' => trans('message.error.bad')];
        return response($response, HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function getProduct(Request $request)
    {
        $query = $request->query();
        if ($query) {
            return response(Product::where($query)->get(), HTTP_OK);
        }
        return response(['message' => trans('message.error.bad')], HTTP_BAD_REQUEST);

    }
}

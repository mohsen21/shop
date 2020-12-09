<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Models\Cart;
use Modules\Product\Models\Product;
use const App\Providers\HTTP_BAD_REQUEST;
use const App\Providers\HTTP_OK;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function index()
    {
        return  response(Cart::all(),HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Cart::create($request->toArray())){
            return response(["message"=>trans("message.success")],HTTP_OK);
        }
        return response(["message"=>trans("message.error.bad")],HTTP_BAD_REQUEST);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function show($id)
    {
        return response( Cart::find($id), HTTP_OK);
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Renderable|\Illuminate\Http\Response
     */
    public function update(Request $request,int $id)
    {
        return response(Product::where(['id' => $id])->update($request->toArray()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|Application|Response|ResponseFactory
     */
    public function getCart(Request $request)
    {
        $query = $request->query();
        if ($query) {
            return response(Cart::where($query)->get(), HTTP_OK);
        }
        return response(['message' => trans('message.error.bad')], HTTP_BAD_REQUEST);

    }
}

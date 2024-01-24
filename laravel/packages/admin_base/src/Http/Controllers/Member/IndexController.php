<?php
namespace Marol\Http\Controllers\Members;

use Marol\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends AdminController{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'list'=>\Marol\Models\Product::with(['category'])->get(),
            'columns'=>[ 
                ["prop"=>"name","label"=>"名称"],
                ["prop"=>"created_at","label"=>"创建时间"],
                ["prop"=>"updated_at","label"=>"更新时间"],
            ]
        ];
        return Response::return(msg: 'ok', code: '200', data: $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Marol\Http\Requests\StoreProductRequest $request)
    {
        $validated = $request->validated();
        $product = new \Marol\Models\Product;
        foreach($validated as $key=>$val){
            $product->$key=$val;
        }
        $product->creater_id = $request->user()->id;
        $product->save();
        return Response::return(msg: 'ok', code: '200');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = \Marol\Models\Product::find($id);
        return Response::return(msg: 'ok', code: '200', data: $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Marol\Http\Requests\StoreProductRequest $request, string $id)
    {
        $validated = $request->validated();
        $product = \Marol\Models\Product::find($id);
        foreach($validated as $key=>$val){
            $product->$key=$val;
        }
        $product->save();
        return Response::return(msg: 'ok', code: '200');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \Marol\Models\Product::destroy($id);
        return Response::return(msg: 'ok', code: '200');
    }
}
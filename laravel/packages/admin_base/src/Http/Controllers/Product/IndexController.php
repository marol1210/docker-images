<?php
namespace Marol\Http\Controllers\Product;

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
            'data'=>[
                'list'=>\Marol\Models\Product::all(),
                'columns'=>[ 
                    ["prop"=>"name","label"=>"名称"],
                    ["prop"=>"created_at","label"=>"创建时间"],
                    ["prop"=>"updated_at","label"=>"更新时间"],
                ]
            ]
        ];
        return $data;
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
        $product->save();
        return Response::return($msg='ok',$code='200');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        return Response::return($msg='ok',$code='200');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
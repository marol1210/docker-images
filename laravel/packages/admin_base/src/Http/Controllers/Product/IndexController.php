<?php
namespace Marol\Http\Controllers\Product;

use Marol\Http\Controllers\Controller as BaseController;

class IndexController extends BaseController{
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
                    ["prop"=>"updated_at","label"=>"最后更新时间"],
                ]
            ]
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
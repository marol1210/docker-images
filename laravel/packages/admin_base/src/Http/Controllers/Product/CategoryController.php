<?php
namespace Marol\Http\Controllers\Product;

use Marol\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Response;

class CategoryController extends AdminController{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = \Marol\Models\ProductCategory::with(['children.children'])->where('pid',0)->get();
        return Response::return(code: 200, msg: 'ok', data: $data);
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
        return Response::return(code: 200, msg: 'ok', data: \Marol\Models\ProductCategory::find($id));
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
        \Marol\Models\ProductCategory::destroy($id);
        return Response::return(code: 200, msg: 'ok');
    }
}
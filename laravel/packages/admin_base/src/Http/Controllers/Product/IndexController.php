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
            'list'=>\Marol\Models\Product::with(['category','price'])->get(),
            'columns'=>[ 
                ["prop"=>"name","label"=>"名称"],
                ["prop"=>"category","label"=>"类型"],
                ["prop"=>"describe","label"=>"描述"],
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
        $validated = $request->safe()->only(['name','describe']);
        $product = new \Marol\Models\Product;

        //新建商品
        foreach($validated as $key=>$val){
            $product->$key=$val;
        }
        $product->creater_id = $request->user()->id;
        $product->save();

        //商品所属类别
        $product->category()->syncWithoutDetaching([$request->category_id]);

        //商品价格
        $request->whenFilled('price', function (array $input) use($product) {
            $input = collect($input)->map(function($item,$key) use($product){
                if(empty($item['scope'])){
                    $item['scope'] = 'normal';
                }
                $item['created_at'] = date('Y-m-d H:i:s');
                $item['product_id'] = $product->id;
                return $item;
            });
            $product->price()->insert(
                $input->toArray()
            );
        });
        return Response::return(msg: 'ok', code: '200');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = \Marol\Models\Product::with(['category','price','cover_img','detail_img'])->find($id);
        return Response::return(msg: 'ok', code: '200', data: $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Marol\Http\Requests\UpdateProductRequest $request, string $id)
    {
        $validated = $request->safe()->only(['name','describe']);

        $product = \Marol\Models\Product::find($id);
        if(!empty($validated)){
            foreach($validated as $key=>$val){
                $product->$key=$val;
            }
            $product->save();
        }

        $request->whenFilled('category_id', function (string $input) use($product) {
            $product->category()->syncWithoutDetaching([$input]);
        });

        $request->whenFilled('price', function (array $input) use($product,$id) {
            $input = collect($input)->map(function($item,$key) use($product,$id){
                if(empty($item['scope'])){
                    $item['scope'] = 'normal';
                }
                if(!isset($item['describe'])){
                    $item['describe'] = null;
                }
                $item['product_id'] = $id;
                return $item;
            });
            $product->price()->upsert(
                $input->toArray(),
                [],
                ['describe','scope','price']
            );
        });

        return Response::return(msg: 'ok', code: '200' , data: $validated);
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
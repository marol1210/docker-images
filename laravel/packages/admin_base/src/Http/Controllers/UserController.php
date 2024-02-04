<?php
namespace Marol\Http\Controllers;

use Marol\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Response;
use Marol\Http\Requests\Account\SearchRequest;
use Marol\Http\Requests\Account\UpdateRequest;

class UserController extends AdminController{

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $pageSize = $request->query('pageSize', 10);
        $page     = $request->query('page', 1);

        $where = $request->validated();
        $query = \Marol\Models\AdminUser::query();

        $request->whenFilled('name', function (string $name) use($query){
            $query->where('name','like',$name.'%');
        });

        $request->whenFilled('is_active', function (string $is_active) use($query){
            $query->where('is_active',$is_active);
        });

        $items   = $query->paginate($pageSize,page:$page);
        $data = [
            'list'=> $items->items(),
            'paginator'=> [
                'total'=> $items->total(),
                'pageSize'=> $pageSize,
                'currentPage'=> $request->page,
            ],
            'columns'=>[ 
                ["prop"=>"email","label"=>"账号"],
                ["prop"=>"name","label"=>"名称"],
                ["prop"=>"is_active","label"=>"是否激活"],
                // ["prop"=>"deleted_at","label"=>"是否删除"],
                ["prop"=>"created_at","label"=>"创建时间"],
                ["prop"=>"updated_at","label"=>"更新时间"],
            ]
        ];
        return Response::return(msg: 'ok', code: '200', data: $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $validated = $request->validated();
        $role = new \Marol\Models\AdminUser;
        foreach($validated as $key=>$val){
            $role->$key=$val;
        }
        $role->save();
        return Response::return(msg: 'ok', code: '200');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = \Marol\Models\AdminUser::find($id);
        return Response::return(msg: 'ok', code: '200', data: $role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request,string $id)
    {
        $validated = $request->validated();
        $role = \Marol\Models\AdminUser::find($id);
        foreach($validated as $key=>$val){
            $role->$key=$val;
        }
        $role->save();
        return Response::return(msg: 'ok', code: '200');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \Marol\Models\AdminUser::destroy($id);
        return Response::return(msg: 'ok', code: '200');
    }
}
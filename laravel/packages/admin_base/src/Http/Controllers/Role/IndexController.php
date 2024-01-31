<?php
namespace Marol\Http\Controllers\Role;

use Marol\Http\Controllers\AdminController;
use Marol\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class IndexController extends AdminController{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', 10);
        $items   = \Marol\Models\Role::withTrashed()->paginate($pageSize);
        $data = [
            'list'=> $items->items(),
            'paginator'=> [
                'total'=> $items->count(),
                'pageSize'=> $pageSize,
                'currentPage'=> $request->page,
            ],
            'columns'=>[ 
                ["prop"=>"title","label"=>"角色"],
                ["prop"=>"name","label"=>"标识"],
                ["prop"=>"is_active","label"=>"是否禁用"],
                ["prop"=>"deleted_at","label"=>"是否删除"],
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
        $role = new \Marol\Models\Role;
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
        $role = \Marol\Models\Role::find($id);
        return Response::return(msg: 'ok', code: '200', data: $role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $validated = $request->validated();
        $role = \Marol\Models\Role::find($id);
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
        \Marol\Models\Role::destroy($id);
        return Response::return(msg: 'ok', code: '200');
    }
}
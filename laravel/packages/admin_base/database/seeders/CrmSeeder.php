<?php
namespace Marol\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CrmSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->upsert(
            [
                'name' => 'after school',
                'email' => 'mzh1986love@sina.com',
                'password' => Hash::make('password123'),
            ],
            ['email'],
        );
        $this->productDump();
        $this->createRoles();
    }

    public function createRoles(){
        \Marol\Models\Role::truncate();

        $created_at = date('Y-m-d H:i:s');
        \Marol\Models\Role::create(["name"=>"admin","title"=>"超级管理员","remark"=>"系统超级管理员","created_at"=>$created_at]);
        \Marol\Models\Role::create(["name"=>"marketing","title"=>"运营","remark"=>"系统超级管理员","created_at"=>$created_at]);
    }

    public function productDump(){
        \Marol\Models\ProductCategory::truncate();
        \Marol\Models\Product::truncate();

        $category = \Marol\Models\ProductCategory::create(["name"=>"全部","pid"=>0]);

        $category_a = \Marol\Models\ProductCategory::create(["name"=>"消费电子","pid"=>$category->id]);
        $category_mobile = \Marol\Models\ProductCategory::create(["name"=>"手机","pid"=>$category_a->id]);
        $category_pad = \Marol\Models\ProductCategory::create(["name"=>"iPad","pid"=>$category_a->id]);

        $category_b = \Marol\Models\ProductCategory::create(["name"=>"日用家居","pid"=>$category->id]);
        $category_b_1 = \Marol\Models\ProductCategory::create(["name"=>"沙发","pid"=>$category_b->id]);
        $category_b_2 = \Marol\Models\ProductCategory::create(["name"=>"床","pid"=>$category_b->id]);
        $category_b_3 = \Marol\Models\ProductCategory::create(["name"=>"桌/椅","pid"=>$category_b->id]);


        /** meta60 */
        $huawei_mate60 = \Marol\Models\Product::create(
            ['name'=>'华为Meta-60','describe'=>'华为Meta-60','creater_id'=>1],
        );

        $url = asset('https://res.vmallres.com/pimages//uomcdn/CN/pms/202401/gbom/6942103109485/group//428_428_B9BD1A39B563C7ABD4617C22AA673AEE.png');
        $huawei_mate60->image()->updateOrCreate(['is_active'=>'1','use_as'=>'cover','imageable_id'=>$huawei_mate60->id,'imageable_type'=>$huawei_mate60::class],["url" => $url]);

        $url = asset('https://res.vmallres.com/pimages//uomcdn/CN/pms/202401/gbom/6942103109485/group//428_428_B9BD1A39B563C7ABD4617C22AA673AEE.png');
        $huawei_mate60->image()->createMany([
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
        ]);

        /** meta60 */
        $huawei_mate50 = \Marol\Models\Product::create(
            ['name'=>'华为Meta-50','describe'=>'华为Meta-50','creater_id'=>1],
        );

        $url = asset('https://res.vmallres.com/pimages//uomcdn/CN/pms/202401/gbom/6942103109485/group//428_428_B9BD1A39B563C7ABD4617C22AA673AEE.png');
        $huawei_mate50->image()->updateOrCreate(['is_active'=>'1','use_as'=>'cover','imageable_id'=>$huawei_mate50->id,'imageable_type'=>$huawei_mate50::class],["url" => $url]);

        $url = asset('https://res.vmallres.com/pimages//uomcdn/CN/pms/202401/gbom/6942103109485/group//428_428_B9BD1A39B563C7ABD4617C22AA673AEE.png');
        $huawei_mate50->image()->createMany([
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
        ]);

        $huawei_mate50->category()->sync([$category_mobile->id]);
        $huawei_mate60->category()->sync([$category_mobile->id]);

    }
}
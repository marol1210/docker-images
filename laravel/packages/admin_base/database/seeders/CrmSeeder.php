<?php
namespace Database\Seeders;
 
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
        DB::table('users')->insert([
            'name' => 'after school',
            'email' => 'mzh1986love@sina.com',
            'password' => Hash::make('password123'),
        ]);
    }


    public function productDump(){
        $category = \Marol\Models\ProductCategory::create(["name"=>"全部","pid"=>0]);

        $category_a = \Marol\Models\ProductCategory::create(["name"=>"消费电子","pid"=>$category->id]);

        $category_a_1 = \Marol\Models\ProductCategory::create(["name"=>"手机","pid"=>$category_a->id]);
        $category_a_2 = \Marol\Models\ProductCategory::create(["name"=>"iPad","pid"=>$category_a->id]);

        $category_b = \Marol\Models\ProductCategory::create(["name"=>"日用家居","pid"=>$category->id]);

        $category_b_1 = \Marol\Models\ProductCategory::create(["name"=>"沙发","pid"=>$category_b->id]);
        $category_b_2 = \Marol\Models\ProductCategory::create(["name"=>"床","pid"=>$category_b->id]);
        $category_b_3 = \Marol\Models\ProductCategory::create(["name"=>"桌/椅","pid"=>$category_b->id]);
    }
}
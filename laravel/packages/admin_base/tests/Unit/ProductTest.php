<?php
use Orchestra\Testbench\Concerns\WithWorkbench;
use PHPUnit\Framework\Attributes\Test;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use Marol\Models\ImagePolymorphic;
use PHPUnit\Framework\Attributes\Depends;

class ProductTest extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app['config'], function ($config) {
            config([
                'fortify.views' => false
            ]);
        });
    }

    /**
     * mysql | mariadb  connection config
     */
    protected function usesMySqlConnection($app) 
    {
        tap($app['config'], function ($config) {
            $config->set('database.default', 'mysql');
            $config->set('database.connections.mysql', [
                'driver'   => 'mysql',
                'database' => 'laravel',
                'host' => 'laravel-mariadb11-1',
                'port' => '3306',
                'username' => 'root',
                'password' => 123456
            ]);
        });
    }

    #[Test]
    #[DefineEnvironment('usesMySqlConnection')]
    public function login(){
        $email = 'mzh1986love@sina.com';
        $password = 'password123';

        $response = $this->withHeaders(['X-Requested-With'=>'XMLHttpRequest','Accept'=>'application/json'])
                         ->post('/login',['email'=>$email,'password'=>$password]);
        $response->assertSuccessful();

        return \Auth::user();
    }

    #[Test]
    #[Depends('login')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function list_product_by_category($user){
        // $response = $this->get('/sanctum/csrf-cookie');
        // $headerName = 'XSRF-TOKEN';
        // var_dump($response->getCookie($headerName,false)->getValue());
        // $response->assertCookie($headerName);
        // return;
        $response = $this->withHeaders(['X-Requested-With'=>'XMLHttpRequest','Accept'=>'application/json'])
                         ->post('admin/product',[
                            'name'=>'xccc',
                            'describe'=>'333333'
                        ]);
        $response->assertStatus(200);
    }

    // #[Test]
    // #[DefineEnvironment('usesMySqlConnection')]
    public function create_product(){
        \DB::transaction(function () {
            $product = \Marol\Models\Product::first();
            $this->assertNotNull($product);
    
            $this->create_cover_image($product);
            $this->create_detail_image($product);
            $product->refresh();
            //封面图只能1张
            $this->assertEquals(1,$product->image()->where('use_as','cover')->count());
            //详情图可以多张
            $this->assertGreaterThan(1,$product->image()->where('use_as','<>','cover')->count());
        });
    }

    /**
     * 
     * 创建封面图
     */
    protected function create_cover_image(\Marol\Models\Product $product){
        $url = asset('https://res.vmallres.com/pimages//uomcdn/CN/pms/202401/gbom/6942103109485/group//428_428_B9BD1A39B563C7ABD4617C22AA673AEE.png');
        return $product->image()->updateOrCreate(['is_active'=>'1','use_as'=>'cover','imageable_id'=>$product->id,'imageable_type'=>$product::class],["url" => $url]);
    }

    /**
     * 
     * 创建详情图
     */
    protected function create_detail_image(\Marol\Models\Product $product){
        $url = asset('https://res.vmallres.com/pimages//uomcdn/CN/pms/202401/gbom/6942103109485/group//428_428_B9BD1A39B563C7ABD4617C22AA673AEE.png');
        $product->image()->createMany([
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
            ["url" => $url,"use_as" => "detail","is_active"=>"1"],
        ]);
    }
}
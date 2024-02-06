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
                'fortify.views' => false,
                'auth.providers.users.model' => \Marol\Models\AdminUser::class
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

        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Accept'=>'application/json'
                        ])
                         ->postJson('/login',['email'=>$email,'password'=>$password]);
        // $response->assertSuccessful(); //(>= 200 and < 300) HTTP status code
        // $response->assertOk();            //has a 200 HTTP status code
        $user = \Auth::user() ?? null;
        // 'Authorization'=> 'Bearer '.$user->createToken("login_{$user->id}")->plainTextToken
        $this->assertNotNull($user,'未成功登录.');
        return $user;
    }

    // #[Test]
    #[Depends('login')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function create_product($user){
        // $response = $this->get('/sanctum/csrf-cookie');
        // $headerName = 'XSRF-TOKEN';
        // var_dump($response->getCookie($headerName,false)->getValue());
        // $response->assertCookie($headerName);
        // return;
        $response = $this->withHeaders([
                                'X-Requested-With'=>'XMLHttpRequest',
                                'Accept'=>'application/json',
                                'Authorization'=> 'Bearer 3|PW6WHcXd6ISP7PwsQhFgpYRzaP5QPsQIi3RHw7sU309d07e9'
                            ])
                         ->post('admin/product',[
                            'name'=>'华为云-2',
                            'describe'=>'华为云-2',
                            'category_id' => 3,
                            'describe'=>'华为云-2',
                            'price'=>[
                                ['price'=>'299.99','scope'=>'vip'],
                                ['price'=>'399.99','scope'=>'discount'],
                                ['price'=>'499.99','scope'=>'normal']
                            ]
                        ]);
        $response->assertValid();
    }

    #[Test]
    #[Depends('login')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function delete_product(){
        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Accept'=>'application/json',
                            'Authorization'=> 'Bearer 3|PW6WHcXd6ISP7PwsQhFgpYRzaP5QPsQIi3RHw7sU309d07e9'
                        ])
                    ->delete('admin/product/6');
        // $response->assertStatus(200);    
        $response->assertOk();    
    }

    #[Test]
    #[Depends('login')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function show_product(){
        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Authorization'=> 'Bearer 3|PW6WHcXd6ISP7PwsQhFgpYRzaP5QPsQIi3RHw7sU309d07e9'
                        ])
                    ->getJson('admin/product/25');
        
        $response->assertJsonPath('data.category',fn(array $category)=> count($category) > 0);
        return $response->getData(true);
    }

    #[Test]
    #[Depends('login')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function list_product(){
        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Authorization'=> 'Bearer 3|PW6WHcXd6ISP7PwsQhFgpYRzaP5QPsQIi3RHw7sU309d07e9'
                        ])
                    ->getJson('admin/product');

        $response->assertJson(['code'=>200]);
    }

    #[Test]
    #[Depends('show_product')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function update_product($data){
        $category = \Arr::get($data,'data.category');
        $price = \Arr::get($data,'data.price');

        $price = collect($price)->map(function($item,$key){
            unset($item['created_at']);
            unset($item['updated_at']);
            $item['updated_at'] = date('Y-m-d H:i:d');
            return $item;
        });

        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Authorization'=> 'Bearer 3|PW6WHcXd6ISP7PwsQhFgpYRzaP5QPsQIi3RHw7sU309d07e9'
                        ])
                    ->putJson('admin/product/25',[
                        'category_id'=>2,
                        'price'=> $price
                    ]);
        $response->assertValid();
        $response->assertStatus(200)->assertJson(['code'=>200]);
    }
}
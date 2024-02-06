<?php
use Orchestra\Testbench\Concerns\WithWorkbench;
use PHPUnit\Framework\Attributes\Test;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use Marol\Models\ImagePolymorphic;
use PHPUnit\Framework\Attributes\Depends;

class AccountTest extends \Orchestra\Testbench\TestCase
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
        // var_dump($user->createToken("login_{$user->id}")->plainTextToken);
        // 'Authorization'=> 'Bearer '.$user->createToken("login_{$user->id}")->plainTextToken
        $this->assertNotNull($user,'未成功登录.');
        return $user;
    }


    #[Test]
    #[Depends('login')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function create_account($user){
        $create_data =  [
            "name"=>"mzh1986love13@sina.com",
            "email"=>"mzh1986love13@sina.com",
            "password"=>"12345678",
            "password_confirm"=>"12345678",
            "roles"=>[
                ["value"=>"1","label"=>"管理员"],
                ["value"=>"2","label"=>"运营"]
            ],
            "is_active"=>false,
            "is_edit"=>false,
            "selected_roles"=>[1,2]
        ];

        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Accept'=>'application/json',
                            'Authorization'=> 'Bearer 5|eMcUKmcYbk6N8G6uSI6FnTjvVJuSJQx158yofZqP77b6a974'
                        ])
                    ->post('api/account',$create_data);
                    $response->dump();
        $response->assertValid(); 
        $response->assertOk(); 
    }
}
<?php
use Orchestra\Testbench\Concerns\WithWorkbench;
use PHPUnit\Framework\Attributes\Test;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use Marol\Models\ImagePolymorphic;
use PHPUnit\Framework\Attributes\Depends;

class RoleTest extends \Orchestra\Testbench\TestCase
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


    #[Test]
    #[Depends('login')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function create_role($user){
        $create_data = [
            "title"=>"管理员",
            "name"=>"admin"
        ];
        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Accept'=>'application/json',
                            'Authorization'=> 'Bearer 3|PW6WHcXd6ISP7PwsQhFgpYRzaP5QPsQIi3RHw7sU309d07e9'
                        ])
                    ->post('api/role',$create_data);
                    
        $response->assertValid();   
        $response->assertOk();    
    }

    #[Test]
    #[Depends('create_role')]
    #[DefineEnvironment('usesMySqlConnection')]
    public function list_role($user){
        $response = $this->withHeaders([
                            'X-Requested-With'=>'XMLHttpRequest',
                            'Accept'=>'application/json',
                            'Authorization'=> 'Bearer 3|PW6WHcXd6ISP7PwsQhFgpYRzaP5QPsQIi3RHw7sU309d07e9'
                        ])
                    ->get('api/role');  
        $response->assertOk();
    }
}
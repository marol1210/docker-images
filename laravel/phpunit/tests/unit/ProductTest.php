<?php

namespace Tests\Unit;

use Illuminate\Contracts\Config\Repository;
use Orchestra\Testbench\Concerns\WithWorkbench;

class ProductTest extends \Orchestra\Testbench\TestCase {
    use WithWorkbench;
    /**
     * Ignore package discovery from.
     *
     * @return array<int, string>
     */
    public function ignorePackageDiscoveriesFrom()
    {
        return [];
    }

    public function testList(){
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get('admin/product');
        $response->assertStatus(200);
    }
}
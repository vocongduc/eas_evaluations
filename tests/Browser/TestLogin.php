<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
class TestLogin extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_I_can_login_successfully()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                ->visit('/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', '123456')
                ->press('Đăng Nhập')
                ->assertSee('You are logged in!');
        });
    }
}

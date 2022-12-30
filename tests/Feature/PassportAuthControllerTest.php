<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PassportAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@qq.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(200)->assertJson([
            'token' => true,
        ]);
    }


    public function makeRequestSuccessItems(): array
    {
        return [[
            ['name' => 'example1', 'email' => 'example2@gmail.com', 'password' => '12345678',],
            ['name' => 'example2', 'email' => 'example2@gmail.com', 'password' => '12345678',],
        ]];
    }

    /**
     * @dataProvider makeRequestSuccessItems
     */
    public function testRegisterSuccess(array $item)
    {
        $response = $this->postJson('/api/register', $item);
        $response->assertStatus(200)->assertJson(['token' => true]);
        unset($item['password']);
        $this->assertDatabaseHas('users', $item);
    }

}

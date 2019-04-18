<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User;
use \Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Database;
use Faker;

class UserTest extends TestCase {

//use DatabaseTransactions; Caso queira fazer testes sem inserções no banco de dados, descomentar. A linha 31 deve ser comentada.
    /**
     * Teste básico para a criação de usuários.
     *
     * @return void
     */
    public function test_create_user() {

        $faker = Faker\Factory::create();

        $test = \App\User::create([
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt(123456)
        ]);

        $this->assertDatabaseHas('users', ['name' => $test->name]);
    }

}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User;
use \Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database;
use Faker;
use Carbon\Carbon;
use App\Event;

class EventTest extends TestCase {

    /**
     * Testa se os eventos podem ser criados
     *
     * @return void
     */
    public function testEventCanBeCreated() {
        $faker = Faker\Factory::create();

        $testUser = \App\User::create([
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt(123456)
        ]);

        $this->assertDatabaseHas('users', ['name' => $testUser->name]);

        $testEvent = \App\Event::create([
                    'description' => $faker->word,
                    'scheduling' => Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->addDays(5)->day, 12),
                    'user_id' => $testUser->id
        ]);

        $this->assertDatabaseHas('users', ['name' => $testUser->name]);
        $this->assertDatabaseHas('events', [
            'description' => $testEvent->description,
            'user_id' => $testUser->id
        ]);

        $this->assertTrue(true);
    }

    public function test_get_event_by_user() {
        //Garante a integridade e os relacionamentos entre as tabelas User e Event
        $faker = Faker\Factory::create();
        $testUser = \App\User::create([
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt(123456)
        ]);

        $testEvent = \App\Event::create([
                    'description' => $faker->word,
                    'scheduling' => Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->addDays(5)->day, 12),
                    'user_id' => $testUser->id
        ]);

        $event = \App\Event::find($testEvent->id);

        $result = $testUser->event;
        //Compara a colection criada com umapesquisa
        $this->assertEquals($event, $result[0]);
    }

    public function test_create_user_and_event_with_service() {
        
        //Classe muito importante, garante que um usuário pode ser criado através de um Service!
        $faker = Faker\Factory::create();
        $data = [
            'name' => 'Eliot',
            'email' => $faker->email,
            'password' => 'testando123',
            'description' => 'Uma descrição qualquer',
            'scheduling' => Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->addDays(5)->day, 12),
        ];
        
        $userService = new \App\Services\UserService();
        $user = $userService->create($data);
        
        $expected = \App\User::find($user);
        
        $this->assertEquals($expected->id, $user);
    }

}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Faker;
use App\User;
use App\Event;
use Carbon\Carbon;

class PostsRequestsTest extends TestCase {

    use WithoutMiddleware;

    /**
     * Funções para testes em requisições ajax
     *
     * @return void
     */
    public function test_create_scheduling_by_post_method() {

        $response = $this->withHeaders([
                    //Para o CSRF do Laravel
                    'X-CSRF-TOKEN' => csrf_token(),
                ])
                ->json('POST', 'event/store', [
            'desc' => 'Uma breve descrição para o teste',
            'hour' => 10,
            'date' => Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->addDays(5)->day, 12),
            'user_id' => User::select()->first()->id
        ]);
        $response
                ->assertJson([
                    //A reserva foi realizada.
                    'created' => true,
        ]);
    }

    public function test_delete_scheduling_by_post_method() {

      $response = $this->withHeaders([
                    //Para o CSRF do Laravel
                    'X-CSRF-TOKEN' => csrf_token(),
                ])
                ->json('POST', 'event/delete', [
            'id' => Event::select()->first()->id
        ]);
        $response
                ->assertJson([
                    //A reserva foi excluida.
                    'response' => true,
        ]);
    }

}

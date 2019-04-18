<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;



class ViewTest extends TestCase
{
    /**
     * Classe para testar as chamadas de views de login e cadastro
     *
     * @return void
     */
    public function testViewPoint()
    {
        
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }
}
    
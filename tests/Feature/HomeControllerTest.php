<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHomeAsGuest()
    {
        $this->get('/')
            ->assertRedirect('/login');
    }

    public function testHomeAsMember()
    {
        $this->withSession([
            'username' => 'reza'
        ])->get('/')
            ->assertRedirect('/todolist');
    }
}

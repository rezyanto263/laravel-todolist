<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertViewIs('user.login');
    }

    public function testLoginPageWithMemberSession()
    {
        $this->withSession([
            'username' => 'reza'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'username' => 'reza',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('username', 'reza');
    }

    public function testLoginForUserAlreadyLoggedIn()
    {
        $this->withSession([
            'username' => 'reza',
        ])->post('/login', [
            'username' => 'reza',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText('Username and password is required!');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'username' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('Username or password is wrong!');
    }

    public function testLogoutAsGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }


}

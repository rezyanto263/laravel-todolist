<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolistPageAsGuest()
    {
        $this->get('/todolist')
            ->assertRedirect('/');
    }

    public function testTodolistPageAsMember()
    {
        $this->withSession([
            'username' => 'reza'
        ])->get('/todolist')
            ->assertViewIs('todolist.todolist');
    }

    public function testTodolist()
    {
        $this->withSession([
            'username' => 'reza',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Ngopi'
                ],
                [
                    'id' => '2',
                    'todo' => 'Ngoding'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('Ngopi')
            ->assertSeeText('2')
            ->assertSeeText('Ngoding');
    }

    public function testSaveTodoFailed()
    {
        $this->withSession([
            'username' => 'reza'
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required!');
    }

    public function testSaveTodoSuccess()
    {
        $this->withSession([
            'username' => 'reza'
        ])->post('/todolist', [
            'todo' => 'Ngoding'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodo()
    {
        $this->withSession([
            'username' => 'reza',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Ngopi'
                ],
                [
                    'id' => '2',
                    'todo' => 'Ngoding'
                ]
            ]
        ])->post('/todolist/2/delete')
            ->assertRedirect('/todolist')
            ->assertSessionHas('todolist', [
                [
                    'id' => '1',
                    'todo' => 'Ngopi'
                ]
            ])->assertSessionMissing('2');
    }
}

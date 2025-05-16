<?php

namespace Tests\Feature;

use App\Models\Todo;
use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('DELETE FROM todos');
    }

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
        $this->seed(TodoSeeder::class);

        $this->withSession([
            'username' => 'reza'
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('ngopi')
            ->assertSeeText('2')
            ->assertSeeText('makan');
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
        $this->seed([TodoSeeder::class]);
        $todo = Todo::query();

        self::assertEquals(2, $todo->count());
        
        $this->withSession([
            'username' => 'reza'
        ])->post('/todolist/2/delete')
            ->assertRedirect('/todolist');


        $expected = [
            [
                'id' => '1',
                'todo' => 'ngopi'
            ]
        ];
        Assert::assertArraySubset($expected, $todo->get()->toArray());
        self::assertEquals(1, $todo->count());
    }
}

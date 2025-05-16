<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{
    public function saveTodo(string $id, string $todo): void
    {
        Todo::create([
            'id' => $id,
            'todo' => $todo
        ]);
    }

    public function getTodolist(): array
    {
        return Todo::all()->toArray();
    }

    public function removeTodo(string $todoId): void
    {
        Todo::where('id', $todoId)->delete();
    }
}

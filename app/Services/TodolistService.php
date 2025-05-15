<?php

namespace App\Services;

interface TodolistService
{
    function saveTodo(string $id, string $todo): void;
    function getTodolist(): array;
    function removeTodo(string $todoId): void;
}

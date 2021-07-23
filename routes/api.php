<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilgithubController;

Route::get('/ping', function () {
    $output = new Symfony\Component\Console\Output\ConsoleOutput();
    $output->writeln("is Alive!");
    return ['is Alive!'];
});
Route::get('/', function () {
    $output = new Symfony\Component\Console\Output\ConsoleOutput();
    $output->writeln("is Alive!");
    return ['is Alive!'];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/user', [AuthController::class, 'create']);
Route::get('/user', [UserController::class, 'read']);
Route::put('/user', [UserController::class, 'update']);

Route::get('/getPerfilGitHub/{username}', [PerfilgithubController::class, 'getPerfilGitHub']);
Route::post('/getPerfilGitHub', [PerfilgithubController::class, 'store']);
Route::get('/getPerfilGitHub', [PerfilgithubController::class, 'index']);
Route::delete('/getPerfilGitHub/{id}', [PerfilgithubController::class, 'destroy']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller\EstudianteController;

Route::get('/GetEstudiante', [EstudianteController::class, 'Index']);
Route::post('/CreateEstudiante', [EstudianteController::class, 'Create']);


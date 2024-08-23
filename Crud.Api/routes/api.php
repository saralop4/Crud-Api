<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller\EstudianteController;

Route::get('/GetAllEstudiantes', [EstudianteController::class, 'GetAll']);
Route::post('/CreateEstudiante', [EstudianteController::class, 'Create']);
Route::get('/GetEstudianteForId/{id}', [EstudianteController::class, 'GetForId']);
Route::delete('/DeleteEstudianteForId/{id}', [EstudianteController::class, 'Delete']);
Route::put('/UpdateEstudiante/{id}', [EstudianteController::class, 'Update']);
Route::patch('/PatchEstudiante/{id}', [EstudianteController::class, 'Patch']);






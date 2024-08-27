<?php


use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\EstudianteController;

Route::prefix('v1')->group(function(){

    Route::get('/GetAllEstudiantes', [EstudianteController::class, 'GetAll']);
    Route::post('/CreateEstudiante', [EstudianteController::class, 'Create']);
    Route::get('/GetEstudianteForId/{id}', [EstudianteController::class, 'GetForId']);
    Route::delete('/DeleteEstudianteForId/{id}', [EstudianteController::class, 'Delete']);
    Route::put('/UpdateEstudiante/{id}', [EstudianteController::class, 'Update']);
    Route::patch('/PatchEstudiante/{id}', [EstudianteController::class, 'Patch']);

});

//http://127.0.0.1:8000/api/documentation

//Route::apiResource('Estudiante', EstudianteController::class);




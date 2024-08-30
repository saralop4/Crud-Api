<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\EstudianteServices;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;


class EstudianteController
{
    private $estudianteService;

    public function __construct(EstudianteServices $estudianteService)
    {
        $this->estudianteService = $estudianteService;
    }

    public function GetAll()
    {
        $response = $this->estudianteService->getAllEstudiantes();
        return $response;
    }

    public function Create(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|max:255',
                'correo' => 'required|email|unique:estudiantes',
                'telefono' => 'required|digits:10',
                'lenguaje' => 'required',
            ]);

            $response = $this->estudianteService->createEstudiante($request->all());
            return response()->json($response, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }
    public function GetForId($id)
    {
        $response = $this->estudianteService->getEstudianteById($id);
        return $response;
    }


    public function Delete($id)
    {
        $response = $this->estudianteService->deleteEstudiante($id);
        return $response;
    }


    public function Update(Request $request, $id)
    {
        try{

        $validatedData= $request->validate([
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:estudiantes',
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required',
        ]);

        $response = $this->estudianteService->updateEstudiante($validatedData, $id);
        return $response;

        }catch (ValidationException $e) {
            return response()->json([
                'errores de validacion' => $e->errors()
            ], 422);
        }
    }

    public function Patch(Request $request, $id)
    {
        try{

        $validatedData = $request->validate([
            'nombre' => 'nullable|max:255|unique:estudiantes,nombre,' . $id,
            'correo' => 'nullable|email|unique:estudiantes,correo,' . $id,
            'telefono' => 'nullable|digits:10',
            'lenguaje' => 'nullable|max:255',
        ]);

        $response = $this->estudianteService->patchEstudiante($validatedData, $id);
        return $response;
        } catch (ValidationException $e) {
            return response()->json([
                'errores de validacion' => $e->errors()
            ], 422);
        }
    }
}

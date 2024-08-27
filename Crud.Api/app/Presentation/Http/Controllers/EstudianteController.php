<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\EstudianteServices;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EstudianteController
{
    private $estudianteService;


    public function __construct(EstudianteServices $estudianteService) {
        $this->estudianteService = $estudianteService;
    }

    public function GetAll()
    {
       $response= $this->estudianteService->getAllEstudiantes();
        return $response;
    }

    public function Create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:estudiantes',
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required',
        ]);

        $response =  $this->estudianteService->createEstudiante($request->all());;
        return $response;
    }

    public function GetForId($id)
    {

       $response=  $this->estudianteService->getEstudianteById($id);
        return $response;
    }

    public function Delete($id)
    {

       $response= $this->estudianteService->deleteEstudiante($id);
        return $response;
    }

    public function Update(Request $request, $id): JsonResponse
    {
        $validatedData= $request->validate([
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:estudiantes,correo,' . $id,
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required',
        ]);


        $response= $this->estudianteService->updateEstudiante($id, $validatedData);
        return $response;
    }

    public function Patch(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'nullable|max:255|unique:estudiantes,nombre,' . $id, // Ignorar el nombre del estudiante actual
            'correo' => 'nullable|email|unique:estudiantes,correo,' . $id, // Ignorar el correo del estudiante actual
            'telefono' => 'nullable|digits:10',
            'lenguaje' => 'nullable|max:255',
        ]);

        $response= $this->estudianteService->patchEstudiante($validatedData, $id);
        return $response;
    }
}

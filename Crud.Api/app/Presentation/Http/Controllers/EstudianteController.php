<?php

namespace App\Presentation\Http\Controllers;


use App\Application\UseCases\Estudiante\CreateEstudiante;
use App\Application\UseCases\Estudiante\DeleteEstudiante;
use App\Application\UseCases\Estudiante\GetAllEstudiante;
use App\Application\UseCases\Estudiante\GetEstudianteById;
use App\Application\UseCases\Estudiante\PatchEstudiante;
use App\Application\UseCases\Estudiante\UpdateEstudiante;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EstudianteController
{
    private $createEstudiante;
    private $getAllEstudiante;
    private $getEstudiante;
    private $deleteEstudiante;
    private $updateEstudiante;
    private $patchEstudiante;

    public function __construct(
        CreateEstudiante $createEstudiante,
        GetAllEstudiante $getAllEstudiante,
        GetEstudianteById $getEstudiante,
        DeleteEstudiante $deleteEstudiante,
        UpdateEstudiante $updateEstudiante,
        PatchEstudiante $patchEstudiante
    ) {
        $this->createEstudiante = $createEstudiante;
        $this->getAllEstudiante = $getAllEstudiante;
        $this->getEstudiante = $getEstudiante;
        $this->deleteEstudiante = $deleteEstudiante;
        $this->updateEstudiante = $updateEstudiante;
        $this->patchEstudiante = $patchEstudiante;
    }

    public function GetAll()
    {
       $response= $this->getAllEstudiante->execute();
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

        $response =  $this->createEstudiante->execute($request->all());;
        return $response;
    }

    public function GetForId($id)
    {

       $response=  $this->getEstudiante->execute($id);
        return $response;
    }

    public function Delete($id)
    {

       $response= $this->deleteEstudiante->execute($id);
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


        $response= $this->updateEstudiante->execute($id, $validatedData);
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

        $response= $this->patchEstudiante->execute($validatedData, $id);
        return $response;
    }
}

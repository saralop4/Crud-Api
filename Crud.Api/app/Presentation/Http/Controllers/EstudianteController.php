<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\EstudianteServices;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Info(
 *     title="Api Estudiante",
 *     version="1.0.0",
 *     description="se implemento arquitectura limpia, principios solid y buenas practicas",
 *     @OA\Contact(
 *         email="fullred@miapi.com"
 *     ),
 *     @OA\License(
 *         name="Proprietary",
 *         url="http://www.fullred.com/licencia"
 *     )
 * )
 */

class EstudianteController
{
    private $estudianteService;

    public function __construct(EstudianteServices $estudianteService)
    {
        $this->estudianteService = $estudianteService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/GetAllEstudiantes",
     *     summary="Obtener todos los estudiantes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de estudiantes"
     *     )
     * )
     */
    public function GetAll()
    {
        $response = $this->estudianteService->getAllEstudiantes();
        return $response;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/CreateEstudiante",
     *     summary="Crear un nuevo estudiante",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Perez"),
     *             @OA\Property(property="correo", type="string", example="juan.perez@example.com"),
     *             @OA\Property(property="telefono", type="string", example="1234567890"),
     *             @OA\Property(property="lenguaje", type="string", example="Español")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Estudiante creado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function Create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:estudiantes',
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required',
        ]);

        $response = $this->estudianteService->createEstudiante($request->all());
        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/GetEstudianteForId/{id}",
     *     summary="Obtener un estudiante por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del estudiante"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     )
     * )
     */
    public function GetForId($id)
    {
        $response = $this->estudianteService->getEstudianteById($id);
        return $response;
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/DeleteEstudianteForId/{id}",
     *     summary="Eliminar un estudiante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estudiante eliminado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     )
     * )
     */
    public function Delete($id)
    {
        $response = $this->estudianteService->deleteEstudiante($id);
        return $response;
    }

    /**
     * @OA\Put(
     *     path="/api/v1/UpdateEstudiante/{id}",
     *     summary="Actualizar un estudiante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Perez"),
     *             @OA\Property(property="correo", type="string", example="juan.perez@example.com"),
     *             @OA\Property(property="telefono", type="string", example="1234567890"),
     *             @OA\Property(property="lenguaje", type="string", example="Español")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estudiante actualizado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     )
     * )
     */
    public function Update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:estudiantes,correo,' . $id,
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required',
        ]);

        $response = $this->estudianteService->updateEstudiante($id, $validatedData);
        return $response;
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/PatchEstudiante/{id}",
     *     summary="Actualizar parcialmente un estudiante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Perez"),
     *             @OA\Property(property="correo", type="string", example="juan.perez@example.com"),
     *             @OA\Property(property="telefono", type="string", example="1234567890"),
     *             @OA\Property(property="lenguaje", type="string", example="Español")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estudiante actualizado parcialmente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     )
     * )
     */
    public function Patch(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'nullable|max:255|unique:estudiantes,nombre,' . $id,
            'correo' => 'nullable|email|unique:estudiantes,correo,' . $id,
            'telefono' => 'nullable|digits:10',
            'lenguaje' => 'nullable|max:255',
        ]);

        $response = $this->estudianteService->patchEstudiante($validatedData, $id);
        return $response;
    }
}

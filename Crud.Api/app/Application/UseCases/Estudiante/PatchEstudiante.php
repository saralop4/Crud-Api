<?php

namespace App\Application\UseCases\Estudiante;

use App\Domain\Interfaces\EstudianteInterface;
use App\Domain\Response\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;




class PatchEstudiante
{
    private $estudianteInterface;

    public function __construct(EstudianteInterface $estudianteInterface)
    {
        $this->estudianteInterface = $estudianteInterface;
    }
    public function execute(array $data, $id)
    {
        try {
            $estudiante = $this->estudianteInterface->findById($id);

            // Definir las claves permitidas
            $allowedKeys = ['nombre', 'correo', 'telefono', 'lenguaje'];
            // Filtrar los datos para obtener solo las claves permitidas
            $datosActualizar = array_intersect_key($data, array_flip($allowedKeys));

            $estudiante->patchEstudiante(array_filter($datosActualizar));

            return ApiResponse::ResponseSuccess('Estudiante actualizado correctamente', 200, $estudiante);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::ResponseError('Error al actualizar los datos del estudiante: ' . $e->getMessage(), 500);
        }
    }


}

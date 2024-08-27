<?php

namespace App\Application\UseCases\Estudiante;

use App\Application\Services\EstudianteServices;
use App\Domain\Response\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteEstudiante
{
    private $estudianteService;

    public function __construct(EstudianteServices $estudianteService)
    {
        $this->estudianteService = $estudianteService;
    }

    public function execute($id)
    {
        try {
            $estudiante = $this->estudianteService->getEstudianteById($id);
            $this->estudianteService->deleteEstudiante($estudiante);

            return ApiResponse::ResponseSuccess('Estudiante Eliminado Exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante No Encontrado - ' . $e->getMessage(), 404);
        } catch (\Exception $ex) {
            return ApiResponse::ResponseError('Hubo un error y no se pudo eliminar el registro - ' . $ex->getMessage(), 500);
        }
    }
}


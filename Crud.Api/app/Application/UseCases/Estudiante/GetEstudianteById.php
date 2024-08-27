<?php

namespace App\Application\UseCases\Estudiante;

use App\Application\Services\EstudianteServices;
use App\Domain\Response\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetEstudianteById
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
            return ApiResponse::ResponseSuccess('Estudiante Obtenido Exitosamente', 200, $estudiante);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante No Encontrado - ' . $e->getMessage(), 404);
        }
    }
}

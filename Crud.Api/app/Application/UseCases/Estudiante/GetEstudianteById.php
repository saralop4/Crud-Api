<?php

namespace App\Application\UseCases\Estudiante;

use App\Domain\Interfaces\EstudianteInterface;
use App\Domain\Response\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetEstudianteById
{
    private $estudianteInterface;

    public function __construct(EstudianteInterface $estudianteInterface)
    {
        $this->estudianteInterface = $estudianteInterface;
    }
    public function execute($id)
    {
        try {
            $estudiante = $this->estudianteInterface->findById($id);
            return ApiResponse::ResponseSuccess('Estudiante Obtenido Exitosamente', 200, $estudiante);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante No Encontrado - ' . $e->getMessage(), 404);
        }
    }
}

<?php

namespace App\Application\UseCases\Estudiante;

use App\Domain\Interfaces\EstudianteInterface;
use App\Domain\Response\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteEstudiante
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
            $this->estudianteInterface->delete($estudiante);

            return ApiResponse::ResponseSuccess('Estudiante Eliminado Exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante No Encontrado - ' . $e->getMessage(), 404);
        } catch (\Exception $ex) {
            return ApiResponse::ResponseError('Hubo un error y no se pudo eliminar el registro - ' . $ex->getMessage(), 500);
        }
    }
}


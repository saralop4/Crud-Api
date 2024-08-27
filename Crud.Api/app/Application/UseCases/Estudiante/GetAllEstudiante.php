<?php

namespace App\Application\UseCases\Estudiante;

use App\Domain\Interfaces\EstudianteInterface;
use App\Domain\Response\ApiResponse;

class GetAllEstudiante{

    private $estudianteInterface;

    public function __construct(EstudianteInterface $estudianteInterface)
    {
        $this->estudianteInterface = $estudianteInterface;
    }

    public function execute(){
        try{

            $estudiante = $this->estudianteInterface->getAll();
            if (!$estudiante->isEmpty()) {
                return ApiResponse::ResponseSuccess('Listado exitoso', 200, $estudiante);
            }

            return ApiResponse::ResponseSuccess('No hay información para mostrar', 200);
        } catch (\Exception $ex) {
            return ApiResponse::ResponseError('Ha ocurrido un error de servidor - ' . $ex->getMessage(), 500);
        }
    }
}

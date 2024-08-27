<?php

namespace App\Application\UseCases\Estudiante;

use App\Application\Services\EstudianteServices;
use App\Domain\Response\ApiResponse;

class GetAllEstudiante{

    private $estudianteService;

    public function __construct(EstudianteServices $estudianteService)
    {
        $this->estudianteService = $estudianteService;
    }

    public function execute(){
        try{

            $estudiante = $this->estudianteService->getAllEstudiantes();
            if (!$estudiante->isEmpty()) {
                return ApiResponse::ResponseSuccess('Listado exitoso', 200, $estudiante);
            }

            return ApiResponse::ResponseSuccess('No hay información para mostrar', 200);
        } catch (\Exception $ex) {
            return ApiResponse::ResponseError('Ha ocurrido un error de servidor - ' . $ex->getMessage(), 500);
        }
    }
}

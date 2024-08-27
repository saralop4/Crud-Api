<?php

namespace App\Application\UseCases\Estudiante;

use App\Application\Services\EstudianteServices;
use App\Domain\Response\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateEstudiante
{
    private $estudianteService;

    public function __construct(EstudianteServices $estudianteService)
    {
        $this->estudianteService = $estudianteService;
    }

    public function execute(array $data, $id)
    {
        try {
            $estudiante = $this->estudianteService->getEstudianteById($id);

            $this->estudianteService->updateEstudiante($estudiante, $data);

            return ApiResponse::ResponseSuccess('Estudiante Actualizado Exitosamente', 200, $estudiante);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante No Encontrado - ' . $e->getMessage(), 404);
        } catch (ValidationException $e) {
            $erroresValidaciones = $e->validator->errors()->toArray();
            return ApiResponse::ResponseError('Error de validación - ' . $e->getMessage(), 422, $erroresValidaciones);
        }
    }
}

<?php

namespace App\Application\Services;

use App\Domain\Interfaces\EstudianteInterface;

class EstudianteServices
{

    private $estudianteInterface;

    public function __construct(EstudianteInterface $estudianteInterface)
    {
        $this->estudianteInterface = $estudianteInterface;
    }

    public function getAllEstudiantes()
    {
        return $this->estudianteInterface->getAll();
    }

    public function createEstudiante(array $data)
    {
        // Validaciones y lógica de negocio
        return $this->estudianteInterface->create($data);
    }

    public function getEstudianteById($id)
    {
        return $this->estudianteInterface->findById($id);
    }

    public function deleteEstudiante($id)
    {
        return $this->estudianteInterface->delete($id);
    }

    public function updateEstudiante($id, array $data)
    {
        return $this->estudianteInterface->update($id, $data);
    }

    public function patchEstudiante(array $data, $id)
    {
        return $this->estudianteInterface->patch($data, $id);
    }
}

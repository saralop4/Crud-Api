<?php

namespace App\Domain\Interfaces;

interface EstudianteInterface{

    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function Patch(array $data, $id);

}

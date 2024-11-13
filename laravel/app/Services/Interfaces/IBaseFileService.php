<?php


namespace App\Services\Interfaces;

interface IBaseFileService
{
    public function getById(int $id);
    public function getRootByUser(int $userId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}

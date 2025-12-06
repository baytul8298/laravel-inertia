<?php

namespace App\Interface;

interface SkillRepositoryInterface
{
    public function all();
    public function find($id);
    public function store($request, array $data);
    public function update($id, $request, array $data);
    public function delete($id);
}

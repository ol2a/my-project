<?php

namespace App\Contracts;

interface CrudInterface
{
    public function index(?array $with);
    public function show(int $id, ?array $with);
    public function store($request);
    public function update($request);
    public function delete(int $id);
    public function boot($model , ?int $paginate = 10);
}

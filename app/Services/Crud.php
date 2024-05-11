<?php

namespace App\Services;

use App\Contracts\CrudInterface;

class Crud implements CrudInterface
{
    private $model;
    private int $paginate = 10;

    public function boot($model , ?int $paginate = 10)
    {
        $this->model = $model;
        $this->paginate = $paginate;
    }

    public function index(?array $with)
    {

        if($with){
            return $this->model::wiht($with)->paginate($this->paginate);
        }

        return $this->model::paginate($this->paginate);
    }

    public function show(int $id, ?array $with)
    {
        if($with){
            return $this->model::wiht($with)->find($id);
        }

        return $this->model::find($id);
    }

    public function store($request)
    {
       return $this->model::create($request);
    }

    public function update($request)
    {
        return $this->model::update($request);
    }

    public function delete(int $id)
    {
        $data = $this->show($id , []);
        $data->delete();
        return $data;
    }

}

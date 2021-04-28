<?php

namespace App\Foundation\AbstractModules\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    /**
     * @var Model $classModel
     */
    public $classModel;

    /**
     * @param array $with
     * @param array $where
     * @return Collection
     */
    public function getWithWhere(array $with, array $where){
        return $this->classModel::with($with)->where($where)->get();
    }

    /**
     * @param array $with
     * @param array $where
     * @return null|Model
     */
    public function getWithWhereSingle(array $with, array $where){
        return $this->classModel::with($with)->where($where)->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(Model $model, array $attributes){
        $model = $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param $where
     * @return bool
     */
    public function deleteWhere(array $where){
        return $this->classModel::where($where)->delete();
    }

    /**
     * @return Model
     */
    protected function createClass()
    {
        return new $this->classModel;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function insert(array $data){
        $model = $this->createClass()->fill($data);

        $model->save();
        return $model;
    }
}
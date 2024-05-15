<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param $id
     * @param string[] $relations
     *
     * @return mixed
     */
    public function find($id, array $relations = []);

    /**
     * Find model by id.
     *
     * @param  $id
     * @param string[] $relations
     *
     * @return mixed
     */
    public function findOrFail($id, array $relations = []);

    /**
     * @param string[] $columns
     *
     * @return mixed
     */
    public function findAll(array $columns = ['*']);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array | int $ids
     * @param array $attributes
     *
     * @return mixed
     */
    public function update($ids, array $attributes);

    /**
     * Delete model.
     *
     * @param Model $entity
     *
     * @return void
     */
    public function delete(Model $entity);

    /**
     * Delete mutiple item.
     *
     * @param array $ids
     *
     * @return bool
     */
    public function deleteMulti(array $ids = []);

    /**
     * Find by condition .
     *
     * @param mixed $condition
     * @param array $relations
     * @param array $relationCounts
     *
     * @return object $entities
     */
    public function findByCondition(mixed $condition, array $relations = [], array $relationCounts = []);
}

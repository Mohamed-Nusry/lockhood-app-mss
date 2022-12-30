<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Container\Container as App;
use Exception;
use Illuminate\Database\Eloquent\Model;

class SupplierRepository
{

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }


    public function model()
    {
        return Supplier::class;
    }

    public function filterData(array $filter, $query)
    {

    }

    public function create(array $data)
    {
        $model = $this->model->newInstance($data);
        $model->save();
        return $model;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update(array $data, $id)
    {
        $query = $this->newQuery();
        $model = $query->findOrFail($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    /**
     * @param $id
     *
     * @return bool|int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = array('*'))
    {
        return $this->model->all($columns);
    }

    public function makeModel()
    {
        return $this->setModel($this->model());
    }

    public function setModel($eloquentModel)
    {
        $model = $this->app->make($eloquentModel);

        if (!$model instanceof Model) {
            throw new Exception("Class {$model} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }


    /**
     * Get paginated filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $filter, array $columns = ['*'], $perPage = 10)
    {
        return $this->getFilterQuery($filter)->paginate($perPage, $columns);
    }

    /**
     * Get all filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(array $filter, array $columns = ['*'], $skip = null, $limit = null)
    {
        $query = $this->getFilterQuery($filter);

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }
        return $query->get($columns);
    }

    /**
     * Get query filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getFilterQuery(array $filter)
    {
        $query = $this->newQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query;
    }

    /**
     * @param string $attribute
     * @param string|int $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy(string $attribute, string|int $value, array $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return $this->model->newQuery();
    }

}

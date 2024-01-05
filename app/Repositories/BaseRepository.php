<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;


abstract class BaseRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @return mixed
     */
    abstract function model();

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new ModelNotFoundException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model->newQuery();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function resetModel()
    {
        return $this->makeModel();
    }

    /**
     * Get table name
     *
     * @return mixed
     */
    public function getTable()
    {
        return $this->getModel()->getTable();
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->method('getModel');
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function method($name)
    {
        $argList = func_get_args();
        unset($argList[0]);

        return $this->model->{$name}(...$argList);
    }

    /**
     * @param object $params
     *
     * @return int
     */
    protected function getLimitPaginate($params)
    {
        return (! empty($params->option('limit'))) ? $params->option('limit') : 10;
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->filter($columns);

        return $this->method('get');
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function count($params)
    {
        $this->filter($params);

        return $this->method('count');
    }

    public function paginate($limit = null, $perPage = null, $columns = ['*'], $pageName = 'page',$method = "paginate")
    {
        return $this->method($method, $limit, $columns, $pageName,$perPage);
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->method('find', $id);
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function first($params)
    {
        $this->filter($params);

        return $this->method('first');
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function create($params)
    {
        return $this->method('create', $params);
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function update($id, object $params)
    {
        $this->mask($params);

        return $this->method('update', $id, $params);
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function updateOrCreate($params)
    {
        return $this->method('updateOrCreate', $params->option(), $params->get());
    }

    /**
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $this->filter($id);
        $data = $this->find($id);

        if (!$data) {
            throw new \Exception('Model not found');
        }

        return $this->method('delete');
    }

    /**
     * Filter for select
     *
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    protected function filter($params)
    {
        return $this;
    }

    /**
     * Filter for update
     *
     * @param object $params
     *
     * @internal params array $data
     * @internal params array $options
     *
     * @return mixed
     */
    protected function mask($params)
    {
        return $this;
    }

}

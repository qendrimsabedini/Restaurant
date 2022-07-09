<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;

class CategoryRepositoryStatic implements CategoryRepositoryInterface
{

    protected $_model;

    public function __construct()
    {
        $category = collect([
            [
                'name' => 'X',
                'description' => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                'created_at' => '',
            ],
        ]);
        $this->_model = $category;
    }

    /**
     * Get All
     * @return array
     */
    public function get()
    {
        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {

        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * Pagination
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage)
    {
        return $this->_model->paginate($perPage);
    }

    /**
     * Latest
     * @return mixed
     */
    public function latest()
    {
        return $this->_model->sortBy('created_at');
    }
}

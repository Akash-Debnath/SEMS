<?php

namespace App\Repositories;

interface RepositoryInterface
{

    /**
     * @return mixed
     */
    public function all();


    /**
     * @param $id
     * @return mixed
     */
    public function get($id);


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);


    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}

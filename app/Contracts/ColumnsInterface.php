<?php


namespace app\Contracts;


interface ColumnsInterface
{
    /**
     * @param array $relations
     * @return mixed
     */
    public function all(array $relations = []);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function update(array $data);
}

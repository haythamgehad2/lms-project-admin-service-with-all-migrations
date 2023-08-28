<?php

namespace App\Repositories\Interfaces;

/**
 * Main Repository
 * Interface RepositoryInterface
 *
 * @package App\Repositories\interfaces
 */
interface RepositoryInterface
{
    /**
     * function return model based on its ID
     *
     * @param $id |int
     * @param array   $columns
     */
    public function find($id, array $columns = ['*']);

    /**
     * function return model based  on search criteria
     *
     * @param $caretria|
     * @param array     $columns
     */
    public function findBy(array $crateria, array $columns = ['*']);

    /**
     * function return model first based on search criteria
     *
     * @param array $crteria
     * @param array $columns
     */
    public function findOneBy(array $crteria, array $columns = ['*']);

    /**
     * function return all data from database
     *
     * @param array $columns
     */
    public function findAll(array $columns = ['*']);

    /**
     * function create new record in DB
     *
     * @param array $data
     */
    public function create(array $data);

    /**
     * function update in database
     *
     * @param array $data
     * @param $id
     */
    public function update(array $data, $id);

    /**
     * function delete record from database based on id
     *
     * @param $id
     */
    public function delete($id);

    /**
     * function insert multiple record in database
     *
     * @param array $data
     */
    public function insert(array $data);
}

<?php
namespace App\Repositories\Category;

interface CategoryRepository
{
    public function all();
    public function findByID($id);
    public function getAll();
    public function getCreateData();
    public function getEditeData($id);
    //     public function find($id);
    public function create(array $data);
    public function update($category, $data);
    public function destroy($id);
    public function restore($id);
    public function findTrashes();
    public function findTrash($id);
        public function foreDelete($category);
}

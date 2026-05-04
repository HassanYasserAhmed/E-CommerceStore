<?php

use App\Models\category;
use Illuminate\Support\Facades\Request;

class CategoryModelRepository implements CategoryRepository
{
    public function all()
    {
        return category::all();
    }
    public function getAll()
    {
        $query = Category::query();
        $categories = Category::with('parent', 'products')
            ->filter(Request::query())
            ->select('categories.*')->withCount('products')
            ->paginate();
    }
    public function getCreateData()
    {
        return [
            'parents' => $this->all(),
            'category' => new Category
        ];
    }
    public function create(array $data) {}
    public function getEditeData($id)
    {
        $category = category::findOrFail($id);
        $parents = category::where('id', '<>', value: $id)
            ->where(function ($request) {
                $request->where('parent_id', '<>', 'id')->orWhereNull('parent_id');
            })->get();

        return [
            'category' => $category,
            'parents' => $parents
        ];
    }
    public function findByID($id) {
        return category::findOrFail($id);
    }
    public function update($category,$data) {
         $category->update($data);
    }
    public function destroy($id) {
        return category::destroy($id);
    }
    public function restore($id) {
        return Category::onlyTrashed()->findOrFail($id)->restore();
    }
    public function findTrashes() {
        return Category::onlyTrashed()->paginate();
    }
    public function findTrash($id) {
       return Category::onlyTrashed()->findOrFail($id);
    }
    public function foreDelete($category) {
         $category->forceDelete();
    }
}

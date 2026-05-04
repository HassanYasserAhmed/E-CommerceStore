<?php

use App\Models\category;

class CategoryService extends FileService
{
    public function __construct(protected CategoryRepository $categoryRepository) {}

    public function store($request)
    {
        $data['image'] = $this->uploadImages($request);
        $data = $request->except('image');

        $this->categoryRepository->create($data);
    }
    public function update($request, $id, $data)
    {
        $category = $this->categoryRepository->findByID($id);
        $old_image = $category->image;

        $data['image'] = $this->uploadImages($request);

        if ($old_image && asset($data['image'])) {
            Storage::disk('public')->delete(paths: 'images_folder/' . $old_image);
        }
        $category->update($data);
    }
    public function destroy($id)
    {
        $rowsAffected = $this->categoryRepository->destroy($id);
        if (! $rowsAffected) {
            abort(code: 404);
        }
    }
    public function forceDelete($id)
    {
        $category = $this->categoryRepository->findTrash($id);
        if ($category->image) {
            $this->categoryRepository->foreDelete($category);
            Storage::disk('public')->delete('images_folder/' . $category->image);
        }
    }
}

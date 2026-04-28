<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\category;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('categories.view');
        $request = request();

        $query = Category::query();

        //    $categories = $query->paginate(3);
        $categories = Category::with('parent', 'products')
        // leftJoin('categories as parents','parents.id','=','categories.parent_id')
        // ->select('categories.*','parents.name as parent_name')
            ->filter($request->query())
            ->select('categories.*')->withCount('products')
            ->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('categories.create');
        $parents = Category::all();
        $category = new category;

        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Gate::authorize('categories.create');
        $request->validate(rules: Category::rules());

        $request->merge([
            'slug' => str::slug($request->post('name')),
        ]);
        $data['image'] = $this->uploadImages($request);
        $data = $request->except('image');

        Category::create($data);

        return Redirect::route('categories.index')->with('success', 'Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        Gate::authorize('categories.view');

        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.update');
        try {
            $category = category::findOrFail($id);
            $parents = category::where('id', '<>', value: $id)
                ->where(function ($request) {
                    $request->where('parent_id', '<>', 'id')->orWhereNull('parent_id');
                })->get();

            return view('dashboard.categories.edite', compact('category', 'parents'));

        } catch (Exception $e) {
            return redirect()->route('categories.index')->with('info', 'category not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        Gate::authorize('categories.update');
        $category = category::findOrFail($id);
        $old_image = $category->image;
        $data = $request->except('image');

        $data['image'] = $this->uploadImages($request);

        if ($old_image && asset($data['image'])) {
            Storage::disk('public')->delete(paths: 'images_folder/'.$old_image);
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');
        $rowsAffected = category::destroy($id);
        if (! $rowsAffected) {
            abort(code: 404);
        }

        return Redirect::route('categories.index')->with('success', 'category deleted successfully');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('categories.trash')->with('success', 'category restored successfully');
    }

    public function forceDelete($id)
    {
        gate::authorize('categories.delete');
        $category = Category::onlyTrashed()->findOrFail($id);
        if ($category->image) {
            $category->forceDelete();
            Storage::disk('public')->delete('images_folder/'.$category->image);

            return redirect()->route('categories.trash')->with('success', 'category deleted permanently');
        }

    }

    protected function uploadImages(CategoryRequest $request)
    {

        if (! $request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $file->store('images_folder');

        return $file->hashName();
    }
}

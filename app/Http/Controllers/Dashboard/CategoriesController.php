<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\category;
use App\Repositories\Category\CategoryRepository;
use App\Services\CategoryService;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected CategoryRepository $categoryRepository
    ) {}
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->getAll();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->categoryRepository->getCreateData();

        return view('dashboard.categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $request->validate(rules: Category::rules());

        $request->merge([
            'slug' => str::slug($request->post('name')),
        ]);

        $this->categoryService->store($request);

        return Redirect::route('categories.index')->with('success', 'Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = $this->categoryRepository->getEditeData($id);
            return view('dashboard.categories.edite',$data);
        } catch (Exception $e) {
            throw $e;
            return redirect()->route('categories.index')->with('info', 'category not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $data = $request->except('image');

        $this->categoryService->update($request, $id, $data);

        return redirect()->route('categories.index')->with('success', 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->destroy($id);

        return Redirect::route('categories.index')->with('success', 'category deleted successfully');
    }

    public function trash()
    {
        $categories = $this->categoryRepository->findTrashes();

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        $this->categoryRepository->restore($id);

        return redirect()->route('categories.trash')->with('success', 'category restored successfully');
    }

    public function forceDelete($id)
    {
        $this->categoryService->forceDelete($id);

        return redirect()->route('categories.trash')->with('success', 'category deleted permanently');
    }
}

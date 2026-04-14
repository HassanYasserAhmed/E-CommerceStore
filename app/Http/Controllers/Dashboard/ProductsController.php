<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Tag;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct() {
        $this->authorizeResource(Product::class,'product');
    }
    
    public function index()
    {
        $products = Product::with(['category','store'])->paginate(5);
        return view('dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $product = new Product();
        return view('dashboard.products.create',compact('product','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
            'name'=>['required','string','max:255'],
            'description'=>['nullable','string'],
            'price'=>['required','numeric','min:0'],
            'quantity'=>['required','integer','min:0'],
        ]);
        $request->merge([
            'slug' =>Str::slug($request->name)
        ]);


        $product = new Product();

        $product->fill($request->all());
        $product->store_id = Auth::user()->store_id;
        $product->save();

        return redirect()->route('products.index')->with('success','Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $tags = implode(',',$product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edite',compact('product','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>['required','string','max:255'],
            'description'=>['nullable','string'],
            'price'=>['required','numeric','min:0'],
            'quantity'=>['required','integer','min:0'],
        ]);


        $product = Product::findOrFail($id);
       $product->update($request->except('tags'));

       $tags = explode(',',$request->post('tags'));
       $tag_ids = [];
       $saved_tags = Tag::all();
       foreach($tags as $t_name) {
        $slug = Str::slug($t_name);
        $tag = $saved_tags->where('slug',$slug)->first();
        if(!$tag) {
         $tag= Tag::create([
                'name'=>$t_name,
                'slug'=>$slug
            ]);
        }
        $tag_ids[]=$tag->id;
       }
       $product->tags()->sync($tag_ids);
       return redirect()->route('products.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find(-2);

        $product->delete();

        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }
   
}

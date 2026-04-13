<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ProductsController;
use Illuminate\support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;

Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edite');
Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');

Route::group([
'middleware'=> ['auth:admin,web'],
'prefix'=>'admin/'
],function() {
Route::get('/dashboard',action: [DashboardController::class,'index'])
        ->name('dashboard');

Route::get('/categories/trash', [CategoriesController::class,'trash'])->name('categories.trash');

Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])->name('categories.restore');

Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'forceDelete'])
->name('categories.forceDelete');


  Route::resources([
    'products'=> ProductsController::class,
    'categories'=> CategoriesController::class,
    'roles' => RoleController::class
  ]);
Route::resource('dashboard/admin', AdminController::class);
Route::get('dashboard/admin/trash', [AdminController::class, 'trash'])->name('admin.trash');
});


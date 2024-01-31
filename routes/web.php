<?php

use App\Http\Controllers\AdminCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;
use App\Models\Category;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { //menangkap url setelah host
    // return view('welcome'); //mencari file bernama welcome di dalam folder views
    return view("home", [
        "title" => "Home",
        "active" => 'home',
    ]);
});
Route::get('/about', function () {
    return view("about", [
        "active" => 'about',
        "name" => "Jamal",
        "email" => "jamaludin@gmail.com",
        "image" => "jamal.jpg",
        "title" => "About"
    ]); //send data dengan list
});

Route::get('/posts', [PostController::class, "index"]);

Route::get("/posts/{post:slug}", [PostController::class, "show"]); //model = where id, model:attribute where attribute = value 

Route::get('/categories', function () {
    return view('categories', [
        'title' => 'Post Categories',
        "active" => 'categories',
        'categories' => Category::all(),
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest'); //dengan middleware hanya bisa diakses oleh guest (user yang belum terautentikasi)

Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest'); //name

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth'); //dengan middleware hanya bisa diakses oleh user yang telah terautentikasi

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin'); //except melarang penggunaan sebuah method tertentu pada resource

// Route::get('/categories/{category:slug}', function (Category $category) { //route model binding harus memiliki nama yang sama
//     return view('posts', [
//         'title' => "Post by Category : $category->name",
//         "active"=> 'categories',
//         'posts' => $category->posts->load('category','author') ,  //load untuk melakukan lazy eager loading (mengambil seluruh isi tabel beserta seluruh isi tabel-tabel lain yang berelasi setelah parent model didapatkan)
//     ]);
// });
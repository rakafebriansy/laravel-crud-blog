<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $title = '';
        if(request('category')){
            $category = Category::firstWhere('slug',request('category'));
            $title = ' in ' . $category->name;
        }
        if(request('author')){ //request mendapatkan data dari input melalui request saat ini
            $author = User::firstWhere('username',request('author'));
            $title = ' by ' . $author->name;
        }
        return view("posts",[
            "title"=>"All Posts" . $title,
            "active"=> 'posts',
            "posts" => Post::latest()->filter(request(['search','category','author']))->paginate(7)->withQueryString() //paginate untuk membuat pagination dengan param jumlah elemen per halaman, withQueryString membawa apapun yang ada di query string sebelumnya
            
            // "posts" => Post::with(['author','category'])->latest()->get() //with untuk melakukan eager loading (mengambil seluruh isi tabel beserta seluruh isi tabel-tabel lain yang berelasi) mencegah n+1 problem dalam pemanggilan query
        ]);
    }
    public function show(Post $post) //Route Model Binding
    { 
        return view("post",[
            "title"=>"Single Post",
            "active"=> 'posts',
            "post"=> $post,
        ]);
    }
}

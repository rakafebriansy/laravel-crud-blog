<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable; //import package sluggable (pembuat slug otomatis)

class Post extends Model
{
    use HasFactory, Sluggable;

    // protected $fillable = ["title","excerpt","body"]; //mendeklarasikan attribute yang boleh diisi dengan mass assignment seperti Model::create([]) dan Model::find(id)->update([])
    protected $guarded = ["id"]; //mendeklarasikan attribute yang tidak boleh diisi dengan mass assignment seperti Model::create([]) dan Model::find(id)->update([])
    protected $with = ['author','category']; //with berbentuk attribute untuk eager loading

    public function scopeFilter($query, array $filters)
    {
        //searching
        $query->when($filters['search'] ?? false, function($query, $search){ //?? merupakan gabungan ternary dan isset (jika kiri isset maka return kiri jika tidak return kanan)
            return $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('body','like','%' . $search . '%');
        }); //when merupakan decision yang menjalankan closure (param kedua) jika values (param pertama) bernilai true

        $query->when($filters['category'] ?? false, function($query, $category){
            return $query->whereHas('category', function($query) use ($category){ //use untuk menggunakan variabel/class dari scope lain
                $query->where('slug', $category);
            }); //whereHas untuk mencari query berdasarkan relation tertentu
        }); //dengan when dapat menjalankan lebih dari satu blok kode when sekaligus

        $query->when($filters['author'] ?? false, fn($query, $author)=>
            $query->whereHas('author', fn($query) =>
                $query->where('username', $author)
            )
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class); //memberikan sambugan relasi pada tabel lain
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id'); //jika nama method berbeda dengan nama model, wajib menambahkan parameter foreign key
    }
    public function getRouteKeyName() //meminta laravel menimpa route model binding menggunakan kolom selain id
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title' //sumbernya merupakan attribute tertentu
            ]
        ];
    }
}

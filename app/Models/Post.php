<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'thumbnail', 'category_id'];

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailPathAttribute() {
        return 'storage/'.$this->thumbnail;
    }

    // Mutators
    public function setTitleAttribute(string $title) {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }


}

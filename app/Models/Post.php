<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'excerpt', 'author_id', 'body', 'thumbnail', 'category_id'];

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

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(){
        return asset("blogs/{$this->slug}");
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

}

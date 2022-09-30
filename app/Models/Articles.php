<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\Administration\CategoryFactory;
use App\Models\Categories;
use App\Models\User;

class Articles extends Model
{
    use HasFactory;

    protected $table = "articles";
    protected $guarded = ['id'];
    protected $fillable = ['title', 'content', 'image'];

    // protected $with = ['categories'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}

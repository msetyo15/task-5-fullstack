<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\Administration\CategoryFactory;
use App\Models\User;
use App\Models\Articles;

class Categories extends Model
{
    use HasFactory;

    protected $table = "categories";
    protected $guarded = ['id'];
    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function articles()
    {
        return $this->hashOne(Articles::class, 'category_id', 'user_id');
    }
}

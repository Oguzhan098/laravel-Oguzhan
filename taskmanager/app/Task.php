<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'title', 'description', 'user_id', 'category_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    // 🔹 Görev bir kullanıcıya aittir
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 Görev bir kategoriye aittir
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

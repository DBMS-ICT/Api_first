<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(Roles::class);
    }
}

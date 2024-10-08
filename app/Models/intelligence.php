<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class intelligence extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'intelligence';
    protected $fillable = [
        'employee_id',
        'supported_by',
        'Former_member',
        'party_id',
        'Date_connection',
        'Travel',
        'Reason_travelling',
        'another_passport',
        'country_passport',
        'attach',
        'user_id',
        'family',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function party()
    {
        return $this->belongsTo(party::class);
    }
}

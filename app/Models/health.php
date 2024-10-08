<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class health extends Model
{
    use HasFactory;
    protected $table = 'healths';

    use SoftDeletes;
    protected $fillable = [
        'employee_id',
        'boold_group',
        'Heart_disease',
        'Blood_pressure',
        'suger',
        'cm',
        'weight',
        'bones_joints',
        'Kidney_disease',
        'Liver_disease',
        'Mental_illness',
        'Note1',
        'medicine',
        'Food',
        'etc',
        'detail',
        'medicine_list',
        'surgery_injury',
        'physical_ability',
        'physical_ability_detail',
        'glasses',
        'hear',
        'document_health',
        'user_id',
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

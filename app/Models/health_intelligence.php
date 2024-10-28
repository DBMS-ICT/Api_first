<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class health_intelligence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'health_intelligences';
    // protected $guarded = [];
    // Fillable attributes for mass assignment
    protected $fillable = [
        'employee_id',
        'blood_group', // Corrected typo from 'boold_group'
        'heart_disease',
        'blood_pressure',
        'sugar', // Corrected typo from 'suger'
        'cm',
        'weight',
        'bones_joints',
        'kidney_disease',
        'liver_disease',
        'mental_illness',
        'note1', // Corrected casing from 'Note1'
        'medicine',
        'food', // Corrected casing from 'Food'
        'etc',
        'detail',
        'medicine_list',
        'surgery_injury',
        'physical_ability',
        'physical_ability_detail',
        'glasses',
        'hear',
        'document_health',
        'supported_by', // start intelligent
        'former_member', // Corrected casing from 'Former_member'
        'party_id',
        'date_connection', // Corrected casing from 'Date_connection'
        'travel', // Corrected casing from 'Travel'
        'reason_travelling', // Corrected casing from 'Reason_travelling'
        'another_passport',
        'country_passport',
        'attach',
        'family',
        'user_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table='persons';
    protected $fillable = [ 'person_id',
        'person_ivideon_id',
        'work_posts_id',
        'role_id',
        'login',
        'password',
        'name',
        'phone',
        'avatar',
        'email',
        'description_person',
        'created_at',
        'updated_at'];
}

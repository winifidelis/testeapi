<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfilgithub extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'url',
        'login',
        'identificador',
        'foto',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

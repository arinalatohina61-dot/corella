<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'email',
        'password',
        'phone'
    ];

    protected $table = 'clients';

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}

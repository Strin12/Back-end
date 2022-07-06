<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class personas extends Model
{
    use HasFactory;
    

    use SoftDeletes;

    protected $table = 'personas';
    protected $fillable = [
        'id',
        'name',
        'last_name',
        'avatar'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'delete_at'
    ];
    public function users()
    {
        return $this->hasOne(User::class);
    }
    public function posts()
    {
        return $this->hasOne(posts::class);
    }
}

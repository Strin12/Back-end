<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class roles extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'roles';

    protected $fillable = [
        'id',
        'name',
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
}

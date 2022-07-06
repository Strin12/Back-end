<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class posts extends Model
{
    const Inactivo = false;
    use HasFactory;

    protected $table = 'posts';

    use SoftDeletes;

    protected $fillable = [
        'id',
        'foto',
        'descripcion',
        'activo',
        'personas_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'delete_at'
    ];
    public function personas()
    {
        return $this->belongsTo(personas::class);
    }
}

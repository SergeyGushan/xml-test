<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EngineType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function autos(): HasMany
    {
        return $this->hasMany(Auto::class);
    }
}

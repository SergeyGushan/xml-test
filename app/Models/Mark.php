<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function models(): HasMany
    {
        return $this->hasMany(MarkModel::class);
    }

    public function autos(): BelongsToMany
    {
        return $this->belongsToMany(Auto::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MarkModel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mark_id'];

    public function generations(): HasMany
    {
        return $this->hasMany(MarkModelGeneration::class);
    }

    public function mark(): BelongsTo
    {
        return $this->belongsTo(MarkModel::class);
    }

    public function autos(): HasMany
    {
        return $this->hasMany(Auto::class);
    }
}

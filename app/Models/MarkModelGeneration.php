<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarkModelGeneration extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mark_id', 'mark_model_id'];

    public function mark(): BelongsTo
    {
        return $this->belongsTo(MarkModel::class);
    }

    public function autos(): HasMany
    {
        return $this->hasMany(Auto::class);
    }
}

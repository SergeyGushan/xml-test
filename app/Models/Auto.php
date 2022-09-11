<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Auto extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'year'];

    public function mark(): belongsTo
    {
        return $this->belongsTo(Mark::class);
    }

    public function markModel(): belongsTo
    {
        return $this->belongsTo(MarkModel::class);
    }

    public function markModelGeneration(): belongsTo
    {
        return $this->belongsTo(MarkModelGeneration::class);
    }

    public function color(): belongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function bodyType(): belongsTo
    {
        return $this->belongsTo(BodyType::class);
    }

    public function engineType(): belongsTo
    {
        return $this->belongsTo(EngineType::class);
    }

    public function transmission(): belongsTo
    {
        return $this->belongsTo(Transmission::class);
    }

    public function gearType(): belongsTo
    {
        return $this->belongsTo(GearType::class);
    }
}

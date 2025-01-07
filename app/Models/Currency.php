<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    /** @use HasFactory<\Database\Factories\CurrencyFactory> */
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function baseRates(): HasMany
    {
        return $this->hasMany(Rate::class, 'base_currency_id');
    }

    public function targetRates(): HasMany
    {
        return $this->hasMany(Rate::class, 'target_currency_id');
    }
}

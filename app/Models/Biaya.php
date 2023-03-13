<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Biaya extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $guarded = [];
    protected $append = ['nama_biaya_full','total_tagihan'];
    
    /**
     * Get all of the children for the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Biaya::class, 'parent_id');
    }

    protected function namaBiayaFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->nama . ' - ' . $this->formatRupiah('jumlah')
        );
    }
    
    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->children()->sum('jumlah')
        );
    }

    /**
     * Get the user that owns the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function($biaya){
            $biaya->user_id = auth()->user()->id;
        });
        static::updating(function($biaya){
            $biaya->user_id = auth()->user()->id;
        });
    }
}

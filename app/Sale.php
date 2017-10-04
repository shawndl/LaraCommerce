<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'start', 'finish', 'discount'
    ];

    /**
     * @param $query
     * @return Sale
     */
    public function scopeCurrent($query)
    {
        return $query->where('start', '<=', Carbon::now())
            ->where('finish', '>=', Carbon::now()->format('Y-m-d'));
    }


    /**
     * a sale has a single product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

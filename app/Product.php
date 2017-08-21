<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    //use Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'tax_id', 'image_id', 'title', 'price', 'description', 'weight'
    ];

    /**
     * gets the price value and formats it with two digits
     *
     * @param $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return money_format('%i', $value);
    }

    /**
     * price value is always set using money format 2 digets
     *
     * @param $value
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = money_format('%i', $value);
    }

    /**
     * a product belongs to a category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * a product has many reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    /**
     * a product has a single image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    /**
     * a product has a tax
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo('App\Tax');
    }

    /**
     * performs a search if algolia is not used
     * comment out if algolia is used
     *
     * @param $query
     * @return mixed
     */
    public function search($query)
    {
        return $this->where('title', 'like', "%$query%");
    }
}

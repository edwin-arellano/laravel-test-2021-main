<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'seller'
    ];

    /**
     * The attributes that always be appends.
     *
     * @var array
     */

    protected $appends = [
        'seller_name'
    ];

    /**
     * Seller of the product
     */

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Seller's name
     */

    public function getSellerNameAttribute()
    {
        return $this->seller->name;
    }

    /**
     * Transactions of the product
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Search products for name
     * 
     * Uses 'like' search by name
     * 
     * @param $name string to search
     */
    public function scopeName($query, $name)
    {
        if(isset($name)) {
            return $query->where('name', 'like', "%{$name}");
        }
    }

    /**
     * Search products in stock
     * 
     * only returns products with quantity greater than 0
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }
}

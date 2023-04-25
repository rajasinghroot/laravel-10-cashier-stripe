<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'id','product_name', 'product_price', 'description', 'created_at', 'updated_at'
    ];
    
    /* orders table relation */
    public function orders(){
        return $this->hasMany(Order::class,'product_id');
    }

    /* transform product price with currency symbol */
    public function getPriceWithSymbolAttribute(){
        return "$ ".$this->product_price;
    }    
}

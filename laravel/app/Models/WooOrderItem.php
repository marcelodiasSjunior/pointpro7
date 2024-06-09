<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WooOrderItem extends Model
{
    use HasFactory;
    protected $connection = 'wordpress';
    protected $table = 'wp_woocommerce_order_items';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WPUserMeta extends Model
{
    use HasFactory;
    protected $connection = 'wordpress';
    protected $table = 'wp_usermeta';
}

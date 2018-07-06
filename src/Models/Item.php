<?php

namespace Jakub\ProductBackend\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * @package Jakub\ProductBackend\Models
 */
class Item extends Model
{
    /**
     * @var string
     */
    protected $table = 'items';


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'amount'
    ];
}

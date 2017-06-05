<?php

namespace App\Responsitory;

use Illuminate\Database\Eloquent\Model;

class Category_level extends BaseModel
{
    protected $table = 'category_levels';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'id',
        'level',
    ];
    protected $hidden = [
        'category_id',
        'worker_id',
        'created_at',
        'updated_at',
    ];

    public function rule()
    {
        return [
        ];
    }
    /*  public function products()
      {
          return $this->belongsToMany(Products::class, productcate::class, 'cate_id', 'product_id');
      }*/


}

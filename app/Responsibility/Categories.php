<?php

namespace App\Responsitory;

use Illuminate\Database\Eloquent\Model;

class Categories extends BaseModel
{
    protected $table = 'categories';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'id',
        'description',
        'address',
        'website',
        'type',
        'degree',
        'bank_account',
    ];
    protected $hidden = [
        'created_at','updated_at',
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

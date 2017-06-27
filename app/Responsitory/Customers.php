<?php

namespace App\Responsitory;

use Illuminate\Database\Eloquent\Model;

class Customers extends BaseModel
{
    protected $table = 'customers';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'id',
        'user_id',
        'district_id',
        'address',
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

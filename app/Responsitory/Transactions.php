<?php

namespace App\Responsitory;

use Illuminate\Database\Eloquent\Model;

class Transactions extends BaseModel
{
    protected $table = 'transactions';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'id',
        'is_finished',
        'description',
        'feedback',
        'rate',
        'address',
        'district_id',
        'started_at',
        'finished_at',
    ];
    protected $hidden = [
        'created_at','updated_at','customer_id',
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

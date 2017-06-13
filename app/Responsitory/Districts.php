<?php

namespace App\Responsitory;

use Illuminate\Database\Eloquent\Model;

class Districts extends BaseModel
{
    protected $table = 'districts';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'id',
        'name',
        'province_id',
        'translation_id',
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

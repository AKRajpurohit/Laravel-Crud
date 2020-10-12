<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name', 'category_id', 'product_image', 'product_description',
    ];
    protected $appends = ['product_pic'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function categories() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
  public function getProductPicAttribute(){
      return !empty($this->product_image) ? config('constants.File_upload.product_resized')."/".$this->product_image :  "/images/no_image.jpg";
  }
}

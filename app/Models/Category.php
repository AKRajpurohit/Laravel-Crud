<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name', 'category_image','parent_category'
    ];
    protected $appends = ['category_pic'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function childCat() {
        return $this->hasMany(self::class, 'parent_category')->orderBy('category_name', 'asc');
    }
    public function parentCat() {
        return $this->belongsTo(self::class, 'parent_category')->orderBy('category_name', 'asc');
    }

    public function getCategoryPicAttribute() {
        return !empty($this->category_image) ? config('constants.File_upload.category_resized')."/".$this->category_image : "/images/no_image.jpg";
    }

}

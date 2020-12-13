<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = [
        'translation_lang', 'translation_of','category_id','parent_id','name', 'slug', 'photo', 'active', 'created_at', 'updated_at'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSelection($query)
    {

        return $query->select('id', 'translation_lang','parent_id', 'category_id','name', 'slug', 'photo', 'active', 'translation_of');
    }

    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";
    }

    public function getActive()
    {
        return $this->active == 1 ? 'مفعل' : 'غير مفعل';

    }

    public function scopeDefaultCategory($query){
        return  $query -> where('translation_of',0);
    }

   // get all translation categories
   public function categories()
   {
       return $this->hasMany(self::class, 'translation_of');
   }

   
    public  function mainCategory(){
        return $this->belongsTo(MainCategory::class,'category_id','id');
    }

}

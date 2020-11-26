<?php

namespace App\Models;

use App\Observers\VendorObserver;
use Illuminate\Database\Eloquent\Model;
class Vendor extends Model
{
    protected $table = 'vendors';

    protected $fillable = [
          'name', 'mobile', 'address', 'active', 'email', 'password' ,'logo' , 'category_id',  'created_at', 'updated_at'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     MainCategory::observe(MainCategoryObserver::class);
    // }

    protected $hidden = ['category_id'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSelection($query)
    {

        return $query->select('id', 'category_id', 'name','active' ,'mobile', 'logo');
    }

    public function getlogoAttribute($val)
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

    public function category(){

        return $this->belongsTo('App\Models\MainCategory','category_id','id');
    }

      // get all translation categories
    // public function categories()
    // {
    //     return $this->hasMany(self::class, 'translation_of');
    // }


    // public  function subCategories(){
    //     return $this -> hasMany(SubCategory::class,'category_id','id');
    // }



    // public function vendors(){

    //     return $this -> hasMany('App\Models\Vendor','category_id','id');
    // }

}

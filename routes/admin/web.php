<?php

use Illuminate\Support\Facades\Route;
 


define('PAGINATION_COUNT',10);
 
Route::group(['prefix' => 'admin'], function () {
    Config::set('auth.defines','admin');

    Route::get('login','AdminAuth@login')->name('get.admin.login');
    Route::post('login','AdminAuth@dologin')->name('admin.login');
     

    Route::group(['middleware' => 'admin:admin'],function(){
        Route::get('/','DashboardController@index')->name('admin.dashboard');
        Route::any('logout','AdminAuth@logout');

        ######################### Begin Languages Route ########################
        Route::resource('languages', 'LanguagesController');
        Route::get('changeLangStatus/{id}','LanguagesController@changeStatus')->name('language.status');
         ######################### End Languages Route ########################

        ######################### Begin Main Categoris Routes ########################
        Route::resource('main_categories', 'MainCategoriesController');
        Route::get('changeStatus/{id}','MainCategoriesController@changeStatus')->name('admin.maincategories.status');
        ######################### End  Main Categoris Routes  ########################


            ######################### Begin sub Categoris Routes ########################
            Route::resource('sub_categories', 'SubCategoriesController');
            Route::get('changeSubStatus/{id}','SubCategoriesController@changeStatus')->name('admin.subcategories.status');
            Route::get('/sub_cat/{id}', 'SubCategoriesController@getsubcat');
            ######################### End  sun Categoris Routes  ########################
    

         ######################### Begin Vendors Routes ########################
         Route::resource('vendors', 'VendorsController');
         Route::get('changeVendorStatus/{id}','VendorsController@changeStatus')->name('vendors.status');
         ######################### End  Vendors Routes  ########################

    });

      

    // lang
    
    Route::get('lang/{lang}', function ($lang) {
        session()->has('lang')?session()->forget('lang'):'';
        $lang == 'ar'?session()->put('lang', 'ar'):session()->put('lang', 'en');
        return back();
    });
});
 


  

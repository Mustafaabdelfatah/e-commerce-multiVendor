<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


define('PAGINATION_COUNT',10);
 
Route::group(['prefix' => 'admin'], function () {
    Config::set('auth.defines','admin');

    Route::get('login','AdminAuth@login')->name('get.admin.login');
    Route::post('login','AdminAuth@dologin')->name('admin.login');
     

    Route::group(['middleware' => 'admin:admin'],function(){
        Route::get('/','DashboardController@index')->name('admin.dashboard');
        Route::any('logout','AdminAuth@logout');

        ######################### Begin Languages Route ########################
        Route::group(['prefix' => 'languages'], function () {
        Route::get('/','LanguagesController@index') -> name('admin.languages');
        Route::get('create','LanguagesController@create') -> name('admin.languages.create');
        Route::post('store','LanguagesController@store') -> name('admin.languages.store');
        Route::get('edit/{id}','LanguagesController@edit') -> name('admin.languages.edit');
        Route::post('update/{id}','LanguagesController@update') -> name('admin.languages.update');
        Route::get('delete/{id}','LanguagesController@destroy') -> name('admin.languages.delete');
        });
        ######################### End Languages Route ########################
    });

    //Route::resource('main_categories', 'MainCategoriesController');
    ######################### Begin Main Categoris Routes ########################
    Route::group(['prefix' => 'main_categories'], function () {
     
        Route::get('/','MainCategoriesController@index') -> name('admin.maincategories');
        Route::get('create','MainCategoriesController@create') -> name('admin.maincategories.create');
        Route::post('store','MainCategoriesController@store') -> name('admin.maincategories.store');
        Route::get('edit/{id}','MainCategoriesController@edit') -> name('admin.maincategories.edit');
        Route::post('update/{id}','MainCategoriesController@update') -> name('admin.maincategories.update');
        Route::get('delete/{id}','MainCategoriesController@destroy') -> name('admin.maincategories.delete');
        Route::get('changeStatus/{id}','MainCategoriesController@changeStatus') -> name('admin.maincategories.status');

    });
    ######################### End  Main Categoris Routes  ########################

    // lang
    
    Route::get('lang/{lang}', function ($lang) {
        session()->has('lang')?session()->forget('lang'):'';
        $lang == 'ar'?session()->put('lang', 'ar'):session()->put('lang', 'en');
        return back();
    });
});
 


  

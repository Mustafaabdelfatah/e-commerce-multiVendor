<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use DB;
use File;
use Illuminate\Support\Str;

class MainCategoriesController extends Controller
{
    public function index()
    {
        // dd(MainCategory::where('translation_lang','en')->get() );
        $default_lang = get_default_lang();
        // dd($default_lang);
        $categories = MainCategory::where('translation_lang', $default_lang)
            ->selection()
            ->paginate(PAGINATION_COUNT);

        return view('admin.maincategories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.maincategories.create');
    }


    public function store(MainCategoryRequest $request)
    {
         

        try {
        
            // collect request with all data (data in all languages)
            $main_categories = collect($request->category);

            // get data with just default language
            $filter = $main_categories->where('abbr' ,get_default_lang());

            // get value as array (to use default_category['abbr] not filter[0]['abbr])
            $default_category = array_values($filter->all()) [0];

            $filePath = "";
            if ($request->has('photo')) {

                $filePath = uploadImage('maincategories', $request->photo);
            }

            DB::beginTransaction();

            // get id for just default lang || make translation_of = 0 in this record which refer to default_lang
            $default_category_id = MainCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'photo' => $filePath
            ]);

            // get data not equal default language (if exist data with another language )
            $categories = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] != get_default_lang();
            });

            // if exisit records with another lang insert it and make translation_of == id for (record with default_lang) 
            if (isset($categories) && $categories->count()) {
                $categories_arr = [];
                foreach ($categories as $category) {
                    $categories_arr[] = [
                        'translation_lang' => $category['abbr'],
                        'translation_of' => $default_category_id,
                        'name' => $category['name'],
                        'slug' => $category['name'],
                        'photo' => $filePath
                    ];
                }

                MainCategory::insert($categories_arr);
            }

            DB::commit();

            return redirect()->route('main_categories.index')->withSuccessMessage(  'تم الحفظ بنجاح');

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($mainCat_id)
    {
        //get specific categories and its translations
        $mainCategory = MainCategory::with('categories')
            ->selection()
            ->find($mainCat_id);

        if (!$mainCategory)
            return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

        return view('admin.maincategories.edit', compact('mainCategory'));
    }


    public function update($mainCat_id, MainCategoryRequest $request)
    {


        try {
            $main_category = MainCategory::find($mainCat_id);

            if (!$main_category)
                return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

            // update date

            $category = array_values($request->category) [0];

            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


            MainCategory::where('id', $mainCat_id)
                ->update([
                    'name' => $category['name'],
                    'active' => $request->active,
                ]);

            // save image

            if ($request->has('photo')) {
                $filePath = uploadImage('maincategories', $request->photo);
                MainCategory::where('id', $mainCat_id)
                    ->update([
                        'photo' => $filePath,
                    ]);
            }


            return redirect()->route('main_categories.index')->withSuccessMessage( 'تم ألتحديث بنجاح' );
            
        } catch (\Exception $ex) {

            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {
            $maincategory = MainCategory::find($id);
            if (!$maincategory)
                return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

            $vendors = $maincategory->vendors();
        
            if (isset($vendors) && $vendors->count() > 0) {
                return redirect()->route('main_categories.index')->with(['error' => ' لأ يمكن حذف هذا القسم يوجد متاجر مرتبطه به  ']);
            }

            // return $maincategory->photo;

            // $image_path = Str::after($maincategory->photo, 'assets/');
            // return $image_path;

            // $image_path = base_path($image_path);
            // // return $image_path;

            // unlink($image_path); //delete from folder


            // // File::delete($image_path);

            // // // return $image_path;

            // // if (File::exists($image_path)) {
            // // }


            // // $image = Str::after($maincategory->photo, 'assets/');
            // // $image = base_path('assets/' . $image);
            
            // // return $image;
            // // unlink($image); //delete from folder

            $maincategory->delete();

            return redirect()->route('main_categories.index')->withSuccessMessage( 'تم حذف القسم بنجاح' );

        } catch (\Exception $ex) {
            dd($ex);
            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function changeStatus($id)
    {
        try {
            $maincategory = MainCategory::find($id);
            if (!$maincategory)
                return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

           $status =  $maincategory->active  == 0 ? 1 : 0;

           $maincategory -> update(['active' =>$status ]);

            return redirect()->route('main_categories.index')->withSuccessMessage( ' تم تغيير الحالة بنجاح ' );

        } catch (\Exception $ex) {
            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}

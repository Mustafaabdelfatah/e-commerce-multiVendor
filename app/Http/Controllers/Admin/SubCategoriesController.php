<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Http\Requests\SubCategoryRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubCategoriesController extends Controller
{
     
    public function index()
    {
        $default_lang = get_default_lang();
        // dd($default_lang);
        $categories = SubCategory::where('translation_lang', $default_lang)
            ->selection()
            ->get();
        // dd($categories);

        return view('admin.subcategories.index', compact('categories'));
    }

    
    public function create()
    {
        $default_lang = get_default_lang();

        $categories = MainCategory::where(['translation_lang'=> $default_lang])
        ->selection()
        ->get();

        $levels = SubCategory::where(['parent_id'=> 0 , 'translation_lang'=>$default_lang])
        ->selection()
        ->get();

        return view('admin.subcategories.create',compact('categories','levels'));
    }

    
    public function store( SubCategoryRequest $request)
    {
         

        try {
            // dd($request->all());
            // collect request with all data (data in all languages)
            $sub_categories = collect($request->category);
            // dd($sub_categories);

            // get data with just default language
            $filter = $sub_categories->where('abbr' ,get_default_lang());

            // dd($filter);
            // get value as array (to use default_category['abbr] not filter[0]['abbr])
            $default_category = array_values($filter->all()) [0];

            // dd($default_category);
            $filePath = "";
            if ($request->has('photo')) {

                $filePath = uploadImage('maincategories', $request->photo);
            }

            DB::beginTransaction();

            // get id for just default lang || make translation_of = 0 in this record which refer to default_lang
            $default_category_id = SubCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'photo' => $filePath,
                'category_id'=> $request->category_id,
                'parent_id'=> $request->parent_id ?? 0,

            ]);

            // dd($default_category_id);
            // get data not equal default language (if exist data with another language )
            $categories = $sub_categories->filter(function ($value, $key) {
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
                        'photo' => $filePath,
                        'category_id'=> $request->category_id,
                        'parent_id'=> $request->parent_id ?? 0,
                    ];
                }

                SubCategory::insert($categories_arr);
            }

            DB::commit();

            return redirect()->route('sub_categories.index')->withSuccessMessage(  'تم الحفظ بنجاح');

        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return redirect()->route('sub_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
          //get specific categories and its translations
        $default_lang = get_default_lang();

        $subCategory = SubCategory::with('categories')->selection()->find($id);

        $levels = SubCategory::where(['parent_id'=>0,'translation_lang'=>$default_lang])->get();

        $categories = MainCategory::where(['translation_of' => $default_lang])->get();

      if (!$subCategory)
          return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

      return view('admin.subcategories.edit', compact('subCategory','levels','categories'));
    }

     
    public function update(Request $request, $id)
    {
        try {
            $sub_category = SubCategory::find($id);


            if (!$sub_category)
                return redirect()->route('sub_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

            // update date

            $category = array_values($request->category) [0];

            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


            SubCategory::where('id', $id)
                ->update([
                    'name' => $category['name'],
                    'active' => $request->active,
                    'parent_id' => $request->parent_id,
                    'category_id' => $request->category_id,
                ]);

            // save image

            if ($request->has('photo')) {
                $filePath = uploadImage('subcategories', $request->photo);
                SubCategory::where('id', $id)
                    ->update([
                        'photo' => $filePath,
                    ]);
            }


            return redirect()->route('sub_categories.index')->withSuccessMessage( 'تم ألتحديث بنجاح' );
            
        } catch (\Exception $ex) {

            return redirect()->route('sub_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    

    public function destroy($id)
    {

        try {
            $subcategory = SubCategory::find($id);
            if (!$subcategory)
                return redirect()->route('sub_categories.index')->with(['error' => 'هذا القسم غير موجود ']);


            $subcategory->categories()->delete();
            
            $subcategory->delete();

            return redirect()->route('sub_categories.index')->withSuccessMessage( 'تم حذف القسم بنجاح' );

        } catch (\Exception $ex) {
            dd($ex);
            return redirect()->route('sub_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
     

    public function changeStatus($id)
    {
        try {


            $maincategory = MainCategory::find($id);
         

            if (!$maincategory)
                return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

           $status =  $maincategory->active  == 0 ? 1 : 0;

           $maincategory->update(['active' =>$status ]);

           
 
            return redirect()->route('main_categories.index')->withSuccessMessage( ' تم تغيير الحالة بنجاح ' );

        } catch (\Exception $ex) {
            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}

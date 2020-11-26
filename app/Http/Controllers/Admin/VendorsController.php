<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Vendor;
use Illuminate\Support\Str;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Notifications\VendorCreated;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

class VendorsController extends Controller
{
    public function index()
    {
        $vendors = Vendor::selection()->paginate(PAGINATION_COUNT);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        //$categories = MainCategory::where('translation_of', 0)->active()->get();
        $categories = MainCategory::where('translation_lang' , get_default_lang())->active()->get();
        //dd($categories);
        return view('admin.vendors.create', compact('categories'));
     }


    public function store(VendorRequest $request)
    {

       
        try {

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
            }

            // $vendor = Vendor::create([
            //     'name' => $request->name,
            //     'mobile' => $request->mobile,
            //     'email' => $request->email,
            //     'active' => $request->active,
            //     'address' => $request->address,
            //     'logo' => $filePath,
            //     'password' => $request->password,
            //     'category_id' => $request->category_id,
            //     'latitude' => $request->latitude,
            //     'longitude' => $request->longitude,
            // ]);

            $vendor = Vendor::create($request->all());

            Notification::send($vendor, new VendorCreated($vendor));

            return redirect()->route('admin.vendors.index')->withSuccessMessage( 'تم الحفظ بنجاح' );

        } catch (\Exception $ex) {
            dd($ex);
            return redirect()->route('admin.vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }


    public function edit($mainCat_id)
    {
        //get specific categories and its translations
        $mainCategory = Vendor::with('categories')
            ->selection()
            ->find($mainCat_id);

        if (!$mainCategory)
            return redirect()->route('vendors.index')->with(['error' => 'هذا القسم غير موجود ']);

        return view('admin.vendors.edit', compact('mainCategory'));
    }


    public function update($mainCat_id, MainCategoryRequest $request)
    {


        try {
            $main_category = Vendor::find($mainCat_id);

            if (!$main_category)
                return redirect()->route('vendors.index')->with(['error' => 'هذا القسم غير موجود ']);

            // update date

            $category = array_values($request->category) [0];

            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


            Vendor::where('id', $mainCat_id)
                ->update([
                    'name' => $category['name'],
                    'active' => $request->active,
                ]);

            // save image

            if ($request->has('photo')) {
                $filePath = uploadImage('maincategories', $request->photo);
                Vendor::where('id', $mainCat_id)
                    ->update([
                        'photo' => $filePath,
                    ]);
            }


            return redirect()->route('vendors.index')->withSuccessMessage( 'تم ألتحديث بنجاح' );
        } catch (\Exception $ex) {

            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {
            $maincategory = Vendor::find($id);
            if (!$maincategory)
                return redirect()->route('vendors.index')->with(['error' => 'هذا القسم غير موجود ']);

            // $vendors = $maincategory->vendors();
            // if (isset($vendors) && $vendors->count() > 0) {
            //     return redirect()->route('vendors.index')->with(['error' => 'لأ يمكن حذف هذا القسم  ']);
            // }

            // $image = Str::after($maincategory->photo, 'assets/');
            // $image = base_path('assets/' . $image);
            // unlink($image); //delete from folder

            $maincategory->delete();
            return redirect()->route('vendors.index')->withSuccessMessage( 'تم حذف القسم بنجاح' );

        } catch (\Exception $ex) {
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function changeStatus($id)
    {
        try {
            $maincategory = Vendor::find($id);
            if (!$maincategory)
                return redirect()->route('vendors.index')->with(['error' => 'هذا القسم غير موجود ']);

           $status =  $maincategory->active  == 0 ? 1 : 0;

           $maincategory -> update(['active' =>$status ]);

            return redirect()->route('vendors.index')->withSuccessMessage( ' تم تغيير الحالة بنجاح ' );

        } catch (\Exception $ex) {
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}

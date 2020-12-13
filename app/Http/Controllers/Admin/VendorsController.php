<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\MainCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VendorCreated;
use DB;
use Datatables;

class VendorsController extends Controller
{


    public function index()
    {
        $vendors = Vendor::selection()->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        $categories = MainCategory::where('translation_of', 0)->active()->get();
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

            $vendor = Vendor::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'active' => $request->active,
                'address' => $request->address,
                'logo' => $filePath,
                'password' => $request->password,
                'category_id' => $request->category_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            Notification::send($vendor, new VendorCreated($vendor));

            return redirect()->route('vendors.index')->withSuccessMessage( 'تم الحفظ بنجاح' );

        } catch (\Exception $ex) {
            dd($ex);
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }

    public function edit($id)
    {
        try {

            $vendor = Vendor::Selection()->find($id);
            if (!$vendor)
                return redirect()->route('vendors.index')->with(['error' => 'هذا المتجر غير موجود او ربما يكون محذوفا ']);

            $categories = MainCategory::where('translation_of', 0)->active()->get();

            return view('admin.vendors.edit', compact('vendor', 'categories'));

        } catch (\Exception $ex) {
            dd($ex);
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function update($id, Request $request)
    {

        try {

            $data = $this->validate(request(),[
                'logo' => 'required_without:id|mimes:jpg,jpeg,png',
                'name' => 'required|string|max:100',
                'mobile' =>'required|max:100',
                'email'  => 'required|email',
                'category_id'  => 'required|exists:main_categories,id',
                'address'   => 'required|string|max:500',
                'password'   => 'required_without:id'
    
            ],[],[
    
                'required'  => 'هذا الحقل مطلوب ',
                'max'  => 'هذا الحقل طويل',
                'category_id.exists'  => 'القسم غير موجود ',
                'email.email' => 'ضيغه البريد الالكتروني غير صحيحه',
                'address.string' => 'العنوان لابد ان يكون حروف او حروف وارقام ',
                'name.string'  =>'الاسم لابد ان يكون حروف او حروف وارقام ',
                'logo.required_without'  => 'الصوره مطلوبة',
                'email.unique' => 'البريد الالكتروني مستخدم من قبل ',
                'mobile.unique' => 'رقم الهاتف مستخدم من قبل ',

            ]);


            $vendor = Vendor::Selection()->find($id);
            if (!$vendor)
                return redirect()->route('vendors.index')->with(['error' => 'هذا المتجر غير موجود او ربما يكون محذوفا ']);


            DB::beginTransaction();
            //photo
            if ($request->has('logo') ) {
                 $filePath = uploadImage('vendors', $request->logo);
                Vendor::where('id', $id)
                    ->update([
                        'logo' => $filePath,
                    ]);
            }


            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

             $data = $request->except('_token', '_method','id', 'logo', 'password');


            if ($request->has('password') && !is_null($request->password)) {

                $data['password'] = $request->password;
            }

            Vendor::where('id', $id)
                ->update(
                    $data
                );

            DB::commit();
            return redirect()->route('vendors.index')->withSuccessMessage( 'تم التحديث بنجاح' );
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }
 
    public function destroy($id)
    {

        try {
            $vendor = Vendor::find($id);
            if (!$vendor) {
                return redirect()->route('vendors.index', $id)->withErrorMessage( 'هذا التاجر  غير موجود' );
                        }
            $vendor->delete();

            return redirect()->route('vendors.index')->withSuccessMessage( 'تم حذف التاحر بنجاح' );

        } catch (\Exception $ex) {
            return redirect()->route('vendors.index')->withErrorMessage( 'هناك خطا ما يرجي المحاوله فيما بعد' );
        }
    }
    public function changeStatus($id)
    {
        try
        {
            $vendor = Vendor::find($id);
            //dd($language);
            if (!$vendor)
                return redirect()->route('vendors.index')->with(['error' => 'هذا التاحر غير موجود ']);
    
            
           $status =  $vendor->active  == 0 ? 1 : 0;
            
           $vendor->update(['active' =>$status ]);
    
            return redirect()->route('vendors.index')->withSuccessMessage( ' تم تغيير الحالة بنجاح ' );
        } catch(\Exception $ex) {
            dd($ex);
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
        
    }


}

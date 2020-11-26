<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\LanguageRequest;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Language::select()->paginate(PAGINATION_COUNT);
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(LanguageRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);

            Language::create($request->except(['_token']));

           
           // return redirect()->route('languages.index');

           return redirect()->route('languages.index')->withSuccessMessage('تم حفظ اللغة بنجاح');

        } catch (\Exception $ex) {
            //dd($ex);
            return redirect()->route('languages.index')->withErrorMessage( 'هناك خطا ما يرجي المحاوله فيما بعد' );
        }
    }

    public function edit($id)
    {
        $language = Language::select()->find($id);
        if (!$language) {
            return redirect()->route('admin.languages')->withErrorMessage( 'هذه اللغة غير موجوده' );
        }

        return view('admin.languages.edit', compact('language'));
    }

    public function update($id, LanguageRequest $request)
    {

        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('admin.languages.edit', $id)->withErrorMessage(  'هذه اللغة غير موجوده');
            }


            if (!$request->has('active'))
                $request->request->add(['active' => 0]);

            $language->update($request->except('_token'));

            return redirect()->route('languages.index')->withSuccessMessage(  'تم تحديث اللغة بنجاح');

        } catch (\Exception $ex) {
            return redirect()->route('languages.index')->withErrorMessage('هناك خطا ما يرجي المحاوله فيما بعد');
        }
    }

    public function destroy($id)
    {

        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('languages.index', $id)->withErrorMessage( 'هذه اللغة غير موجوده' );
                        }
            $language->delete();

            return redirect()->route('languages.index')->withSuccessMessage( 'تم حذف اللغة بنجاح' );

        } catch (\Exception $ex) {
            return redirect()->route('languages.index')->withErrorMessage( 'هناك خطا ما يرجي المحاوله فيما بعد' );
        }
    }
    public function changeStatus($id)
    {
        try
        {
            $language = Language::find($id);
            //dd($language);
            if (!$language)
                return redirect()->route('languages.index')->with(['error' => 'هذه اللغه غير موجود ']);
    
            
           $status =  $language->active  == 0 ? 1 : 0;
            
           $language->update(['active' =>$status ]);
    
            return redirect()->route('languages.index')->withSuccessMessage( ' تم تغيير الحالة بنجاح ' );
        } catch(\Exception $ex) {
            dd($ex);
            return redirect()->route('languages.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
        
    }
}

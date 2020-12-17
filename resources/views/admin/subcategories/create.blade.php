@extends('layouts.admin')

@section('content')


    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسية </a>
                        </li>
                        <li class="breadcrumb-item"><a href=""> الاقسام الفرعيه </a>
                        </li>
                        <li class="breadcrumb-item active">إضافة قسم فرعي
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts">
            <div class="row match-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form"> إضافة قسم فرعي </h4>
                            <a class="heading-elements-toggle"><i
                                    class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        @include('admin.includes.alerts.success')
                        @include('admin.includes.alerts.errors')
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form class="form" action="{{route('sub_categories.store')}}"
                                        method="POST"
                                        enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label> صوره القسم </label>
                                        <label id="projectinput7" class="file center-block">
                                            <input type="file" id="file" name="photo">
                                            <span class="file-custom"></span>
                                        </label>
                                        @error('photo')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">  {{__('messages.main_level')}} </label>
                                                <select name="category_id" class="form-control">
                                                    <option value="">كل الاقسام</option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                               
                                                @error("category_id")
                                                <span class="text-danger"> هذا الحقل مطلوب</span>
                                                @enderror
                                            </div>
                                        </div>
    
                                        <div class="col">
                                            <label for="inputName" class="control-label">الاقسام الفرعيه</label>
                                            <select id="parent_id" name="parent_id" class="form-control">
                                                {{-- <option value="0">قسم فرعي رئيسي</option> --}}
                                            </select>
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">  {{__('messages.cat_level')}} </label>
                                                <select name="parent_id" class="form-control">
                                                    <option value="0">كل الاقسام الفرعيه</option>
                                                    @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}"> {{ $level->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error("parent_id")
                                                <span class="text-danger"> هذا الحقل مطلوب</span>
                                                @enderror
                                            </div>
                                        </div> --}}
    
                                    </div>
                                   

                                    <div class="form-body">

                                        <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>

                                        @if(get_languages() -> count() > 0)
                                            @foreach(get_languages() as $index => $lang)
                                          
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="projectinput1">  {{__('messages.'.'cat'.$lang->abbr)}} </label>
                                                            <input type="text" value="" id="name"
                                                                    class="form-control"
                                                                    placeholder="  "
                                                                    name="category[{{$index}}][name]">
                                                            @error("category.$index.name")
                                                            <span class="text-danger"> هذا الحقل مطلوب</span>
                                                            @enderror
                                                        </div>
                                                    </div>

 
                                                    <div class="col-md-6 hidden">
                                                        <div class="form-group">
                                                            <label for="projectinput1">  {{__('messages.'.'cat'.$lang->abbr)}} </label>
                                                            <input type="text" id="abbr"
                                                                    class="form-control"
                                                                    placeholder="  "
                                                                    value="{{$lang -> abbr}}"
                                                                    name="category[{{$index}}][abbr]">

                                                            @error("category.$index.abbr")
                                                            <span class="text-danger"> هذا الحقل مطلوب</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                    name="category[{{$index}}][active]"
                                                                    id="switcheryColor4"
                                                                    class="switchery" data-color="success"
                                                                    checked/>
                                                            <label for="switcheryColor4"
                                                                    class="card-title ml-1">   {{__('messages.'.'act'.$lang->abbr)}} </label>

                                                            @error("category.$index.active")
                                                            <span class="text-danger"> </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>


                                    <div class="form-actions">
                                        <button type="button" class="btn btn-warning mr-1"
                                                onclick="history.back();">
                                            <i class="ft-x"></i> تراجع
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> حفظ
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic form layout section end -->
    </div>
@endsection

@push('js')
<script>

 $(document).ready(function() {

            $('select[name="category_id"]').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: "{{ URL::to('admin/sub_cat') }}/" + categoryId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            $('select[name="parent_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="parent_id"]').append('<option value=" '+
                                    key + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

            

        });

 
</script>
@endpush

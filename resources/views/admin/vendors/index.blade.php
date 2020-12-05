@extends('layouts.admin')

@section('content')
    
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الاقسام الرئيسية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> ألمتاجر
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع المتاجر </h4>
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
                                    <div class="card-body card-dashboard">
                                        <table id="datatable" class="table hover order-column display nowrap table-striped table-bordered ">
                                            <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th> اللوجو</th>
                                                <th>الهاتف</th>
                                                <th>القسم الرئيسي</th>
                                                <th> ألحالة </th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($vendors)
                                                @foreach($vendors as $key => $vendor)
                                                    <tr>
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$vendor->name}}</td>
                                                        <td><img style="width: 150px; height: 100px;"
                                                                 src="{{$vendor -> 	logo}}"></td>

                                                        <td>{{$vendor->mobile}}</td>
                                                        <td> {{$vendor->category->name}}</td>

                                                        <td> {{$vendor->getActive()}}</td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('vendors.edit',$vendor->id)}}"
                                                                   class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>

                                                                <form action="{{ route('vendors.destroy',$vendor->id)}}"
                                                                    method="post" style="display:inline-block">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field("delete")}}
                                                                    <button type="submit" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1 delete">حذف</button>
                                                                </form>
    
    
                                                                <a href="{{route('vendors.status',$vendor->id)}}"
                                                                   class="btn btn-outline-warning btn-min-width box-shadow-3 mr-1 mb-1">
                                                                    @if($vendor->active == 0)
                                                                        تفعيل
                                                                        @else
                                                                        الغاء تفعيل
                                                                    @endif
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
      
@endsection
 

@push('js')
<script>
    $('.delete').click(function (e) {

        var that = $(this)

        // console.log(that)

        e.preventDefault();

        var n = new Noty({
            text: "Are You Sure You Want Delete This Item",
            type: "warning",
            killer: true,
            buttons: [
                Noty.button("Yes", 'btn btn-success mr-2', function () {
                    that.closest('form').submit();
                }),

                Noty.button("No", 'btn btn-primary mr-2', function () {
                    n.close();
                })
            ]
        });

        n.show();

    }); //end of delete
</script>
@endpush
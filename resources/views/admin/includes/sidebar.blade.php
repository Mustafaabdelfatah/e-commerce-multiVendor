<div class="main-menu menu-fixed sidenav  menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
       <div class="main-menu-content">
           <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
   
   
               <li class="{{Request::is('admin') ? 'active' : '' }} nav-category-divider " style="font-size:15px">
                   <a href="{{ route('admin.dashboard') }}"><span class="link-title">{{ __('messages.main') }}</span>
                       <i class="fa fa-bar-chart" aria-hidden="true"></i>
                   </a>
               </li>
   
               
               <li class="nav-item {{Request::is('admin/languages') ? 'open' : '' }}">
                   <a href=""><i class="la la-home"></i>
                       <span class="menu-title" data-i18n="nav.dash.main"> {{ __('messages.languages') }} </span>
                       <span class="badge badge badge-info badge-pill float-right mr-2">
                           {{ App\Models\Language::active()->count() }}
                       </span>
                   </a>
                   <ul class="menu-content">
                       <li class="{{Request::is('admin/languages') ? 'active' : '' }}"><a class="menu-item" href="{{route('languages.index')}}"
                                             data-i18n="nav.dash.ecommerce">   {{ __('messages.all_languages') }} </a>
                       </li>
                       <li class="{{Request::is('admin/languages/create') ? 'active' : '' }}"><a class="menu-item" href="{{route('languages.create')}}"
                           data-i18n="nav.dash.ecommerce">   {{ __('messages.add_new_languages') }} </a>
                       </li>
                       
                   </ul>
               </li>
   
               <!-- start main categories -->

               <li class="nav-item {{Request::is('admin/main_categories') ? 'open' : '' }}">
                   <a href=""><i class="la la-home"></i>
                       <span class="menu-title" data-i18n="nav.dash.main">{{ __('messages.main_categories') }} </span>
                       <span class="badge badge badge-info badge-pill float-right mr-2">
                           {{ App\Models\MainCategory::active()->DefaultCategory()->count() }}
                       </span>
                   </a>
                   <ul class="menu-content">
                       <li class="{{Request::is('admin/main_categories') ? 'active' : '' }}"><a class="menu-item" href="{{route('main_categories.index')}}"
                                             data-i18n="nav.dash.ecommerce">   {{ __('messages.all_main_categories') }} </a>
                       </li>
                       <li class="{{Request::is('admin/main_categories/create') ? 'active' : '' }}"><a class="menu-item" href="{{route('main_categories.create')}}"
                           data-i18n="nav.dash.ecommerce">   {{ __('messages.add_new_categories') }} </a>
                       </li>
                       
                   </ul>
               </li>

                <!-- end main categories -->

                 <!-- start sub categories -->

               <li class="nav-item {{Request::is('admin/sub_categories') ? 'open' : '' }}">
                <a href=""><i class="la la-home"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{ __('messages.sub_categories') }} </span>
                    <span class="badge badge badge-info badge-pill float-right mr-2">
                        {{ App\Models\SubCategory::active()->DefaultCategory()->count() }}
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{Request::is('admin/sub_categories') ? 'active' : '' }}"><a class="menu-item" href="{{route('sub_categories.index')}}"
                                          data-i18n="nav.dash.ecommerce">   {{ __('messages.all_sub_categories') }} </a>
                    </li>
                    <li class="{{Request::is('admin/sub_categories/create') ? 'active' : '' }}"><a class="menu-item" href="{{route('sub_categories.create')}}"
                        data-i18n="nav.dash.ecommerce">   {{ __('messages.add_new_sub_categories') }} </a>
                    </li>
                    
                </ul>
            </li>

             <!-- end sub categories -->
               

                <!-- start Vendors -->
               <li class="nav-item {{Request::is('admin/vendors') ? 'open' : '' }}">
                <a href=""><i class="la la-home"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{ __('messages.vendors') }} </span>
                    <span class="badge badge badge-info badge-pill float-right mr-2">
                        {{ App\Models\Vendor::active()->count() }}
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{Request::is('admin/vendors') ? 'active' : '' }}"><a class="menu-item" href="{{route('vendors.index')}}"
                                          data-i18n="nav.dash.ecommerce">   {{ __('messages.all_vendors') }} </a>
                    </li>
                    <li class="{{Request::is('admin/vendors/create') ? 'active' : '' }}"><a class="menu-item" href="{{route('vendors.create')}}"
                        data-i18n="nav.dash.ecommerce">   {{ __('messages.add_new_vendors') }} </a>
                    </li>
                    
                </ul>
            </li>
   
            <!-- end Vendors -->
       

                 <li class=" nav-item">
                   <a href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/documentation"><i
                           class="la la-text-height"></i>
                       <span class="menu-title" data-i18n="nav.support_documentation.main">Documentation</span>
                   </a>
               </li>  
           </ul>
       </div>
   </div> 
    
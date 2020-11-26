<nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                            class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a class="navbar-brand" href="index.html">
                        <img class="brand-logo" alt="modern admin logo"
                            src="{{asset('assets/admin/images/logo/logo.png')}}">
                        <h3 class="brand-text">Modern Admin</h3>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                            class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                            href="#"><i class="ft-menu"></i></a></li>
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                class="ficon ft-maximize"></i></a></li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="mr-1">مرجبا
                                <span class="user-name text-bold-700">
                                    {{ auth()->guard('admin')->user()->name }}
                                </span>
                            </span>
                            <span class="avatar avatar-online">
                                <img style="height: 35px;" src="{{ asset('assets/images/default.png') }}" alt="avatar"><i></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href=""><i
                                    class="ft-user"></i> تعديل الملف الشحصي </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('admin\logout') }}"><i class="ft-power"></i> تسجيل
                                الخروج </a>
                        </div>
                    </li>
                    
                    <li class="dropdown dropdown-notification nav-item">

                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-globe"></i>
                           
                            <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">    
                                
                                {{ get_languages() !== null ? \App\Models\Language::active()->Selection()->count() : " " }}
                            </span>
                           
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0">
                                    <span class="grey darken-2">Languages</span>
                                </h6>
                                
                            </li>
                           
                            <li class="scrollable-container media-list w-100">
                                @foreach(get_languages() as $index => $lang)
                                <a href="javascript:void(0)">
                                    <div class="media">
                                        <div class="media-left align-self-center"><i
                                                class="ficon ft-flag"></i></div>
                                        <div class="media-body">
                                            <a href="{{ url('admin/lang/'.$lang->abbr) }}" class="dropdown-item">         
                                                {{ $lang->name }}
                                            </a>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                
                                {{-- <a href="javascript:void(0)">
                                    <div class="media">
                                        <div class="media-left align-self-center"><i
                                                class="ficon ft-flag"></i></div>
                                        <div class="media-body">
                                            <a href="{{ url('admin/lang/en') }}" class="dropdown-item">
                                                 
                                                English
                                              </a>  
                                        </div>
                                    </div>
                                </a> --}}
                            </li>
                            
                        </ul>
                        
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</nav>
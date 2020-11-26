 @include('admin.includes.header')
 <!-- ////////////////////////////////////////////////////////////////////////////-->

 @include('admin.includes.nav')
 <!-- ////////////////////////////////////////////////////////////////////////////-->

 @include('admin.includes.sidebar')
 <div class="app-content content">
     <div class="content-wrapper">

         @yield('content')

     </div>
 </div>

 @include('admin.includes.footer')
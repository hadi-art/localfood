<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@section('title') Local Food @show</title>
		<!-- Vendor styles -->

		<!-- App styles -->
		<link rel="stylesheet" href="{{asset('css/app.min.css')}}">
		<link rel="stylesheet" href="{{ asset('css/style.css')}}?20200513" />
		<link rel="stylesheet" href="{{ asset('vendors/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
		<link rel="stylesheet" href="{{ asset('vendors/bootstrap-fileinput/css/fileinput.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css')}}" />
		<link rel="stylesheet" href="{{ asset('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendors/bower_components/animate.css/animate.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendors/bower_components/select2/dist/css/select2.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendors/bower_components/nouislider/distribute/nouislider.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendors/bower_components/dropzone/dist/dropzone.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}"  />
		<link rel="stylesheet" href="{{asset('vendors/sweetalert2/sweetalert2.min.css')}}">
		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}?20190528" rel="stylesheet">
		<script type="text/javascript" src="{{asset('js/app2.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('js/layer/layer.js')}}"></script>
		<style type="text/css">
			ul { list-style-type: none;}
			/*.active{ background-color:#e8e9ea;}*/
            .pagination {
                margin-top: 13px;
            }
      .must_input_i { color: red; margin-right: 1rem;}
		</style>
		@yield('style')
	</head>
	<body data-ma-theme="blue">
		<main class="main">
			<!-- Header -->
			<header class="header">
				<div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
					<div class="navigation-trigger__inner">
						<i class="navigation-trigger__line"></i>
						<i class="navigation-trigger__line"></i>
						<i class="navigation-trigger__line"></i>
					</div>
				</div>

				<div class="header__logo hidden-sm-down">
{{--				<img src="{{asset('img/kiple-logo-white.png')}}" alt="kiplepark-logo" width="150" >--}}
				<!-- <h1><a href="index.html">LOCAL FOOD</a></h1> -->
				</div>


				<ul class="top-nav">

					<li class="dropdown">
						<a href="" data-toggle="dropdown"><div><i class="zmdi zmdi-account-circle zmdi-hc-3x"></i></div></a>

						<div class="dropdown-menu dropdown-menu-right">
 								<div class="user">
									<div class="user__info">
										<img class="user__img" src="{{asset('img/profile-pics/4.jpg')}}" alt="">
										<div>
											<div class="user__name"> {{ Auth::user()->name }}</div>
											<div class="user__email"> {{ Auth::user()->email }}</div>
										</div>
									</div>

									<div class="dropdown-menu">

									</div>
								</div>
  							<a class="dropdown-item" href="">Profile</a>


								<a class="dropdown-item" href="{{ route('change-password') }}">
										{{ __('Change Password') }}
								</a>

							<a class="dropdown-item" href="{{ route('logout') }}"
							   onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>

						</div>
					</li>
				</ul>
			</header>
			<!-- Sidebar -->
			<aside class="sidebar" style="border-style: solid; border-width: 1px;border-color:#e0e0e0;">
				<div class="scrollbar-inner">
					<ul class="navigation">
                        @php
                            $routeName = Route::currentRouteName();
                            $route = \App\Permission::where(['route_name'=>$routeName])->select(['parent_id','id','type'])->first();
                            //if route level is  button level should find the parent level
                            $checkRoute = $routeName;
                            if($route){
                                 if($route->type==1){
                                    $parentRoute = \App\Permission::where(['id'=>$route->parent_id])->value('route_name');
                                    if($parentRoute){
                                        $checkRoute = $parentRoute;
                                    }
                                 }
                            }
                        @endphp

						@foreach ($menus as $item)
						@if ($item->allChilds->isNotEmpty())
							@can($item->name)
							<li class="navigation__sub">
								<a href="javascript:void(0);"><i class="zmdi {{$item->icons_name}}"></i>{{$item->display_name}}</a>
								<ul @if(in_array($checkRoute,$item->allChilds->pluck('route_name')->toArray())) style="display: block;"@endif>
									@foreach($item->allChilds as $menu)
                                        @if(Route::has($menu->route_name))
                                            @can($menu->name)
                                            <li class="nav-item @if($checkRoute==$menu->route_name) active @endif">
                                                <a class="nav-link" href="{{route($menu->route_name)}}">
                                                <i class="zmdi {{$menu->icons_name}}"></i> {{$menu->display_name}}</a>
                                            </li>
                                            @endcan
                                        @endif
									@endforeach
								</ul>
							</li>
							@endcan
						@else
                            @if(Route::has($item->route_name))
                                @can($item->name)
                                <li class="nav-item @if(Request::is($item->route_name)) active @endif">
                                    <a @if ($item->route_name == "javascript:void(0);") href="{{$item->route_name}}" @else href="{{ route($item->route_name) }}" @endif >
                                        <i class="zmdi {{$item->icons_name}}"></i>
                                        {{$item->display_name}}
                                    </a>
                                </li>
                                @endcan
                            @endif
						@endif
						@endforeach
					</ul>
				</div>
			</aside>


			<!-- Contents -->
			<section class="content">
				<div class="content__inner">

					<div class="container">
						@yield('content')
					</div>
					<!-- Footer -->
					<footer class="footer hidden-xs-down">
						<p>© v1.0.0 2020 | Copyright by hadi</p>
					</footer>
				</div>
			</section>

			<script type="text/javascript" src="{{asset('vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('vendors/bower_components/popper.js/dist/umd/popper.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('vendors/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('js/app.min.js')}}"></script>


			<script type="text/javascript" src="{{asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>


			<script type="text/javascript" src="{{asset('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js')}}"></script>

			<script src="{{asset('vendors/bower_components/flot/jquery.flot.js')}}"></script>
			<script src="{{asset('vendors/bower_components/flot/jquery.flot.pie.js')}}"></script>
			<script src="{{asset('vendors/bower_components/flot/jquery.flot.resize.js')}}"></script>
			<script src="{{asset('vendors/bower_components/flot.curvedlines/curvedLines.js')}}"></script>
			<script src="{{asset('vendors/bower_components/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
			<script src="{{asset('vendors/bower_components/nouislider/distribute/nouislider.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/dropzone/dist/min/dropzone.min.js')}}"></script>

            <link rel="stylesheet" href="{{ asset('vendors/bower_components/datatables.net/css/fixedColumns.bootstrap4.css') }}"  />
			<script src="{{asset('vendors/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/jszip/dist/jszip.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/autosize/dist/autosize.min.js')}}"></script>


			<script src="{{asset('vendors/bower_components/jqvmap/dist/jquery.vmap.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
			<script src="{{asset('vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/salvattore/dist/salvattore.min.js')}}"></script>
			<script src="{{asset('vendors/jquery.sparkline/jquery.sparkline.min.js')}}"></script>
			<script src="{{asset('vendors/bower_components/moment/min/moment.min.js')}}"></script>

			{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
			<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> --}}
			<script src="{{asset('vendors/bower_components/trumbowyg/dist/trumbowyg.min.js')}}"></script>
			<script src="{{asset('vendors/flatpickr/flatpickr.min.js')}}"></script>
			<script src="{{asset('vendors/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
			<script src="{{asset('vendors/sweetalert2/sweetalert2.min.js')}}"></script>
			<script src="{{asset('js/dataTables.treeGrid.js')}}"></script>
            <script src="{{asset('vendors/bower_components/datatables.net/js/dataTables.fixedColumns.js')}}"></script>
			<script type="text/javascript" src="{{asset('js/base64.js')}}"></script>
            <script type="text/javascript" src="{{asset('vendors/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
            <script type="text/javascript" src="{{asset('vendors/bootstrap-fileinput/js/fileinput.js')}}"></script>
            <script type="text/javascript" src="{{asset('js/common.js')}}"></script>
			@yield('script')
		</main>
	</body>
</html>

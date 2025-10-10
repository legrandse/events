<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'events' . config('app.name', 'Laravel') }}</title>
	 
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}">   
     <!-- Hierarchy Select CSS -->
	
	<link rel="stylesheet" href="{{asset('assets/css/templatemo-chain-app-dev.css')}}">   
    
    
	<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">-->
	<link href="{{ asset('time-picker/dist/css/timepicker.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
	@livewireStyles
    <!-- Scripts -->
   
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
   
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
     <script src="{{ asset('datepicker/i18n/datepicker-fr.js') }}"></script> 
    
<!--
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>-->
	<script src="{{ asset('time-picker/dist/js/timepicker.js') }}"></script>
	 <!-- Hierarchy Select Js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.js"></script>
   	<script src="https://kit.fontawesome.com/ad6bf95f69.js" crossorigin="anonymous"></script>
 	<script src="{{ asset('js/dselect.js')}}"></script>
 	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-primary bg-gradient">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="py-1 d-flex flex-row align-items-center justify-content-between">
                <a class="navbar-brand" href="{{ url('/') }}">
                   <img id="logo" src="{{ asset('storage/logo/logo.jpg') }}" width="20%" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                         @auth
                        
                          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
					        @can('event-list')
					        <li class="nav-item">
					          <a class="nav-link active" aria-current="page" href="/home">{{__('Events')}}</a>
					        </li>
					        @endcan
					        @can('user-create')
					        <li class="nav-item">
					          <a class="nav-link" href="{{ route('users.index') }}">{{__('Users management')}}</a>
					        </li>
					        @endcan
					        @can('role-list')
					        <li class="nav-item dropdown">
					          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					          {{__('Settings')}}
					          </a>
					          <ul class="dropdown-menu">
					            <li><a class="dropdown-item" href="{{ route('roles.index') }}">{{__('Roles')}}</a></li>
					            <li><a class="dropdown-item" href="{{ route('settings') }}">{{__('Control panel')}}</a></li>
					          </ul>
					        </li>
					        @endcan
					      </ul>
					   
						@endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Sending shifts button -->
                        
                        
                        
                        
                        
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                  <!--  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>-->
                                  <a class="nav-link" data-bs-toggle="modal" data-bs-target="#registerModal"> {{ __('Login') }}</a>
                                </li>
                                
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <!--<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>-->
                                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#registerModal"> {{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname.' '.Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
									
                                    <a class="dropdown-item" href="{{ route('users.edit',['user'=>Crypt::encryptString( auth()->user()->id) ])  }}">{{ __('Profil management') }}</a>
                                
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>
    </div>
</body>



@livewireScripts
@stack('script')
</html>

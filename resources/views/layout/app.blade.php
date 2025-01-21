<!DOCTYPE html>
<html lang="en">

<head>
    <title>Products</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container my-5">
       <nav class="navbar navbar-expand-md navbar-light bg-white shadow-lg mb-4">
           <div class="container">
               <a class="navbar-brand" href="{{ url('/') }}">
                   {{ config('app.name', 'Sasi') }}
               </a>
             <div class="collapse navbar-collapse" id="navbarSupportedContent">
                   <!-- Right Side Of Navbar -->
                   <ul class="navbar-nav ml-auto">
                       {{-- <li class="nav-item">
                           <a class="nav-link" href="{{ route('welcome') }}">Home</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('login') }}">Login</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('register') }}">Register</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                       </li> --}}
                       <li class="nav-item">
                           <a class="nav-link" href="{{ url('developer') }}">Developers</a>
                       </li>
                   </ul>
               </div>
           </div>
       </nav>
        @yield('content')
    </div>
</body>

</html>

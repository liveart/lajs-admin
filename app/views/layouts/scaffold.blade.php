<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{{ $page_title or 'Admin'}}} - LiveArt</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.9.3/cropper.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.9.3/cropper.min.js"></script>
</head>
<body style="padding-top: 70px;">

@if (Auth::check())
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">LiveArt Admin</a>
        </div>
        <div id="navbar">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Products<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('categories.index', 'Product Categories') }}</li>
                        <li>{{ link_to_route('products.index', 'Products') }}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Artwork<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('graphicsCategories.index', 'Artwork Categories') }}</li>
                        <li>{{ link_to_route('graphicsItems.index', 'Artwork Items') }}</li>
                    </ul>
                </li>
                <li>{{ link_to_route('fonts.index', 'Fonts') }}</li>
                <li>{{ link_to_route('colors.index', 'Decoration Colors') }}</li>
                <!-- <li>{{ link_to('/import', 'Import') }}</li> -->
            </ul>
            <div class="navbar-text pull-right">
                <span id="loginInfo"><span>Logged in as {{ Auth::user()->name }}</span></span>
                <a class="btn btn-primary btn-xs" href="{{ URL::to('logout') }}">Logout</a>
            </div>
        </div>
    </div>
</nav>
@endif

<div class="container">
    @if (Session::has('message'))
        <div class="flash alert alert-success" role="alert">
            <p>{{ Session::get('message') }}</p>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="flash alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{ Session::get('error') }}
        </div>
    @endif
    @yield('main')
</div>

</body>
</html>
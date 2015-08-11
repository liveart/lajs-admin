<!doctype html>
<html>
<head>
    <title>{{{ $page_title or 'Admin'}}} - LiveArt</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.9.3/cropper.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.9.3/cropper.min.js"></script>
    <style>
        body { padding-top: 2px; }
    </style>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">LiveArt Admin</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li>{{ link_to_route('products.index', 'Products') }}</li>
        <li>{{ link_to_route('categories.index', 'Categories') }}</li>
        <li>{{ link_to_route('graphicsCategories.index', 'Graphics Categories') }}</li>
        <li>{{ link_to_route('graphicsItems.index', 'Graphics Items') }}</li>
        <li>{{ link_to_route('fonts.index', 'Fonts') }}</li>
        <li>{{ link_to_route('colors.index', 'Colors') }}</li>
        <li>{{ link_to('/import', 'Import from JSON') }}</li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12">
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
    </div>
</div>

</body>
</html>
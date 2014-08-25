<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <style>
        body { padding-top: 20px; }
    </style>
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">LiveArt Admin</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li>{{ link_to_route('products.index', 'Products') }}</li>
        <li>{{ link_to_route('categories.index', 'Categories') }}</a></li>
        <li><a href="#">Gallery Categories</a></li>
        <li><a href="#">Gallery Items</a></li>
        <li><a href="#">Fonts</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (Session::has('message'))
                <div class="flash alert">
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif

            @yield('main')

        </div>
    </div>
</div>

</body>
</html>
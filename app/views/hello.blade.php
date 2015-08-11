@extends('layouts.scaffold')
@section('main')
	<div class="jumbotron">
        <div class="container">
            <h1>LiveArt HTML5 Admin Area <sup>BETA</sup> </h1>
            <p>Welcome to LiveArt HTML5 Admin Area. This area helps in setting up LiveArt's configuration files, such as Products, Graphics and Fonts.</p>
            <p>Where to start:</p>
            <ul>
                <li>Set up product categories</li>
                <li>Setup product and its locations</li>
                <li>Add couple of graphics categories</li>
                <li>Add graphic images</li>
                <li>Upload fonts</li>
            </ul>
            <p>Quick reference / Magic numbers:</p>
            <dl class="dl-horizontal">
                <dt>Product/Canvas</dt>
                <dd>587x543 pixels, unless manually resized</dd>
                <dt>Thumbnail</dt>
                <dd>110x110px</dd>
            </dl>
            <p>
                <a class="btn btn-lg btn-primary" href="http://liveart.uservoice.com/knowledgebase" role="button" target="_blank">Visit Knowledge Base »</a>
            </p>
        </div>
	</div>
@stop
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/userprofile.css') }}">

<div class="container">
    <div class="row profile">
		@include('client.profile.layouts.partials.menu')
        @include('client.profile.layouts.partials.content')
	</div>
</div>



@if (Session::has('success'))
<div class="alert alert-dismissible fade show alert-card alert-success" role="alert"><strong class="text-capitalize">{{ Session::get('success') }}</strong></div>
@endif
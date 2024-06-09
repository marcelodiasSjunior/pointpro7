@if($errors->any())
{!! implode('', $errors->all('
<div class="alert alert-dismissible fade show alert-card alert-danger" role="alert"><strong class="text-capitalize">Erro:</strong> :message </div>
')) !!}
@endif
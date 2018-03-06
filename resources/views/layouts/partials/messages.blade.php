@foreach (['danger', 'warning', 'success', 'info', 'error'] as $msg) @if(Session::has('alert-' . $msg))
<div class="flash-message">
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
</div>
@endif @endforeach 
@if ($errors->any()) 
@foreach ($errors->all() as $error)
<div class="flash-message">
    <p class="alert alert-danger">{{ $error }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
</div>
@endforeach
@endif
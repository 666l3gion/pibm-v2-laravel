@if( session('failed') )
<div class="alert alert-danger block" role="alert">
    {{ session('failed') }}
</div>
@endif

@if( session('success') )
<div class="alert alert-success block" role="alert">
    {{ session('success') }}
</div>
@endif
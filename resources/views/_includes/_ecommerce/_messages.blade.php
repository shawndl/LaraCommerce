
@if(\Illuminate\Support\Facades\Session::has('message'))
    <div class="alert alert-info">
        <strong>Update:</strong>  {{ \Illuminate\Support\Facades\Session::get('message') }}
    </div>
@endif

@if(\Illuminate\Support\Facades\Session::has('error'))
    <div class="alert alert-danger">
        <strong>Error:</strong>  {{ \Illuminate\Support\Facades\Session::get('error') }}
    </div>
@endif


@if(isset($errors) && count($errors) > 0)
    <div class="help-block alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div><!-- /.help-block -->
@endif

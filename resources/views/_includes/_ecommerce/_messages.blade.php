
@if(isset($errors) && count($errors) > 0)
    <div class="help-block alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div><!-- /.help-block -->
@endif

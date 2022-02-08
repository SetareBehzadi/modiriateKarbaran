@if(session('success'))
	<div class="alert alert-success">
		@lang('users.success')
	</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{session('error') }}
    </div>
@endif

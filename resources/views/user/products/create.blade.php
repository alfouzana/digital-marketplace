@extends('user.layout')

@section('title', __('Add a product'))

@section('content')
	<h3>
		<i class="fa fa-plus"></i>
		@lang('Add a product')
	</h3>
	
	<div class="row">
		<div class="col-lg-8">
			{{ Form::open(['url' => '/user/products'])}}
				<div class="form-group row">
					<label for="cover_file"
						   class="col-lg-4 col-form-label text-lg-right">Cover</label>
					<div class="col-lg-8">
						<input type="file" 
						   id="cover_file"
						   class="form-control-file"
						   required="true" 
						   data-assoc="cover"
						   data-field-id="cover_id"
						   onchange="upload(event)">
						<input type="hidden" id="cover_id" name="cover_id">
					</div>
				</div>

				<div class="form-group row">
					<label for="sample_file"
						   class="col-lg-4 col-form-label text-lg-right">Sample</label>
					<div class="col-lg-8">
						<input type="file" 
						   id="sample_file"
						   class="form-control-file"
						   required="true" 
						   data-assoc="sample"
						   data-field-id="sample_id"
						   onchange="upload(event)">
						<input type="hidden" id="sample_id" name="sample_id">
					</div>
				</div>

				<div class="form-group row">
					<label for="product_file"
						   class="col-lg-4 col-form-label text-lg-right">File</label>
					<div class="col-lg-8">
						<input type="file" 
						   id="product_file"
						   class="form-control-file"
						   required="true" 
						   data-assoc="product"
						   data-field-id="file_id"
						   onchange="upload(event)">
						<input type="hidden" id="file_id" name="file_id">
					</div>
				</div>

		        <div class="form-group row">
		            {{ Form::label('category_id', __('Category'), [
		                'class' => 'col-lg-4 col-form-label text-lg-right'
		            ]) }}

		            <div class="col-lg-8">
		                {{ Form::select('category_id', $category_options, null, [
		                    'required',
		                    'class' => 'form-control' . ($errors->has('category_id') ? ' is-invalid' : '')
		                ]) }}

		                @if($errors->has('category_id'))
		                    <div class="invalid-feedback">
		                        {{ $errors->first('category_id') }}
		                    </div>
		                @endif
		            </div>
		        </div>

				<div class="form-group row">
		            {{ Form::label('title', __('Title'), [
		                'class' => 'col-lg-4 col-form-label text-lg-right'
		            ]) }}

		            <div class="col-lg-8">
		                {{ Form::text('title', null, [
		                    'required',
		                    'class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : '')
		                ]) }}

		                @if($errors->has('title'))
		                    <div class="invalid-feedback">
		                        {{ $errors->first('title') }}
		                    </div>
		                @endif
		            </div>
		        </div>

		        <div class="form-group row">
		            {{ Form::label('body', __('Body'), [
		                'class' => 'col-lg-4 col-form-label text-lg-right'
		            ]) }}

		            <div class="col-lg-8">
		                {{ Form::textarea('body', null, [
		                    'required',
		                    'class' => 'form-control' . ($errors->has('body') ? ' is-invalid' : '')
		                ]) }}

		                @if($errors->has('body'))
		                    <div class="invalid-feedback">
		                        {{ $errors->first('body') }}
		                    </div>
		                @endif
		            </div>
		        </div>

		        <div class="form-group row">
		            {{ Form::label('price', __('Price'), [
		                'class' => 'col-lg-4 col-form-label text-lg-right'
		            ]) }}

		            <div class="col-lg-8">
		                {{ Form::number('price', null, [
		                    'required',
		                    'min' => '0',
		                    'class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : '')
		                ]) }}

		                @if($errors->has('price'))
		                    <div class="invalid-feedback">
		                        {{ $errors->first('price') }}
		                    </div>
		                @endif
		            </div>
		        </div>

				<div class="col-lg-8 offset-lg-4">
					<button type="submit" class="btn btn-primary">@lang('Create')</button>
				</div>
			{{ Form::close() }}
		</div>
	</div>

	<script type="text/javascript">
		function upload(event)
		{
			debugger;

			let formData = new FormData();

			formData.append('file', event.target.files[0]);
			formData.append('assoc', event.target.dataset.assoc);

			// let xhr = new XMLHttpRequest;

			// xhr.open('POST', '/user/files', true);
			// xhr.send(formData);

			axios.post('/user/files', formData).then(function ({data}) {
				console.log(data);

				let field = document.getElementById(event.target.dataset.fieldId);

				field.value = data.id
			});
		}
	</script>
@endsection

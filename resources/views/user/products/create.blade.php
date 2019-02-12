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
					<label for="cover-file"
					       class="col-lg-4 col-form-label text-lg-right">@lang('Cover')</label>

			        <div class="col-lg-8">
						<file-upload assoc="cover"
									 name="cover_id"
									 id="cover-file"
									 upload-text="@lang('Upload')"></file-upload>
			        </div>

				</div>

				<div class="form-group row">
					<label for="sample-file"
					       class="col-lg-4 col-form-label text-lg-right">@lang('Sample')</label>

			        <div class="col-lg-8">
						<file-upload assoc="sample"
							 name="sample_id"
							 id="sample-file"
							 upload-text="@lang('Upload')"></file-upload>
			        </div>

				</div>

				<div class="form-group row">
					<label for="product-file"
					       class="col-lg-4 col-form-label text-lg-right">@lang('File')</label>

			        <div class="col-lg-8">
						<file-upload assoc="product"
							 name="file_id"
							 id="product-file"
							 upload-text="@lang('Upload')"></file-upload>
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
@endsection

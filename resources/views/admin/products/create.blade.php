@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.product.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.product.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.product.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                        id="description">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="categories">{{ trans('cruds.product.fields.category') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}"
                        name="categories[]" id="categories" multiple>
                        @foreach ($categories as $id => $category)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('categories'))
                        <div class="invalid-feedback">
                            {{ $errors->first('categories') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="tags">{{ trans('cruds.product.fields.tag') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]"
                        id="tags" multiple>
                        @foreach ($tags as $id => $tag)
                            <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>
                                {{ $tag }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('tags'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tags') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.tag_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="photo">{{ trans('cruds.product.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                    </div>
                    @if ($errors->has('photo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('photo') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.photo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="price">{{ trans('cruds.product.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                        name="price" id="price" value="{{ old('price', '') }}" step="0.01" required>
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.price_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="price_increase_by">{{ trans('cruds.product.fields.price_increase_by') }}</label>
                    <input class="form-control {{ $errors->has('price_increase_by') ? 'is-invalid' : '' }}" type="number"
                        name="price_increase_by" id="price_increase_by" value="{{ old('price_increase_by', '1') }}"
                        step="0.01">
                    @if ($errors->has('price_increase_by'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price_increase_by') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.price_increase_by_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="current_price">{{ trans('cruds.product.fields.current_price') }}</label>
                    <input class="form-control {{ $errors->has('current_price') ? 'is-invalid' : '' }}" type="number"
                        name="current_price" id="current_price" value="{{ old('current_price', '') }}" step="0.01">
                    @if ($errors->has('current_price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('current_price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.current_price_helper') }}</span>
                </div>


                {{-- New --}}
                <div class="row">


                    {{-- auction_starting_price --}}
                    <div class="form-group col-md-4">
                        <label for="auction_starting_price">Auction starting price</label>
                        <input class="form-control" type="number" name="auction_starting_price" id="auction_starting_price"
                            value="{{ old('auction_starting_price', '') }}" step="0.01">
                        <span class="help-block">Auction will start from this price</span>
                    </div>
                    {{-- auction_duration --}}
                    <div class="form-group col-md-4">
                        <label for="auction_duration">Auction Duration</label>
                        <input class="form-control" type="number" name="auction_duration" id="auction_duration"
                            value="{{ old('auction_duration', '') }}" step="1">
                        <span class="help-block">In Seconds</span>
                    </div>
                    {{-- auction_start_time --}}
                    <div class="form-group col-md-4">
                        <label for="auction_start_time">Auction start Date & time</label>
                        <input class="form-control datetime" type="text" name="auction_start_time"
                            id="auction_start_time" value="{{ old('auction_start_time', '') }}" step="1">

                    </div>
                </div>


                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var uploadedPhotoMap = {}
        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.products.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="photo[]" value="' + response.name + '">')
                uploadedPhotoMap[file.name] = response.name
            },
            removedfile: function(file) {
                console.log(file)
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPhotoMap[file.name]
                }
                $('form').find('input[name="photo[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($product) && $product->photo)
                    var files = {!! json_encode($product->photo) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="photo[]" value="' + file.file_name + '">')
                    }
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection

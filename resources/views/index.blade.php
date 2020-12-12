@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">XML UPLOADER</div>
                <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('upload') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="filexml" class="col-md-4 col-form-label text-md-right">{{ __('Choose file') }}
                            (Accept the sending of multiple files)</label>
                            <div class="col-md-6">
                                <input id="filexml" type="file" multiple
                                class="form-control @error('filexml') is-invalid @enderror"
                                name="filexml[]" accept=".xml">
                                
                                @error('filexml')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if(isset($errors) && count($errors) > 0)
                                    @foreach($errors->all() as $e)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $e }}</strong>
                                    </span>
                                    @endforeach
                                @endif

                                @if(isset($success))
                                <span class="alert-success" role="alert">
                                    <strong>{{ $success }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                <i class="material-icons">publish</i><br> {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
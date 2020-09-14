@extends('account.layouts.default')

@section('account.content')
    <h1 class="title">Update your file</h1>

    @if($approval)
        @include('account.files.partials._changes')
    @endif

    <form action="{{ route('account.files.update', $file) }}" method="POST" class="form">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <div class="field">
            <div id="file" class="dropzone"></div>
        </div>

        @if($errors->has('uploads'))
            <p class="help is-danger">
                {{ $errors->first('uploads') }}
            </p>
        @endif

        <div class="field">
            <p class="control">
                <input type="checkbox" name="live" id="live" {{ $file->isLive() ? ' checked' : '' }}>
                Live
            </p>
        </div>

        <div class="field">
            <label for="title" class="label">Title</label>
            <p class="control">
                <input type="text" name="title" id="title" class="input{{ $errors->has('title') ? ' is-danger' : '' }}" value="{{ old('title') ?: $file->title }}">
            </p>

            @if($errors->has('title'))
                <p class="help is-danger">
                    {{ $errors->first('title') }}
                </p>
            @endif
        </div>

         <div class="field">
            <label for="overview_short" class="label">Short Overview</label>
            <p class="control">
                <input type="text" name="overview_short" id="overview_short" class="input{{ $errors->has('overview_short') ? ' is-danger' : '' }}" value="{{ old('overview_short') ?: $file->overview_short }}">
            </p>

            @if($errors->has('overview_short'))
                <p class="help is-danger">
                    {{ $errors->first('overview_short') }}
                </p>
            @endif
        </div>

         <div class="field">
            <label for="overview" class="label">Overview</label>
            <p class="control">
                <textarea name="overview" id="overview" class="textarea{{ $errors->has("overview") ? " is-danger" : "" }}">{{ old('overview') ?: $file->overview }}</textarea>
            </p>

            @if($errors->has('overview'))
                <p class="help is-danger">
                    {{ $errors->first('overview') }}
                </p>
            @endif
        </div>

         <div class="field">
            <label for="price" class="label">Price ($)</label>
            <p class="control">
                <input type="text" name="price" id="price" class="input{{ $errors->has('price') ? ' is-danger' : '' }}" value="{{ old('price') ?: $file->price }}">
            </p>

            @if($errors->has('price'))
                <p class="help is-danger">
                    {{ $errors->first('price') }}
                </p>
            @endif
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button class="button is-primary">Submit</button>
                <p>Your edits will be subject to review.</p>
            </p>
        </div>
    </form>
@endsection

@section('scripts')
    @include('files.partials._file_upload_js')
@endsection

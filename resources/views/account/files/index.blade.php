@extends('account.layouts.default')

@section('account.content')
    @if($files->count())
        @each('account.partials._file', $files, 'file')
    @else
        <p>You have no files.</p>
    @endif
@endsection

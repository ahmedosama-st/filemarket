@extends('emails.layouts.default')

@section('content')
    <p>
        Thanks for purchasing <strong>{{ $sale->file->title }}</strong> from Filemarket.
    </p>

    <p>
        <a href="{{ route('file.download', [$sale->file, $sale]) }}">Download your file</a>
    </p>

    <p>
        Or, copy and paste this into your browser: <Br>
        {{ route('file.download', [$sale->file, $sale]) }}
    </p>
@endsection

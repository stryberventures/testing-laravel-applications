@extends('emails.layout')
@section('content')
    <p class="text greeting" style="margin:0;font-size:16px;padding-top:20px;padding-bottom:30px;">
        Hi,
    </p>
    <p class="text" style="margin:0;font-size:16px;">
        API endpoint {{ $route }} called
    </p>
@endsection

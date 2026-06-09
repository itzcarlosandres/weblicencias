@extends('emails.layouts.premium')

@section('title', $subject)

@section('content')
<h1>{{ $title }}</h1>

<div style="white-space: pre-wrap; font-size: 15px; color: #D1D5DB; line-height: 1.6;">
{{ $content }}
</div>

@if($buttonText && $buttonUrl)
<div class="btn-container">
    <a href="{{ $buttonUrl }}" class="btn">{{ $buttonText }}</a>
</div>
@endif
@endsection

@section('unsubscribe')
{{ url('/') }}
@endsection

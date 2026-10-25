{{-- @extends('frontend.base')

@section('content') --}}
<h3>Scan this QR code with Google Authenticator</h3>
<div>{!! $qr !!}</div>

<p>Or enter this code manually: <strong>{{ $secret }}</strong></p>

{{-- @endsection --}}
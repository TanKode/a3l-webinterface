@extends('emails.email')

@section('content')
	<h1 style="Margin-top: 0;color: #262626;font-weight: 700;font-size: 36px;Margin-bottom: 18px;font-family: Tahoma,sans-serif;line-height: 44px">Log Action Report</h1>
	<p style="Margin-top: 0;color: #262626;font-family: sans-serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
		<strong style="font-weight: bold">Editor:</strong> {{ $editor['name'] }} ({{ $editor['id'] }})
		<br />
		<strong style="font-weight: bold">Action:</strong> {{ $action }}
		<br />
		<strong style="font-weight: bold">Comment:</strong> {{ $comment }}
	</p>
	<p style="Margin-top: 0;color: #262626;font-family: sans-serif;font-size: 16px;line-height: 25px;Margin-bottom: 24px">
		<strong style="font-weight: bold">Table:</strong> {{ $table }}
		@if($object != false)
			<br />
			<strong style="font-weight: bold">Object:</strong> {{ Setting::get('vehicle.'.$object['name'], $object['name']) }} ({{ $object['id'] }})
		@endif
		@if($owner != false)
			<br />
			<strong style="font-weight: bold">Owner:</strong> {{ $owner['name'] }} ({{ $owner['id'] }})
		@endif
	</p>
	<p style="text-align: center;">
		<span class="btn">
			<a href="{{ url('/') }}">zum A3L WebInterface</a>
		</span>
	</p>
@endsection
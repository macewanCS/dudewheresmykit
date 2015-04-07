@extends('master')

@section('content')
	@if(Auth::user()->permission_id >= 2) 
		<a href="{{{ url("/kits/create") }}}"><input type="button" value="Add a Kit"></a>
		<a href="{{{ url("/types/") }}}"><input type="button" value="Kit Type Management"></a>
		<br><br>
	@endif
	<div id="types"> 
		| <a href="{{{ url("kits") }}}"> All </a> | 
		@foreach($types as $type) 
			| <a href="{{{ url("kits/" . $type->id) }}}">{{{ $type->name }}}</a> |
		@endforeach

		<br><br>
		<ul>
			@foreach($kits as $kit)
				<a href="#{{{ $kit->id }}}">
					<li style="display:inline;">{{{ $kit->code }}}</li>
				</a>
			@endforeach
		</ul>
	</div>

	@foreach($kits as $kit)
		<a id="{{{ $kit->id }}}">
			<div class="kit">
				<div class="kitTitle">
					<span style="font-weight:bold;">Kit #{{{ $kit->code}}}</span> of type <a href="{{{ url('kits/' . $kit->type->id) }}}">{{{ $kit->type->name }}}</a>
				</div>
				<div class="kitInfo">
					@if($kit->note) 
						<div class="kitNote">{{{ $kit->note }}}</div>
					@endif
					<p>{{{ $kit->description }}}</p>
					<p><b>Bookings:</b></p>
					@foreach($kit->currentBookings as $booking) 
						<ul>
							<li>{{{ substr($booking->start_date,0,10) }}} till {{{ substr($booking->end_date,0,10) }}}</li>
						</ul>
					@endforeach
					<p><b>Kit Contains:</b></p>
					<ul>
					@foreach($kit->items as $item) 
						<li><b>{{{ $item->name }}}</b>: 
							@if($item->note) 
								<span class="itemNote">{{{ $item->note }}}</span>
							@endif
							<p>{{{ $item->description }}}</p>

						</li>
						
					@endforeach
					</ul>
				</div>
				<div class="kitButton">
					<a href="{{{ url("booking/$kit->id") }}}"><input type="button" value="Book it!"></a>
					<a href="{{{ url("kits/report/$kit->id") }}}"><input type="button" value="Report problem"></a>
					<a href="{{{ url("kits/show/$kit->id") }}}"><input type="button" value="Details"></a>
					@if(Auth::user()->permission_id >= 2)
						<a href="{{{ url("kits/edit/$kit->id") }}}"><input type="button" value="Edit kit"></a>
					@endif
				</div>
			</div>
		</a>
	@endforeach
@stop

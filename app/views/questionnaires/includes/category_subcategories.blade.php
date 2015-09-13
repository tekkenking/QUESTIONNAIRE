<div class="alert alert-warning">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<p class="form-control-static text-bold font-md">{{{$qcatname}}}</p>
				<input type="hidden" name="questioncat" value="{{$qcatid}}">
			</div>
		</div>

		<div class="col-md-5">
			<div class="form-group">
				<select class="form-control questionsubcat" name="questionsubcat">
						@if( !empty($qsubcats) )
							@foreach( $qsubcats as $qsubcat )
								<option value="{{$qsubcat['id']}}" @if( isset($currentqsubcatid) && $currentqsubcatid === $qsubcat['id'] ) selected="true" @endif>
									@if( $qsubcat['name'] === 'No sub-category' )
										-- Select Question Sub-Category --
									@else
										{{{$qsubcat['name']}}}
									@endif
								</option>
							@endforeach
						@endif
				</select>
			</div>
		</div>
	</div>
</div>
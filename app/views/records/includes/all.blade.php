<div class="pagination-content list-group">
<?php $results = ''; ?>

	@if( isset($fordates) )

		<?php $results = $fordates; ?>
		@foreach($fordates as $rs)
			<a href="#" class="list-group-item text-bold find-record-by-date" data-date="{{$rs->date}}">
				{{format_date2($rs->date, 'F j, Y')}}
				<i class="fa fa-angle-right pull-right" style="margin-top:4px"></i>
			</a>
		@endforeach

	@elseif( isset($bdates) )

		<?php $results = $bdates; ?>
		@foreach($bdates as $bd)
				<a href='#' class="list-group-item text-bold show-fullscreen alert alert-success" data-branchid="{{$bd->branch_id}}" data-staffid="{{$bd->staff_id}}">
					{{$bd->branch->name}}
					<span class="pull-right" style="margin-top:4px">{{$bd->staff->name}}</span>
				</a>
		@endforeach
		
	@endif

</div>

<div class="pagination-link {{$pagination_position}}">
	{{ $results->links() }}
</div>


<script type="text/javascript">

$(function(){
	$('.show-fullscreen').on('click', function (e){
		e.preventDefault();
		e.stopImmediatePropagation();

		
		var $xq = {};

		$xq.staff_id = $(this).data('staffid');
		$xq.branch_id = $(this).data('branchid');
		$xq.date = $('.table-responsive .table-sidebar-left .pagination-content a.active').data('date');
		var url = '{{URL::route("records.popover")}}' + '?' + $.param($xq);

		//_debug();

		$('#fullscreen').modal({
			remote : url,
			backdrop: 'static'
		});

	});

});

</script>
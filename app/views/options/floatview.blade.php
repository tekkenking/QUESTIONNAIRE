<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">RATING SCALE</h4>
</div>

<div class="modal-body">

	<table class="table table-bordered table-hover datatable_col_reorder">
		<thead>
			<tr>
				<th>Option</th>
				<th>Alias</th>
			</tr>
		</thead>

		<tbody>
			@if( !empty($options) )
				@foreach( $options as $option )
			<tr>
				<td class="text-bold">{{$option->name}}</td>
				<td class="text-bold">{{$option->alias}}</td>
			</tr>
				@endforeach
			@endif
		</tbody>
	</table>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		Cancel
	</button>
</div>

{{Larasset::start('footer')->only('jquery.dataTables', 'dataTables.bootstrap')->show('scripts')}}

<script type="text/javascript">
	$(function(){
		//Data table
		$(".datatable_col_reorder").dataTable();
	});
</script>
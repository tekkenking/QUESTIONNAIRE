<?php
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
	<ul class="pagination pagination-lg">
			<?php echo $presenter->render(); ?>

			<!--<li class="pull-right">
				<select class="select2"> 
					<option> 3 </option>
					<option> 4 </option> 
				</select>
			</li>-->
	</ul>
<?php endif; ?>

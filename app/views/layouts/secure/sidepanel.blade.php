<!-- #NAVIGATION -->
<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as is --> 
			
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src={{{asset_vendors("smart/img/avatars/sunny.png")}}} alt="{{{Auth::user()->username}}}" class="online" /> 

				<span>



					@if( Auth::check() )
						{{{Auth::user()->firstname}}}
					@endif
				</span>
			</a> 
			
		</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive

	To make this navigation dynamic please make sure to link the node
	(the reference to the nav > ul) after page load. Or the navigation
	will not initialize.
	-->
	<nav>
		<!-- 
		NOTE: Notice the gaps after each icon usage <i></i>..
		Please note that these links work a bit different than
		traditional href="" links. See documentation for details.
		-->

		<ul>
			<li class="">
				<a href="ajax/dashboard.html" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
			</li>
			<li>
				<a href="{{{URL::route('branches.index')}}}"><i class="fa fa-lg fa-fw fa-inbox"></i> <span class="menu-item-parent">Manage Branches</span></a>
			</li>			
			<li>
				<a href="{{{URL::route('questionnaires.index')}}}"><i class="fa fa-lg fa-fw fa-inbox"></i> <span class="menu-item-parent">Manage Questions</span></a>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i> <span class="menu-item-parent">Records</span></a>
			</li>
		</ul>
	</nav>
</aside>
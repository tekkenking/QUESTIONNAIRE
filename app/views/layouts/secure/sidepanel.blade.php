<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as is --> 
			
		<!-- PLACE YOUR LOGO HERE -->
		<span id="logo"> <img src={{asset_vendors("bucketcodes/img/fbn_qns.png")}} alt="SmartAdmin"> </span>
		<!-- END LOGO PLACEHOLDER -->
			
		</span>
	</div>

	<nav>

		<ul class="firstbanknav">
			<li>
				<a href="{{{URL::route('home')}}}"><i class="fa fa-lg fa-fw fa-database"></i> <span class="menu-item-parent">Records | Issues <span class="txt-color-white label label-danger sidebar-issue-counter">{{$issueCounterComposer}}</span></span></a>
			</li>
			<li>
				<a href="{{{URL::route('branches.index')}}}"><i class="fa fa-lg fa-fw fa-code-fork"></i> <span class="menu-item-parent">Manage Branches</span></a>
			</li>			
			<li>
				<a href="{{{URL::route('questionnaires.index')}}}"><i class="fa fa-lg fa-fw fa-question-circle"></i> <span class="menu-item-parent">Manage Questions</span></a>
			</li>			
			<li>
				<a href="{{{URL::route('staffs.index')}}}"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">Manage Staff</span></a>
			</li>			
			<li>
				<a href="{{{URL::route('backuprestoredbs.index')}}}">
				<i class="fa fa-lg fa-fw fa-refresh"></i>
 <span class="menu-item-parent">Backup | </i>Restore DB</span></a>
			</li>
			<li>
				<a href="{{{route('session.logout')}}}" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out fa-lg fa-fw"></i> <span class="menu-item-parent">Log out</span></a>
			</li>
		</ul>
	</nav>
</aside>
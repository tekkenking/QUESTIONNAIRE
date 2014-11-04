		<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 hidden-xs hidden-sm">
						<h1 class="txt-color-red login-header-big">SmartAdmin</h1>
						<div class="hero">

							<div class="pull-left login-desc-box-l">
								<h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SmartAdmin, everywhere you go!</h4>
								<div class="login-app-icons">
									<a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
									<a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
								</div>
							</div>
							
							<img src="img/demo/iphoneview.png" alt="" class="pull-right display-image" style="width:210px">
							
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h5 class="about-heading">About SmartAdmin - Are you up to date?</h5>
								<p>
									Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.
								</p>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h5 class="about-heading">Not just your average template!</h5>
								<p>
									Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
								</p>
							</div>
						</div>

					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<div class="well no-padding">
							{{Form::open( array( 'route'=>'session.auth.create', 'id'=>'smart-form-register', 'class'=>'smart-form client-form'))}}
								<header>
									Create Admin User
								</header>

								<fieldset>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif

									<section>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="text" name="username" placeholder="Username">
											<b class="tooltip tooltip-bottom-right">Needed to access admin area</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
											<input type="email" name="email" placeholder="Email address">
											<b class="tooltip tooltip-bottom-right">Needed to verify your account</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password" placeholder="Password" id="password">
											<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password_confirmation" placeholder="Confirm password">
											<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
									</section>
								</fieldset>

								<fieldset>
									<div class="row">
										<section class="col col-6">
											<label class="input">
												<input type="text" name="firstname" placeholder="First name">
											</label>
										</section>
										<section class="col col-6">
											<label class="input">
												<input type="text" name="lastname" placeholder="Last name">
											</label>
										</section>
									</div>

								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary">
										Register
									</button>
								</footer>

								<div class="message">
									<i class="fa fa-check"></i>
									<p>
										Thank you for your registration!
									</p>
								</div>
							{{Form::close()}}

						</div>
						<p class="note text-center">*FREE Registration ends on October 2015.</p>
						<h5 class="text-center">- Or sign in using -</h5>
						<ul class="list-inline text-center">
							<li>
								<a href="javascript:void(0);" class="btn btn-primary btn-circle"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn btn-info btn-circle"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>

		</div>

{{setinlinescript('
		<script type="text/javascript">
			//runAllForms();
			
			// Model i agree button
			$("#i-agree").click(function(){
				$this=$("#terms");
				if($this.checked) {
					$("#myModal").modal("toggle");
				} else {
					$this.prop("checked", true);
					$("#myModal").modal("toggle");
				}
			});
			
			// Validation
			$(function() {
				// Validation
				$("#smart-form-register").validate({

					// Rules for form validation
					rules : {
						username : {
							required : true
						},
						email : {
							required : true,
							email : true
						},
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						},
						passwordConfirm : {
							required : true,
							minlength : 3,
							maxlength : 20,
							equalTo : "#password"
						},
						firstname : {
							required : true
						},
						lastname : {
							required : true
						}
					},

					// Messages for form validation
					messages : {
						username : {
							required : "Please enter your login"
						},
						email : {
							required : "Please enter your email address",
							email : "Please enter a VALID email address"
						},
						password : {
							required : "Please enter your password"
						},
						passwordConfirm : {
							required : "Please enter your password one more time",
							equalTo : "Please enter the same password as above"
						},
						firstname : {
							required : "Please select your first name"
						},
						lastname : {
							required : "Please select your last name"
						}
					},

					// Ajax form submition
					submitHandler : function(form) {
						$(form).ajaxSubmit({
							success : function() {
								$("#smart-form-register").addClass("submited");
							}
						});
					},

					// Do not change code below
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});

			});
		</script>

')}}

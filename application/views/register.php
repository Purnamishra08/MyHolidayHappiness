<!doctype html>
<html>

<head>
	<?php include("head.php"); ?>
	<meta name="robots" content="noindex" />
</head>

<body>
	<?php include("header.php"); ?>

	<section>
		<img src="<?php echo base_url(); ?>assets/images/loginbanner.jpg" class="img-fluid">
	</section>
	<div class="container  mt60 mb100">
		<div class="row">
			<div class="col-xl-3 col-lg-1 col-md-1"></div>
			<div class="col-xl-6 col-lg-10 col-md-10 formboxholder ">

				<h3 class="mb-4 text-center">Sign up with My Holiday Happiness</h3>
				<?php echo form_open(base_url( 'register' ), array( 'id' => 'form_signup', 'name' => 'form_signup', 'class' => 'signform row' ));?>
				<?php echo $message; ?>
				<div class="col-lg-6 col-md-12">
					<div class="form-group">
						<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name *" value="<?php echo set_value('fullname'); ?>"  maxlength="50">
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="form-group">
						<input type="email" class="form-control" name="emailida" id="emailida" placeholder="Email Id *" value="<?php echo set_value('emailida'); ?>" maxlength="80">
					</div>
				</div>
				<div class="col-md-12 ">
					<div class="form-group">
						<input type="text" class="form-control" name="contact" id="contact" placeholder="Mobile No *" value="<?php echo set_value('contact'); ?>" maxlength="10">
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="form-group">
						<input type="password" class="form-control" name="passworda" id="passworda"
							placeholder="Password *" minlength="6" maxlength="15">
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="form-group">
						<input type="password" class="form-control" name="cpassworda" id="cpassworda"
							placeholder="Confirm password *" maxlength="20">
					</div>
				</div>

				<div class="col-lg-12 col-md-12">
					<div class="form-group">
						<div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>">
						</div>
					</div>
				</div>
				<div class="clearfix"></div>

				<div class="col-md-12"><button type="submit" name="btn_custsignup" id="btn_custsignup"
						class="btn requestquotebtn">Create Account</button></div>
				<div class="col-md-12 loginheretxt mt-3 mb-3">
					<p>Already Created Account? <a href="<?php echo base_url(); ?>login">Login Here</a></p>
				</div>

				<?php echo form_close();?>
			</div>
			<div class="col-xl-3 col-lg-1 col-md-1"></div>
			<div class="claerfix"></div>
		</div>
	</div>

	<?php include("footer.php"); ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script>
		jQuery(document).ready(function () {

			function ensureRecaptchaLoaded(callback) {
				if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.render === 'function') {
					callback();
				} else {
					setTimeout(function() { ensureRecaptchaLoaded(callback); }, 100);
				}
			}

			$('.selectpicker').selectpicker();

			jQuery.validator.addMethod("regex", function (value, element, regexp) {
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			}, "Remove Special Chars");

			$.validator.addMethod("recaptcha", function(value, element, param) {
				if (grecaptcha.getResponse().length === 0) {
					return false;
				} else {
					return true;
				}
			}, "Please complete the reCAPTCHA");

			jQuery("#form_signup").validate({
				rules: {
					fullname: {
						required: true
					},
					contact: {
						required: true,
						regex: "^[0-9 \+-]+$",
						minlength: 10
					},
					emailida: {
						required: true,
						email: true,
						remote: {
							url: base_url + 'register/check_email',
							type: "post",
							data: {
								chkemail: function () {
									return $("#emailida").val();
								},
								'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
							}
						}
					},
					passworda: {
						required: true,
						rangelength: [6, 15]
					},
					cpassworda: {
						required: true,
						equalTo: "#passworda"
					},
					recaptcha: {
						recaptcha: true
					}
				},
				messages: {
					fullname: {
						required: "Enter full name."
					},
					contact: {
						required: "Enter phone no.",
						regex: "Numbers only"
					},
					emailida: {
						required: "Enter email id.",
						email: "Enter valid email",
						remote: "Email already exist."
					},
					passworda: {
						required: "Enter password.",
						rangelength: "Password Must Contain 6 To 15 Characters"
					},
					cpassworda: {
						required: "Enter confirm password.",
						equalTo: "Enter same password again."
					},

					/*captcha: {
					   required: "Select captcha.",
					} */
				}
			});
		});
	</script>

</body>

</html>
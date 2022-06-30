<?php
/*
Template Name: Contact us
*/
?>

<?php get_header(); ?>
	<div id="container " class='contact-us'>


	<div class="content ">
		<div class="container">
			<div class="row align-items-stretch justify-content-center no-gutters">
				<div class="col-md-7">
					<div class="form h-100 contact-wrap p-5">
						<h3 class="text-center">Kapcsolati űrlap</h3>
						<form class="mb-5" method="post" id="contactForm" name="contactForm">
							<div class="row">
								<div class="col-md-6 form-group mb-3">
									<label for="" class="col-form-label">Név *</label>
									<input type="text" class="form-control" name="name" id="name" placeholder="Add meg a neved">
								</div>
								<div class="col-md-6 form-group mb-3">
									<label for="" class="col-form-label">E-mail *</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Add meg az email-címed">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 form-group mb-3">
									<label for="budget" class="col-form-label">Tárgy</label>
									<input type="text" class="form-control" name="subject" id="subject" placeholder="Az üzenet tárgya">
								</div>
							</div>
							<div class="row mb-5">
								<div class="col-md-12 form-group mb-3">
									<label for="message" class="col-form-label">Üzenet *</label>
									<textarea class="form-control" name="message" id="message" cols="30" rows="4" placeholder="Az üzenet szövege"></textarea>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-md-5 form-group text-center">
									<input type="submit" value="Küldés" class="btn btn-block btn-primary rounded-0 py-2 px-4">
									<input type='hidden' name='action' value='liner_contact_us' />
								<span class="submitting"></span>
								</div>
							</div>
						</form>
						<div id="form-message-warning mt-4"></div>
						<div id="form-message-success">
							Üzenet elküldve, köszönjük!
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>

<script>
jQuery(function($) {

	'use strict';

	// Form

	var contactForm = function() {
 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		if ($('#contactForm').length > 0 ) {
			$( "#contactForm" ).validate( {
				rules: {
					name: "required",
					email: {
						required: true,
						email: true
					},
					message: {
						required: true,
						minlength: 5
					}
				},
				messages: {
					name: "Please enter your name",
					email: "Please enter a valid email address",
					message: "Please enter a message"
				},
				/* submit via ajax */
				submitHandler: function(form) {
					var $submit = $('.submitting'),
						waitText = 'Küldés folyamatban...';

					$.ajax({
				      type: "POST",
				      //url: "php/send-email.php",
				      url: ajaxurl,
				      data: $(form).serialize(),

				      beforeSend: function() {
				      	$submit.css('display', 'block').text(waitText);
				      },
				      success: function(msg) {
		               if (msg == 'OK') {
		               	$('#form-message-warning').hide();
				            setTimeout(function(){
		               		$('#contactForm').fadeOut();
		               	}, 1000);
				            setTimeout(function(){
				               $('#form-message-success').fadeIn();
		               	}, 1400);

			            } else {
			               $('#form-message-warning').html(msg);
				            $('#form-message-warning').fadeIn();
				            $submit.css('display', 'none');
			            }
				      },
				      error: function() {
				      	$('#form-message-warning').html("Something went wrong. Please try again.");
				         $('#form-message-warning').fadeIn();
				         $submit.css('display', 'none');
				      }
			      });
		  		}

			} );
		}
	};
	contactForm();

});
</script>


	</div><!-- #container -->

<?php get_footer(); ?>

{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<p><a href="{{ path_for('getHome') }}">Back to Homepage</a></p>

				<h2>Register Page</h2>

				<hr>

				{% include 'components/messages/messages.php' %}

				<form id="register-form" action="{{ path_for('postRegister') }}" method="post" autocomplete="{{ config.app.autocomplete }}">
					<div class="form-row">
						<div class="col-lg-6 mb-3">
							<label>First Name <span class="red">*</span></label>
							<input type="text" class="form-control" name="first_name">
							<label for="first_name" class="invalid-feedback error"></label>
						</div>

						<div class="col-lg-6 mb-3">
							<label>Last Name <span class="red">*</span></label>
							<input type="text" class="form-control" name="last_name">
							<label for="last_name" class="invalid-feedback error"></label>
						</div>

						<div class="col-lg-6 mb-3">
							<label>Email Address <span class="red">*</span></label>
							<input type="text" class="form-control" name="email_address">
							<label for="email_address" class="invalid-feedback error"></label>
						</div>

						<div class="col-lg-6 mb-3">
							<label>Mobile Number <small><i>(SMS Verification)</i></small> <span class="red">*</span></label>
							<input type="text" class="form-control" name="phone_number" id="phone_number">
							<label for="phone_number" class="invalid-feedback error"></label>

							<input type="hidden" name="phone_number_valid" id="phone_number_valid" value="">
							<span id="valid-msg" class="valid-number pull-right softhide text-success"></span>
							<span id="error-msg" class="invalid-number pull-right softhide text-danger"></span>
						</div>
						
						<div class="col-lg-6 mb-3">
							<label>Password <span class="red">*</span></label>
							<input type="password" class="form-control" name="password" id="password">
							<label for="password" class="invalid-feedback error"></label>
						</div>

						<div class="col-lg-6 mb-3">
							<label>Verify Password <span class="red">*</span></label>
							<input type="password" class="form-control" name="verify_password">
							<label for="verify_password" class="invalid-feedback error"></label>
						</div>

						<div class="g-recaptcha" data-sitekey="{{ config.recaptcha.invisible.siteKey }}" data-callback="onSubmit" data-size="invisible" data-badge="{{ config.recaptcha.invisible.badge }}"></div>
						
						<div class="col-lg-12">
							<button type="submit" id="register" class="btn btn-primary btn-block">REGISTER</button>
							<button type="button" id="register-hide" class="btn btn-primary btn-block softhide" disabled><i class="fa fa-refresh fa-pulse"></i> Processing...</button>
						</div>
					</div>

					{{ csrf.field | raw }}
				</form>
			</div>
		</div>
	</div>
	
{% endblock %}
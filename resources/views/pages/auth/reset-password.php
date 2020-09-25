{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<p><a href="{{ path_for('index') }}">Back to Homepage</a></p>

				<h2>Reset Password Page</h2>

				<hr>

				{% include 'includes/messages/messages.php' %}

				<form id="reset-form" action="{{ path_for('postResetPassword', {email_address: user.email_address}) }}" method="post" autocomplete="{{ config.app.autocomplete }}">
					<div class="form-row">
						<div class="col-lg-12 mb-3">
							<label>New Password <span class="red">*</span></label>
							<input type="password" class="form-control" name="password">
							<label for="password" class="invalid-feedback error"></label>
						</div>

						<div class="g-recaptcha" data-sitekey="{{ config.recaptcha.invisible.siteKey }}" data-callback="onSubmit" data-size="invisible" data-badge="{{ config.recaptcha.invisible.badge }}"></div>

						<div class="col-lg-12">
							<button type="submit" id="reset" class="btn btn-primary btn-block">RESET PASSWORD</button>
							<button type="button" id="reset-hide" class="btn btn-primary btn-block softhide" disabled><i class="fa fa-refresh fa-pulse"></i> Processing...</button>
						</div>
					</div>
					{{ csrf.field | raw }}
				</form>
			</div>
		</div>
	</div>
	
{% endblock %}
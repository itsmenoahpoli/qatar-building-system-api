<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Application Record Payment - Stripe Payment</title>

		<!-- Bootstrap -->
		<link
			rel="stylesheet"
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
			integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
			crossorigin="anonymous"
		/>
		<script
			src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
			integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
			crossorigin="anonymous"
		></script>
		<script
			src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
			integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
			crossorigin="anonymous"
		></script>
		<script
			src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
			integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
			crossorigin="anonymous"
		></script>

		<!-- Google Fonts -->
		<link rel="preconnect" href="https://fonts.gstatic.com" />
		<link
			href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap"
			rel="stylesheet"
		/>

		<style>
			* {
				font-family: Poppins !important;
			}

			html {
				overflow-x: hidden;
			}

			body {
				background: #f1f1f1;
			}

			.text-bold {
				font-weight: 700 !important;
			}

			h1,
			h2,
			h3,
			h4,
			h5,
			h6 {
				color: #666;
			}

			p {
				color: #777 !important;
				font-size: 0.85rem !important;
			}

			.card {
				border: solid 1px #eee !important;
				box-shadow: 0px 0px 17 23px black !important;
				padding-top: 0.65rem;
				padding-bottom: 0.65rem;
			}
		</style>
	</head>
	<body>
		<div class="row">
			<div class="col-md-4 mx-auto">
				<div class="col-lg-5 mx-auto my-5">
					<img
						src="{{ asset('images/icons/brand-icon.ico') }}"
						alt="KIC brand"
						class="img-fluid"
					/>
				</div>

				@if($payment_data_found)
				<div class="card">
					<div class="card-body">
						@if($payment_data_paid)
						<div class="col-lg-3 px-3 mx-auto mb-3">
							<img
								src="{{ asset('images/icons/info.png') }}"
								alt="KIC brand"
								class="img-fluid"
							/>
						</div>

						<div>
							<h5 class="text-muted text-center mb-4">
								Payment Information Summary
							</h5>

							<hr />

							<div class="d-flex justify-content-between pt-3">
								<div>
									<p className="text-muted">
										Application Record #
									</p>

									<p className="text-muted">Payment for</p>
								</div>

								<div>
									<p>
										{{ $application_record_data->uuid }}
									</p>

									<p>
										{{ $payment_for }}
									</p>
								</div>
							</div>
						</div>
						@else

						<form
							action="{{ route('payments.stripe.create', ['application_payment_record_uuid' => $application_payment_uuid] ) }}"
							method="POST"
						>
							<div>
								<small
									>Application Payment UUID:
									{{ $application_payment_uuid }}
								</small>
							</div>
							<script
								src="https://checkout.stripe.com/checkout.js"
								class="stripe-button"
								data-key="pk_test_51IbgXqHy36r0CCKEReFYBLrWhWpcD9Tb25KMZqK6UwbiD5Mty3yTWEf1avmEuPMd96ZHws0CXytrrkrm5Wm9rKuh00rbchm1Xw"
								data-amount="15000"
								data-name="Patrick Policarpio"
								data-description="Application Payment"
								data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
								data-locale="en"
								data-currency="QAR"
							></script>
						</form>
						@endif
					</div>
				</div>
				@else
				<div class="card">
					<div class="card-body">
						<h5 class="text-danger">
							Payment Data Summary Not Found
						</h5>
					</div>
				</div>
				@endif
			</div>
		</div>
	</body>
</html>

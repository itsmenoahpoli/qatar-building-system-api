<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Application Record Payment - Stripe Payment</title>

		<!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    
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

      .badge {
        font-size: 0.65rem !important;
      }

      .badge-danger {
        font-weight: normal !important;
        color: #f46a6a !important;
        background-color: rgba(244, 106, 106, 0.18) !important;
        padding: 0.4rem 0.6rem !important;
        border-radius: 10rem !important;
      }

      .badge-warning {
        font-weight: normal !important;
        color: #f1b44c !important;
        background-color: rgba(241, 180, 76, 0.18) !important;
        padding: 0.4rem 0.6rem !important;
        border-radius: 10rem !important;
      }

      .badge-success {
        font-weight: normal !important;
        color: #34c38f !important;
        background-color: rgba(52, 195, 143, 0.18) !important;
        padding: 0.4rem 0.6rem !important;
        border-radius: 10rem !important;
      }

      .badge-primary {
        font-weight: normal !important;
        color: #0c56b0 !important;
        background-color: rgba(45, 116, 204, 0.18) !important;
        padding: 0.4rem 0.6rem !important;
        border-radius: 10rem !important;
      }

      .badge-info {
        font-weight: normal !important;
        color: #109e93 !important;
        background-color: rgba(90, 219, 209, 0.18) !important;
        padding: 0.4rem 0.6rem !important;
        border-radius: 10rem !important;
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

      .card-body {
        padding: 3rem 2rem !important;
      }

      div.bold-texts p {
        color: #555 !important;
        font-weight: 700 !important;
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
								<div class="bold-texts">
									<p className="text-muted">
										Application Record #
									</p>

									<p className="text-muted">Payment amount</p>

									<p className="text-muted">Payment for</p>

									<p className="text-muted">Payment status</p>

									<p className="text-muted">Payment at</p>

                  <p className="text-muted">Payment receipt</p>
								</div>

								<div>
									<p>
										{{ $application_record_data->uuid }}
									</p>

                  
									<p>
										QAR {{ substr_replace($payment_data_amount, '.00', strlen($payment_data_amount) - 1) }}
									</p>

									<p>
										{{ $payment_for }}
									</p>

                  <p>
										<div class="badge badge-success">Paid</div>
									</p>

                  <p>
										{{ \Carbon\Carbon::parse($application_record_data->created_at)->format('F d, Y h:m A') }}
									</p>

                  <p>
										<u><a href="{{ $payment_data_receipt_url }}" target="_blank -098765">Click to view</a></u>
									</p>
								</div>
							</div>
						</div>
						@else

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
								<div class="bold-texts">
									<p className="text-muted">
										Application Record #
									</p>

									<p className="text-muted">Payment amount</p>

									<p className="text-muted">Payment for</p>

									<p className="text-muted">Payment status</p>
								</div>

								<div>
									<p>
										{{ $application_record_data->uuid }}
									</p>

                  
									<p>
										QAR {{ substr_replace($payment_data_amount, '.00', strlen($payment_data_amount) - 1) }}
									</p>

									<p>
										{{ $payment_for }}
									</p>

                  <p>
										<div class="badge badge-success">To Pay</div>
									</p>
								</div>
							</div>
						</div>

						<div class="text-center mt-3">
              <form
                action="{{ route('payments.stripe.create', ['application_payment_record_uuid' => $application_payment_uuid] ) }}"
                method="POST"
              >
                <script
                  src="https://checkout.stripe.com/checkout.js"
                  class="stripe-button"
                  data-key="pk_test_51IkR3KJ5NKPKu9n1Y5sWKxPNDcSc5UenSTU7ETvTYlKsIGg8uYbvaLp1mrbE4H15c2MMOzJiAQ9duLAUoNIpo8dY00qng7ZkvJ"
                  data-amount="{{ $payment_data_amount.'0' }}"
                  data-name="Patrick Policarpio"
                  data-description="Application Payment"
                  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                  data-locale="en"
                  data-currency="QAR"
                ></script>
              </form>
            </div>
						@endif
					</div>
				</div>
				@else
				<div class="card">
					<div class="card-body">
						<div class="col-lg-3 px-3 mx-auto mb-5">
							<img
								src="{{ asset('images/icons/close.png') }}"
								alt="KIC brand"
								class="img-fluid"
							/>
						</div>

            <div>
              <h5 class="text-muted text-center mb-4">
								Payment Information Not Found
							</h5>
            </div>
				</div>
				@endif
			</div>
		</div>
	</body>
</html>

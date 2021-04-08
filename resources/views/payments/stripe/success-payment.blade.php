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

				<div class="card">
					<div class="card-body">
						<div class="col-lg-3 px-3 mx-auto mb-5">
							<img
								src="{{ asset('images/icons/check.png') }}"
								alt="KIC brand"
								class="img-fluid"
							/>
						</div>

            <div>
              <h5 class="text-muted text-center mb-4">
                Payment Successful
							</h5>
            </div>
				</div>
			</div>
		</div>
	</body>
</html>

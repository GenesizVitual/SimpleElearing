<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mts Ummusshabri Guru</title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel='icon' href='{{ asset('PESRI.png') }}'>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('asset_LogReg/css/main.css') }}">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form action="{{ url('login-guru') }}" method="post" class="login100-form validate-form">
					{{ csrf_field() }}
					<span class="login100-form-title p-b-43">
						Silahkan masuk guru.
					</span>
					@if(!empty(Session::get('message_error')))
						<span style="color: red">
							{{ Session::get('message_error') }}
						</span>
					@endif
					<div class="wrap-input100 validate-input" data-validate = "Valid Kode is required: 123123">
						<input class="input100" type="text" name="kode">
						<span class="focus-input100"></span>
						<span class="label-input100">Kode Guru</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pass">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">

						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					
					{{--<div class="text-center p-t-46 p-b-20">--}}
						{{--<span class="txt2">--}}
							{{--or <a href="{{ url('register') }}">sign up</a>--}}
						{{--</span>--}}
					{{--</div>--}}

				</form>

				<div class="login100-more" style="background-image: url('{{ asset('asset_LogReg/images/bg-01.jpg') }}');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="{{ asset('asset_LogReg/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('asset_LogReg/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('asset_LogReg/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('asset_LogReg/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('asset_LogReg/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('asset_LogReg/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('asset_LogReg/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('asset_LogReg/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('asset_LogReg/js/main.js') }}"></script>

</body>
</html>
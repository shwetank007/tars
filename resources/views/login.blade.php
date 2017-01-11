<!DOCTYPE html>
<html>
<head>
	<title>TARS</title>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
	@import url(http://fonts.googleapis.com/css?family=Roboto:400);
	body {
		background-color:#d3d3d3;
		-webkit-font-smoothing: antialiased;
		font: normal 14px Roboto,arial,sans-serif;
	}

	.container {
		padding: 25px;
		position: fixed;
	}

	.form-login {
		background-color: #EDEDED;
		padding-top: 10px;
		padding-bottom: 20px;
		padding-left: 20px;
		padding-right: 20px;
		border-radius: 15px;
		border-color:#d2d2d2;
		border-width: 5px;
		box-shadow:0 1px 0 #cfcfcf;
		margin-top: 150px;
	}

	h4 {
		border:0 solid #fff;
		border-bottom-width:1px;
		padding-bottom:10px;
		text-align: center;
	}

	.form-control {
		border-radius: 10px;
	}

	.wrapper {
		text-align: center;
	}

</style>
</head>
<body>
	<div class="container">
	<div class="row">
		<div class="col-md-offset-5 col-md-3">
			<div class="form-login">
				<h4>T.A.R.S.</h4>
				<form method="post" class="login-form" action="">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input name="email" type="email" id="userName" class="form-control input-sm chat-input" placeholder="E-mail Address" />
					</br>
					<input name="password" type="password" id="userPassword" class="form-control input-sm chat-input" placeholder="password" />
					</br>
					<div class="wrapper">
						<span class="group-btn">
							<button type="button" class="btn btn-primary btn-md" onclick="login()">login <i class="fa fa-sign-in"></i></button>
						</span>
					</div>
				</form>
			</div>

		</div>
	</div>
	</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
	function login() {
		$.ajax({
			type:'POST',
			url:'{!! route('login') !!}',
			data: $(".login-form").serialize(),
			success: function (response) {
				window.location.href = "{{route('dashboard')}}"
			}
		})
	}
</script>
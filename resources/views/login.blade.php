<!DOCTYPE html>
<html>
<head>
	<title>TARS</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<form method="post" class="login-form" action="">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input placeholder="E-mail Address" name="email" type="email"><br>
				<input placeholder="Password" name="password" type="password"><br>
				<button type="button" onclick="login()">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
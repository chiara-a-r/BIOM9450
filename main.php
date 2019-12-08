<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>main page</title>
	<link href="style_sheet.css" rel="stylesheet" type="text/css">

	<script type="text/javascript">
		good_email = false;
		good_fname = false;
		good_lname = false;
		good_pwd = false;
		good_pwd2 = false;
		good_dob = false;

		function checkForm(){
			if (good_email & good_fname & good_lname & good_pwd & good_pwd2 & good_dob){
				return true;
			} else {
				alert("Check the errors!");
			}
		}

		function checkEmail(emailID, errID){
			//check email against regex
			var email = document.getElementById(emailID).value;
			var pattern = /^[a-z._]+@[a-z]+.[a-z]{2,4}$/i;
			if(pattern.test(email)){
				//if email matches regex
				document.getElementById(errID).innerHTML = 'No errors';
                document.getElementById(errID).style.color = '#ccffcc';
                good_email = true;
			} else {
				document.getElementById(errID).innerHTML = 'invalid email format';
				document.getElementById(errID).style.color = '#ff0066';
				good_email = false;
			}
		}

		function checkName(){
			good_lname = true;
			good_fname = true;

		}

		function checkPassword(){
			good_pwd = true;
		}

		function checkSame() {
			good_pwd2 = true;
		}

		function checkDOB(){
			good_dob = true;
		}
	</script>

</head>

<body>

	<!-- workshop name with image/logo at top -->
	<h1>Workshop Name&nbsp;<img src="http://pluspng.com/img-png/puppy-png-dalmatian-puppy-1740.png" height="60"></h1>

	<!-- venue information -->
	<p>
		Venue Information
		<a href="mailto:chichibabe98@gmail.com">Send email</a>
	</p>


	<!-- link to page including a table of workshop schedule -->
	<a href="table.html">Link to other page with table</a>

	<!-- registration form, remember error messages & alert pop-up --><br><br>
	<form onSubmit="return checkForm()" method="post" action="success.php">
		<table align="center">
			<!-- email -->
			<tr>
				<td>Email:</td><td><input type="text" name="email" id="email" onchange="checkEmail('email', 'email_err')"></td><td id="email_err" style="color:black"></td>
			</tr>
			<!-- password -->
			<tr>
				<td>Password:</td><td><input type="password" name="password" id="password" onchange="checkPassword()"></td><td id="pwd_err"></td>
			</tr>
			<!-- re-enter password -->
			<tr>
				<td>Re-enter password:</td><td><input type="password" id="password2" onchange="checkSame()"></td><td id="pwd2_err"></td>
			</tr>
			<!-- first name -->
			<tr>
				<td>First Name:</td><td><input type="text" id="fname" name="fname" onchange="checkName()"></td><td id="fname_err"></td>
			</tr>
			<!-- last name -->
			<tr>
				<td>Last Name:</td><td><input type="text" id="lname" name="lname" onchange="checkName()"></td><td id="lname_err"></td>
			</tr>
			<!-- DOB -->
			<tr>
				<td>DOB:</td><td><input type="text" id="dob" name="dob" maxlength="10" onchange="checkDOB()"></td><td id="dob_err"></td>
			</tr>
			<!-- gender drop-down menu -->
			<tr>
				<td>Gender:</td>
				<td>
					<select>
						<option value="Female">Female</option>
						<option value="Male">Male</option>
					</select>
				</td>
			</tr>
			<!-- receive marketing checkbox -->
			<tr>
				<td>Receive marketing material?</td><td><input type="checkbox" name="material" value="yes"></td>
			</tr>
			<!-- submit button -->
			<tr>
				<td></td><td><input type="submit" value="Register"></td>
			</tr>
		</table>
	</form>

</body>

</html>
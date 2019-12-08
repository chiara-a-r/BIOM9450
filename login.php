<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>login_page</title>
    <link href="style_sheet.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
    	
    </script>

</head>

<body>
	<h1 style="color: #FFFFFF">
		Login Page
	</h1>
    <form id="loginInfo" method="post" action="main.php">
    	<table style="color:#FFFFFF">
    		<tr>
    			<td>Username&nbsp;</td>
                <td><input type="text" id="username" name="username" placeholder="Enter Username"></td>
    		</tr>
            <tr>
                <td>Password&nbsp;</td>
                <td><input type="password" id="password" name="password" placeholder="Enter Password"></td>
            </tr>
    	</table>
        <input type="submit" id="submit" class=button value="Log In">
	</form>
</body>

</html>
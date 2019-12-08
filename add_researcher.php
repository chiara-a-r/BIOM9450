<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>add_researcher</title>
    <link href="style_sheet.css" rel="stylesheet" type="text/css">

    <?php
        //if not coming from main page
        if (!(isset($_POST['username']) and isset($_POST['password']))) {
            //take back to login page
            header("Location: ./login.php");
            exit();
        }
    ?>

    <script type="text/javascript">
        goodtogo1 = false;
        goodtogo2 = false;
        goodtogo3 = false;

        function validName(nameID, errID) {
            var str = document.getElementById(nameID).value;
            var regex = /^[a-zA-Z '-]+$/;
            //checks the string matches the regex
            if (str.match(regex)) {
                document.getElementById(errID).innerHTML = 'No errors'
                document.getElementById(errID).style.color = 'green'
                goodtogo1 = true;
                
            }else{
                document.getElementById(errID).innerHTML = 'Name should contain only letters, spaces, apostrophes and hyphens'
                document.getElementById(errID).style.color = 'red'
                goodtogo1 = false;
            }
        }

        //checks username
        function validUsername(nameID, errID){
            var str = document.getElementById(nameID).value;
            var regex = /^[a-zA-Z '-0-9]+$/;
            //checks the string matches the regex
            if (str.match(regex)) {
                document.getElementById(errID).innerHTML = 'No errors'
                document.getElementById(errID).style.color = 'green'
                goodtogo4 = true;
                
            }else{
                document.getElementById(errID).innerHTML = 'Username should contain only letters, spaces, apostrophes, numbers and hyphens'
                document.getElementById(errID).style.color = 'red'
                goodtogo4 = false;
            }
        }

        //checks password is valid
        function validPassword(pID, errID) {
            var str = document.getElementById(pID).value;
            var regex1 = /[0-9]+/
            var regex2 = /[A-Z]+/
            var regex3 = /[a-z]+/
            if (regex1.test(str) & regex2.test(str) & regex3.test(str) & str.length >= 8) {
                document.getElementById(errID).innerHTML = 'No errors'
                document.getElementById(errID).style.color = 'green'
                goodtogo2 = true;
            }else{
                document.getElementById(errID).innerHTML = 'Password must contain at least 8 characters and include uppercase, lowercase and numbers'
                document.getElementById(errID).style.color = 'red'
                goodtogo2 = false;
            }
        }

        //checks the password was re-entered correctly
        function checkSame(ID1, ID2, errID) {
            var str1 = document.getElementById(ID1).value;
            var str2 = document.getElementById(ID2).value;

            if (str1 == str2) {
                document.getElementById(errID).innerHTML = 'No errors'
                document.getElementById(errID).style.color = 'green'
                goodtogo3 = true;
            }else{
                document.getElementById(errID).innerHTML = 'Passwords must match'
                document.getElementById(errID).style.color = 'red'
                goodtogo3 = false
            }
        }

    	function allOK(){
            //check everything is good
            if (goodtogo1 & goodtogo2 & goodtogo3) {
                return true;
            } else {
                alert("Correct errors and fill in all fields in form before submitting!");
                return false;
            }
        }
    </script>

</head>

<body>
	<?php
		//back to main page button
        echo "<form id=\"main\" method=post action=\"main.php\">";
        //obtain info
        $username = $_POST["username"];
        $password = $_POST["password"];

        //insert fields
        echo "<input type=\"hidden\" id=\"username\" name=\"username\" value=\"" . $username . "\">";
        echo "<input type=\"hidden\" id=\"password\" name=\"password\" value=\"" . $password . "\">";
        echo "<input type=\"submit\" class=button2 name=\"main\" id=\"main\" value=\"Back to Main\"></form>";
	?>
	
	<h1 style="color: #FFFFFF">
		Add Researcher
	</h1>

    <form id="addResearcher" method="post" onSubmit="return allOK()" action="success.php">
        <table style="color:#FFFFFF">
            <tr>
                <!-- Full Name -->
                <td>Full Name&nbsp;</td>
                <td><input type="text" id="name" name="name" onchange="validName('name','errorMsg1')" placeholder="Enter Full Name"></td>
                <td id="errorMsg1" style="color:green"></td>
            </tr>
            <tr>
                <!-- Username -->
                <td>Username&nbsp;</td>
                <td><input type="text" id="temp_username" name="temp_username" onchange="validUsername('temp_username','errorMsg2')" placeholder="Enter Username"></td>
                <td id="errorMsg2" style="color:green"></td>
            </tr>
            <tr>
                <!-- Password -->
                <td>Password&nbsp;</td>
                <td><input type="password" id="password" name="password" onchange="validPassword('password','errorMsg3')" placeholder="Enter Password"></td>
                <td id="errorMsg3" style="color:green"></td>
            </tr>
            <tr>
                <!-- Re-enter Password -->
                <td>Re-enter Password&nbsp;</td>
                <td><input type="password" id="password_reenter" name="password_reenter" onchange="checkSame('password_reenter','password','errorMsg4')" placeholder="Re-enter Password"></td>
                <td id="errorMsg4" style="color:green"></td>
            </tr>
        </table>
        <input type="submit" name="submitbutton" class=button4 id="submitbutton" value="Add">
        <?php  
            //hidden input for username and password
            echo "<input type=\"hidden\" id='username' name='username' value='" . $_POST['username'] . "'>";
            echo "<input type=\"hidden\" id='password' name='password' value='" . $_POST['password'] . "'>";
            echo "<input type=\"hidden\" id='page_type' name='page_type' value='add_researcher'>";
        ?>
    </form>
    
</body>

</html>
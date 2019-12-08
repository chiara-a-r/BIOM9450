<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>add_subject</title>
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
                if (nameID == 'fname') {
                    goodtogo1 = true;
                }else{
                    goodtogo2 = true;
                }
                
            }else{
                document.getElementById(errID).innerHTML = 'Name should contain only letters, spaces, apostrophes and hyphens'
                document.getElementById(errID).style.color = 'red'
                if (nameID == fname) {
                    goodtogo1 = false;
                }else{
                    goodtogo2 = false;
                }
            }
        }

        //checks the DOB is in correct format
        function validDOB(DOBID, errID) {
            var str = document.getElementById(DOBID).value;
            var regex = /^([0123][0-9])\/([01][0-9])\/([12][09][0-9]{2})$/;
            var tag = str.match(regex);

            if (str.match(regex)) {
            //months before August
                if (tag[2] < 8) {
                    //if its an odd month
                    if ((tag[2] % 2) == 1) {
                        //if outside date or month range, it won't work
                        if (tag[1] > 31 || tag[1] < 1 || tag[2] < 1) {
                            goodtogo3 = false;
                        //if outside possible year range, won't work
                        }else if (tag[3] > 2019 || tag[3] < 1900){
                            goodtogo3 = false;
                        }else{
                            goodtogo3 = true;
                        }
                    //if an even month
                    }else{
                        //check year is in range
                        if (tag[3] < 2018 || tag[3] > 1900) {
                            //if February
                            if (tag[2] == 02) {
                                if (tag[1] > 28 || tag[1] < 1) {
                                    goodtogo3 = false;
                                }else{
                                    goodtogo3 = true;
                                }
                            //if any other even month
                            }else{
                                if (tag[1] > 30 || tag[1] < 1 || tag[2] < 1) {
                                    goodtogo3 = false;
                                }else{
                                    goodtogo3 = true;
                                }
                            }
                        }else{
                            goodtogo3 = false;
                        }
                    }
                //months after July
                }else{
                    //if an even month
                    if ((tag[2] % 2) == 0) {
                        //if above 31 days, it won't work
                        if (tag[1] > 31 || tag[1] < 1 || tag[2] > 12) {
                            //document.getElementById('test').innerHTML = goodtogo2;
                            goodtogo3 = false;
                        //if outside possible year range, won't work
                        }else if (tag[3] > 2018 || tag[3] < 1900){
                            goodtogo3 = false;
                        }else{
                            goodtogo3 = true;
                        }
                    //if an odd month
                    }else{
                        //check year is in range
                        if (tag[3] < 2018 || tag[3] > 1900) {

                            if (tag[1] > 30 || tag[1] < 1 || tag[2] > 12) {
                                    goodtogo3 = false;
                            }else{
                                goodtogo3 = true;
                            }
                        }else{
                            goodtogo3 = false;
                        }
                    }
                }

                //can't input November 2019 or later 
                if (tag[3] == 2019 & tag[2] > 10){
                    goodtogo3 = false;
                }

                if (goodtogo3) {
                    document.getElementById(errID).innerHTML = 'No errors'
                    document.getElementById(errID).style.color = 'green'
                }else{
                    document.getElementById(errID).innerHTML = 'Invalid DOB'
                    document.getElementById(errID).style.color = 'red'
                }
            }else{
                goodtogo3 = false;
                document.getElementById(errID).innerHTML = 'Invalid DOB'
                document.getElementById(errID).style.color = 'red'
            }
        }

        //checks the whole form is valid for submission
        function allOK(){
            if (goodtogo1 & goodtogo2 & goodtogo3) {
                return true;
            }else{
                alert("Correct errors and fill in all fields in form before submitting!")
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
		Add Subject
	</h1>
    
    <form id="addSubject" method="post" onSubmit="return allOK()" action="success.php">
    	<table style="color:#FFFFFF">
    		<tr>
    			<td>First Name&nbsp;</td>
                <td><input type="text" id="fname" name="fname" onchange="validName('fname','errorMsg1')" placeholder="Enter First Name"></td>
                <td id="errorMsg1" style="color:green"></td>
    		</tr>
            <tr>
                <td>Last Name&nbsp;</td>
                <td><input type="text" id="lname" name="lname" onchange="validName('lname','errorMsg2')" placeholder="Enter Last Name"></td>
                <td id="errorMsg2" style="color:green"></td>
            </tr>
            <tr>
                <td>DOB (dd/mm/yyyy)&nbsp;</td>
                <td><input type="text" id="dob" name="dob" maxlength="10" onchange="validDOB('dob','errorMsg3')" placeholder="Enter DOB"></td>
                <td id="errorMsg3" style="color:green"></td>
            </tr>
            <tr>
                <td>Gender&nbsp;</td>
                <td>
                    <select name="gender">
                        <option>Female</option>
                        <option>Male</option>
                        <option>Other</option>
                        <option>Prefer not to say</option>
                    </select>
                </td>
            </tr>
    	</table>
        <input type="submit" name="submitbutton" id="submitbutton" class=button4 value="Add">
        <?php  
            //hidden input for username and password
            echo "<input type=\"hidden\" id='username' name='username' value='" . $_POST['username'] . "'>";
            echo "<input type=\"hidden\" id='password' name='password' value='" . $_POST['password'] . "'>";
            echo "<input type=\"hidden\" id='page_type' name='page_type' value='add_subject'>";
            if (isset($_POST['researcherID'])) {
                echo "<input type=\"hidden\" id='researcherID' name='researcherID' value='" . $_POST['researcherID'] . "'>";
            }
        ?>
	</form>
</body>

</html>
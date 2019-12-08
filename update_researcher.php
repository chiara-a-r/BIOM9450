<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>update_researcher</title>
    <link href="style_sheet.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
        goodtogo1 = true;
        goodtogo2 = true;
        goodtogo3 = true;
        goodtogo4 = true;

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

        //checks the whole form is valid for submission
        function allOK(){
            if (goodtogo1 & goodtogo2 & goodtogo3 & goodtogo4) {
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
        //if not logged in
        if (!(isset($_POST['username']) and isset($_POST['password']))) {
            //take back to login page
            header("Location: ./login.php");
            exit();
        }

        //back to main page button
            echo "<form id=\"main\" method=post action=\"main.php\">";
            //obtain info
            $username = $_POST["username"];
            $password = $_POST["password"];

            //insert fields
            echo "<input type=\"hidden\" id=\"username\" name=\"username\" value=\"" . $username . "\">";
            echo "<input type=\"hidden\" id=\"password\" name=\"password\" value=\"" . $password . "\">";
            echo "<input type=\"submit\" class=button2 name=\"main\" id=\"main\" value=\"Back to Main\"></form>";

        //connect to database
        $conn = odbc_connect('z5113387','','',SQL_CUR_USE_ODBC);

        //obtain subject's information 
        $name = $_POST['name'];
        $uname = $_POST['uname'];
        $pword = $_POST['pword'];
        $ID = $_POST['researcherID'];
        
        //if assigning subject
        if (isset($_POST['assign'])) {
            echo "<h1 style=\"color: #FFFFFF\">Assign a Subject</h1>";
            echo "<form method=post action=\"success.php\">";
            echo "<table style=\"color:#FFFFFF\">";
            echo "<tr><td>Pick a subject: </td><td><select name=\"subject\">";
            //list the subjects
            $sql = "SELECT Subject.SubjectID, Subject.FirstName, Subject.LastName FROM Subject WHERE Subject.SubjectID NOT IN (SELECT Subject.SubjectID FROM Subject INNER JOIN ResearcherSubjectRel ON ResearcherSubjectRel.SubjectID = Subject.SubjectID WHERE ResearcherSubjectRel.ResearcherID = " . $ID . ");";
            $rs = odbc_exec($conn, $sql);
            while (odbc_fetch_row($rs)){
                echo "<option>" . odbc_result($rs, 'FirstName') . " " . odbc_result($rs, 'LastName') . " #" . odbc_result($rs, 'SubjectID') . "</option>";
            }
            echo "</select></td><br>";
            echo "</table>";
            echo "<input type=\"submit\" name=\"assign\" value=\"Assign\">";
            //hidden input for username and password
            echo "<input type=\"hidden\" id='username' name='username' value='" . $_POST['username'] . "'>";
            echo "<input type=\"hidden\" id='password' name='password' value='" . $_POST['password'] . "'>";
            echo "<input type=\"hidden\" id='researcherID' name='researcherID' value='" . $ID . "'>";
            echo "<input type=\"hidden\" id='page_type' name='page_type' value='assign_subject'>";
            echo "</form>";

        
        //if updating details
        } elseif (isset($_POST['update'])) {
            echo "<h1 style=\"color: #FFFFFF\">Update Researcher's Details</h1>";

            //form for details to be updated
            echo "<form method=post onSubmit=\"return allOK()\" action=\"success.php\">";
            echo "<table style=\"color:#FFFFFF\">";
            //full name
            echo "<tr><td>Full name: </td><td><input type=\"text\" onchange=\"validName('name', 'errorMsg1')\" id='name' name=\"name\" value='" . $name . "''></td><td id=\"errorMsg1\" style=\"color:green\"></td></tr>";
            //username
            echo "<tr><td>Username: </td><td><input type=\"text\" name=\"uname\" id='uname' onchange=\"validUsername('uname', 'errorMsg2')\" value='" . $uname . "'></td><td id=\"errorMsg2\" style=\"color:green\"></td></tr>";
            //password
            echo "<tr><td>Password: </td><td><input type=\"password\" id='pword' onchange=\"validPassword('pword','errorMsg3')\" name=\"pword\" value='" . $pword . "''></td><td id=\"errorMsg3\" style=\"color:green\"></td></tr>";
            //re-enter password
            echo "<tr><td>Re-enter password: </td><td><input type=\"password\" id='pword2' onchange=\"checkSame('pword', 'pword2','errorMsg4')\" name=\"pword2\" value=" . $pword . "></td><td id=\"errorMsg4\" style=\"color:green\"></td></tr>";
            echo "</table>";
            echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
            //hidden input for username and password
            echo "<input type=\"hidden\" id='username' name='username' value='" . $_POST['username'] . "'>";
            echo "<input type=\"hidden\" id='password' name='password' value='" . $_POST['password'] . "'>";
            echo "<input type=\"hidden\" id='researcherID' name='researcherID' value='" . $ID . "'>";
            echo "<input type=\"hidden\" id='page_type' name='page_type' value='update_researcher'>";
            echo "</form>";

        }


    ?>
    
</body>

</html>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>update_subject</title>
    <link href="style_sheet.css" rel="stylesheet" type="text/css">

    <?php
        //if not logged in
        if (!(isset($_POST['username']) and isset($_POST['password']))) {
            //take back to login page
            header("Location: ./login.php");
            exit();
        }
    ?>

    <script type="text/javascript">
        goodtogo1 = true;
        goodtogo2 = true;
        goodtogo3 = true;

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
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];

        //add apostrophes to info for sql 
        //$first_name2 = "'" . $first_name . "'";
        //$last_name2 = "'" . $last_name . "'";
        //$dob2 = "'" . $dob . "'";
        
        //if viewing info
        if (isset($_POST['view'])) {
            echo "<h1 style=\"color: #FFFFFF\">View Subject's Data</h1>";
            echo "<h2>" . $first_name . " " . $last_name . "</h2>";
			$sql = "SELECT ActivityType.ActivityName AS Activity, Activity.TestDate AS TestDate, VitalType.VitalName AS Vital, PhysiologicalData.Data AS Data FROM VitalType INNER JOIN (Subject INNER JOIN (ResearcherSubjectRel INNER JOIN ((ActivityType INNER JOIN Activity ON ActivityType.ID = Activity.Type) INNER JOIN PhysiologicalData ON Activity.ActivityID = PhysiologicalData.ActivityID) ON ResearcherSubjectRel.ResSubID = Activity.ResSubID) ON Subject.SubjectID = ResearcherSubjectRel.SubjectID) ON VitalType.ID = PhysiologicalData.VitalSignType WHERE Subject.FirstName = '" . $first_name . "' AND Subject.LastName = '" . $last_name . "';";
            $rs = odbc_exec($conn, $sql);

            //make heart rate table
            $hr_exist = false;
            echo "<table style='width:100%' class=\"activity_list\">";
            echo "<caption><h3>Heart Rate</h3></caption>";
            echo "<tr><th>Activity</th><th>Date</th><th>Rate (beats/min)</th></tr>";
            while (odbc_fetch_row($rs)){
                if (odbc_result($rs, "Vital") == "Heart Rate") {
                    $hr_exist = true;
                    echo "<tr><td>" . odbc_result($rs, "Activity") . "</td>";
                    echo "<td>" . odbc_result($rs, "TestDate") . "</td>";
                    echo "<td>" . odbc_result($rs, "Data") . "</td></tr>";
                }
            }
            echo "</table>";
            if (!$hr_exist) {
                echo "No Heart Rate data";
            }

            //make blood pressure table
            $bp_exist = false;
            $rs = odbc_exec($conn, $sql);
            echo "<table style='width:100%' class=\"activity_list\">";
            echo "<caption><h3>Blood Pressure</h3></caption>";
            echo "<tr><th>Activity</th><th>Date</th><th>Systolic (mmHg)</th><th>Diastolic (mmHg)</th><th>Mean (mmHg)</th></tr>";
            while (odbc_fetch_row($rs)){
                if (odbc_result($rs, "Vital") == "Blood Pressure") {
                    $bp_exist = true;
                    echo "<tr><td>" . odbc_result($rs, "Activity") . "</td>";
                    echo "<td>" . odbc_result($rs, "TestDate") . "</td>";
                    $bp = explode(" ", odbc_result($rs, "Data"));
                    echo "<td>" . $bp[0] . "</td>";
                    echo "<td>" . $bp[1] . "</td>";
                    echo "<td>" . $bp[2] . "</td></tr>";
                }
            }
            echo "</table><br>";
            if (!$bp_exist) {
                echo "No Blood Pressure Data";
            }

            //make ECG plot
            $rs = odbc_exec($conn, $sql);

			//relative path to the TeeChart directory
			require_once("sources/libTeeChart.php"); 
			
			//heading
			echo "<h3>ECG</h3>";
	
			//Set up chart
			$chart1 = new TChart(640,480);
			$chart1->getAspect()->setView3D(false);
			$chart1->getHeader()->setText("ECG data vs time samples");
			$chart1->getLegend()->setVisible(FALSE);
		
			$varname = new Line($chart1->getChart()); 
            $XValues = array();
            $YValues = array();

            //make array of ECG values (y) and x values
            $rs = odbc_exec($conn, $sql);
            while (odbc_fetch_row($rs)){
                if (odbc_result($rs, "Vital") == "ECG") {
                    $YValues = explode(" ", odbc_result($rs, "Data"));
                    for ($i=0; $i < count($YValues); $i++) { 
                        $YValues[$i] = (float)$YValues[$i];
                        $XValues[$i] = $i*50;
                    }
                }
            }
		
			$i=0;
			foreach($YValues as $x){
				$varname->addXY($XValues[$i],$YValues[$i]);
				$i++;
			}
		
			$varname->Setcolor(Color::BLUE()); 
			$chart1->getAxes()->getBottom()->getTitle()->setText("Samples (Hz)"); 
			$chart1->getAxes()->getLeft()->getTitle()->setText("ECG magnitude (mV)"); 
            if (!empty($YValues)) {

			    $chart1->render("ecg.png");
				
			    echo "<img src=\"ecg.png\" style=\"border: 1px solid gray;\"/>";
            } else {
                echo "No ECG data";
            }

            //make PPG plot
            $rs = odbc_exec($conn, $sql);
			
			//heading
			echo "<h3>PPG</h3>";
	
			//Set up chart
			$chart1 = new TChart(640,480);
			$chart1->getAspect()->setView3D(false);
			$chart1->getHeader()->setText("PPG data vs time samples");
			$chart1->getLegend()->setVisible(FALSE);
		
			$varname = new Line($chart1->getChart()); 
            $XValues = array();
            $YValues = array();
		
			//make array of PPG values (y) and x values
            $rs = odbc_exec($conn, $sql);
            while (odbc_fetch_row($rs)){
                if (odbc_result($rs, "Vital") == "PPG") {
                    $YValues = explode(" ", odbc_result($rs, "Data"));
                    for ($i=0; $i < count($YValues); $i++) { 
                        $YValues[$i] = $YValues[$i];
                        $XValues[$i] = $i*50;
                    }
                }
            }
		
			$i=0;
			foreach($YValues as $x){
				$varname->addXY($XValues[$i],$YValues[$i]);
				$i++;
			}
		
			$varname->Setcolor(Color::BLUE()); 
			$chart1->getAxes()->getBottom()->getTitle()->setText("Samples (Hz)"); 
			$chart1->getAxes()->getLeft()->getTitle()->setText("PPG magnitude (10 bit offset binary)"); 

            if (!empty($YValues)) {
			    $chart1->render("ppg.png");
				
			    echo "<img src=\"ppg.png\" style=\"border: 1px solid gray;\"/>";
            } else {
                echo "No PPG data";
            }

            /*while (odbc_fetch_row($rs)) {
                echo "<p>" . odbc_result($rs, "Activity") . "<br>";
                echo odbc_result($rs, "TestDate") . "<br>";
                echo odbc_result($rs, "Vital") . "<br>";
                echo odbc_result($rs, "Data") . "</p>";
            }*/
        
        //if updating details
        } elseif (isset($_POST['update'])) {
            echo "<h1 style=\"color: #FFFFFF\">Update Subject's Details</h1>";

            //form for details to be updated
            echo "<form method=post onSubmit=\"return allOK()\" action=\"success.php\">";
            echo "<table style=\"color:#FFFFFF\">";
            //first name
            echo "<tr><td>First name: </td><td><input type=\"text\" onchange=\"validName('fname', 'errorMsg1')\" id='fname' name=\"fname\" value=" . $first_name . "></td><td id=\"errorMsg1\" style=\"color:green\"></td></tr>";
            //last name
            echo "<tr><td>Last name: </td><td><input type=\"text\" name=\"lname\" id='lname' onchange=\"validName('lname', 'errorMsg2')\" value=" . $last_name . "></td><td id=\"errorMsg2\" style=\"color:green\"></td></tr>";
            //DOB
            echo "<tr><td>DOB (dd/mm/yyyy): </td><td><input type=\"text\" id='dob' onchange=\"validDOB('dob','errorMsg3')\" name=\"dob\" value=" . $dob . "></td><td id=\"errorMsg3\" style=\"color:green\"></td></tr>";
            //Gender
            echo "<tr><td>Gender: </td><td><select name=\"gender\"><option selected=\"selected\">" . $gender . "</option><option>Female</option><option>Male</option><option>Other</option><option>Prefer not to say</option></select></td><br>";
            echo "</table>";
            echo "<input type=\"submit\" name=\"update\" class=button4 value=\"Update\">";
            //hidden input for username and password
            echo "<input type=\"hidden\" id='username' name='username' value='" . $_POST['username'] . "'>";
            echo "<input type=\"hidden\" id='password' name='password' value='" . $_POST['password'] . "'>";
            echo "<input type=\"hidden\" id='subjectID' name='subjectID' value='" . $_POST['subjectID'] . "'>";
            echo "<input type=\"hidden\" id='page_type' name='page_type' value='update_subject'>";
            echo "</form>";

        }


    ?>
    
</body>

</html>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>search_results</title>
    <link href="style_sheet.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
    	
    </script>

    <?php
        //if not logged in
        if (!(isset($_POST['username']) and isset($_POST['password']))) {
            //take back to login page
            header("Location: ./login.php");
            exit();
        }
    ?>

</head>

<body>

    <p>
        <?php
            //obtain info
            $username = $_POST["username"];
            $password = $_POST["password"];

            //back to main page button
            echo "<form id=\"main\" method=post action=\"main.php\">";
            //insert fields
            echo "<input type=\"hidden\" id=\"username\" name=\"username\" value=\"" . $username . "\">";
            echo "<input type=\"hidden\" id=\"password\" name=\"password\" value=\"" . $password . "\">";
            echo "<input type=\"submit\" class=button2 name=\"main\" id=\"main\" value=\"Back to Main\"></form>";

            //heading
            echo "<h1 style=\"color: #FFFFFF\">Search Results</h1>";

            //connect to database
            $conn = odbc_connect('z5113387','','',SQL_CUR_USE_ODBC);

            $activity = $_POST['activity'];
            $phys = $_POST['phys'];
            $request = $_POST['request'];
            $and = false;

            //get the important info
            $sql = "SELECT Subject.FirstName, Subject.LastName, ActivityType.ActivityName, VitalType.VitalName AS Vital, Activity.TestDate, Subject.DOB, Subject.Gender FROM Subject INNER JOIN (ResearcherSubjectRel INNER JOIN (VitalType INNER JOIN ((ActivityType INNER JOIN Activity ON ActivityType.ID = Activity.Type) INNER JOIN PhysiologicalData ON Activity.ActivityID = PhysiologicalData.ActivityID) ON VitalType.ID = PhysiologicalData.VitalSignType) ON ResearcherSubjectRel.ResSubID = Activity.ResSubID) ON Subject.SubjectID = ResearcherSubjectRel.SubjectID";

            //if activity specified
            if ($activity != "All activity types") {
                $sql = $sql . " WHERE ActivityType.ActivityName = '" . $activity . "'";
                $and = true;
            }

            //if physiological data type specified
            if ($phys != "All data types") {
                if ($and) {
                    $sql = $sql . " AND";
                } else {
                    $sql = $sql . " WHERE";
                }
                $sql = $sql . " VitalType.VitalName = '" . $phys . "'";
                $and = true;
            }

            //if coming from researcher page
            if (isset($_POST['researcherID'])) {
                if ($and) {
                    $sql = $sql . " AND";
                } else {
                    $sql = $sql . " WHERE";
                }
                $sql = $sql . " ResearcherSubjectRel.ResearcherID = " . $_POST['researcherID'];
                $and = true;
            }

            //if something typed in
            if ($request) {
                if ($and) {
                    $sql = $sql . " AND";
                } else {
                    $sql = $sql . " WHERE";
                }
                $sql = $sql . " (Subject.FirstName LIKE '%$request%' OR Subject.LastName LIKE '%$request%' OR Activity.TestDate LIKE '%$request%' OR PhysiologicalData.Data LIKE '%$request%')";
            }
            
            $sql = $sql . ";";
            //run sql command
            $rs = odbc_exec($conn, $sql);
            echo "<p>";
            while (odbc_fetch_row($rs)){

                echo "<form id=\"view\" method=\"post\" action=\"update_subject.php\">";
                //name and update and view buttons
                echo "<p>" . odbc_result($rs, "FirstName") . " " . odbc_result($rs, "LastName") . "&emsp;" . odbc_result($rs, 'ActivityName') . "&emsp;" . odbc_result($rs, 'Vital') . "&emsp;" . odbc_result($rs, 'TestDate') . "&nbsp;<input type=\"submit\" class=button name=\"view\" value=\"View data\"></p>";
                //hidden first name field
                echo "<input type=\"hidden\" id='first_name' name='first_name' value='" . odbc_result($rs, "FirstName") . "'>";
                // hidden last name field
                echo "<input type=\"hidden\" id='last_name' name='last_name' value='" . odbc_result($rs, "LastName") . "'>";
                //hidden dob field
                echo "<input type=\"hidden\" id='dob' name='dob' value='" . odbc_result($rs, "DOB") . "'>";
                //hidden gender field
                echo "<input type=\"hidden\" id='gender' name='gender' value='" . odbc_result($rs, "Gender") . "'>";
                //hidden username and password fields
                echo "<input type=\"hidden\" id=\"username\" name=\"username\" value=\"" . $_POST['username'] . "\">";
                echo "<input type=\"hidden\" id=\"password\" name=\"password\" value=\"" . $_POST['password'] . "\">";
                echo "</form>";
            }
            echo "</p>";
        ?>
    </p>
    
</body>

</html>
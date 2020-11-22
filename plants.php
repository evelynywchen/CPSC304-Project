<html>
<head>
    <title>CPSC 304 PHP/Oracle Demonstration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .btn {
            background-color: antiquewhite;
            border: none;
            color: black;
            padding: 16px 32px;
            text-align: center;
            font-size: 16px;
            margin: 4px 2px;
            transition: 0.3s;
            z-index:-1
            position: absolute;
        }
        .btn:hover {
            background-color: #3e8e41;
            color: white;
        }
        .loadingScreen {
            opacity: 1;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index:10001;
            animation-name: example;
            animation-duration: 4s;
            animation-fill-mode: forwards;
        }
        @keyframes example {
            0%  {opacity: 1;}
            50%  {opacity: 1;}
            100%  {opacity: 0;}
            0%  {background-color:black;}
            50%  {background-color:black;}
            100%  {background-color:white;}
            0%  {z-index:10001;}
            50%  {z-index:10001;}
            100%  {z-index:-1;}
        }

        .loadingScreen2 {
            z-index:10001;
            animation-name: example2;
            animation-duration: 4s;
            animation-fill-mode: forwards;
        }
        @keyframes example2 {
            0%  {background-color:black;}
            50%  {background-color:black;}
            100%  {background-color:white;}
            0%  {z-index:10001;}
            50%  {z-index:10001;}
            100%  {z-index:-1;}
        }

    </style>
</head>
<img class = loadingScreen src="https://i.imgur.com/GBCvzL7.gif?<?php echo time();?>">

<p style="text-align:center;font-size:50px;color:#3e8e41;font-family:'Verdana';"><b>Habitat Database</b></p>

<iframe width="1" height="1" src="https://www.youtube.com/embed/ut2KhcNtnm8?autoplay=1&start=60" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

</head>
<body class = loadingScreen2 style="background-color:black;">

<p style="text-align:center;font-size:50px;color:#3e8e41;font-family:'Verdana';"><b>Habitat Database</b></p>

<iframe width="1" height="1" src="https://www.youtube.com/embed/ut2KhcNtnm8?autoplay=1&start=60" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<img class = loadingScreen src="https://i.imgur.com/GBCvzL7.gif?<?php echo time();?>">


<hr />

<h2>Insert Values into Animals</h2>
<form method="POST" action="animals.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    Animal ID: <input type="text" name="aID"> <br /><br />
    Species: <input type="text" name="species"> <br /><br />
    Age: <input type="text" name="age"> <br /><br />

    <label for="diet">Choose the diet of the animal:</label>
    <select name="pickDiet" id="tableForm">
        <option value="herb">Herbivore</option>
        <option value="carni">Carnivore</option>
        <option value="omni">Omnivore</option>
    </select>
    <br /><br />
    Sub-category ID: <input type="text" name="sID"> <br /><br />


    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr />

<h2>
    <a href="https://www.students.cs.ubc.ca/~evelyncn/CPSC304-Project/database.php"><button>Back</button></a>
    <hr/>

    <?php
    //this tells the system that it's no longer just parsing html; it's now parsing PHP

    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

    function debugAlertMessage($message) {
        global $show_debug_alert_messages;

        if ($show_debug_alert_messages) {
            echo "<script type='text/javascript'>alert('" . $message . "');</script>";
        }
    }

    function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }

        return $statement;
    }

    function executeBoundSQL($cmdstr, $list) {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
    In this case you don't need to create the statement several times. Bound variables cause a statement to only be
    parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
    See the sample code below for how this function is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }
            
            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }
    }

    function printResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table demoTable:<br>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function connectToDB() {
        global $db_conn;

        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_evelyncn", "a12898490", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    function disconnectFromDB() {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }

    function handleInsertRequest() {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array (
            ":bind1" => $_POST['aID'],
            ":bind2" => $_POST['species'],
            ":bind3" => $_POST['age']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into Animals values (:bind1, :bind2, :bind3)", $alltuples);
        OCICommit($db_conn);

        $animalDiet = $_POST['pickDiet'];
        $tuple = array (
            ":bind1" => $_POST['aID'],
            ":bind2" => $_POST['sID']
        );

        $alltuples = array (
            $tuple
        );


        switch($animalDiet) {
            case "herb":
                executeBoundSQL("insert into Herbivores values (:bind1, :bind2)", $alltuples);
                OCICommit($db_conn);
                break;
            case "omni":
                executeBoundSQL("insert into Omnivores values (:bind1, :bind2)", $alltuples);
                OCICommit($db_conn);
                break;
            case "carni":
                executeBoundSQL("insert into Carnivores values (:bind1, :bind2)", $alltuples);
                OCICommit($db_conn);
                break;
        }
        echo "<br>Data successfully inserted! <br>";
    }

    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            } else if (array_key_exists('updateQueryRequest', $_POST)) {
                handleUpdateRequest();
            } else if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertRequest();
            }

            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            }

            disconnectFromDB();
        }
    }

    if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest'])) {
        handleGETRequest();
    }
    ?>
</body>
</html>


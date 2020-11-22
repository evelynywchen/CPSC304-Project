<html>
<head>
    <title>Insert into People</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .btn {
            background-color: #dddd;
            border: none;
            color: black;
            padding: 16px 32px;
            text-align: center;
            font-size: 16px;
            margin: 4px 2px;
            transition: 0.3s;
            z-index:-1
        }
        .btn:hover {
            background-color: #3e8e41;
            color: white;
        }
        .loadingScreen {
            opacity: 1;
            position: fixed;
            width: 1000%;
            max-width: 100%;
            bottom: 0%;
            z-index:10001;
            animation-name: example;
            animation-duration: 4s;
            animation-fill-mode: forwards;
        }
        @keyframes example {
            0%  {background-color:black;}
            50%  {background-color:black;}
            100%  {background-color:white;}
            0%  {opacity: 1;}
            50%  {opacity: 1;}
            100%  {opacity: 0;}
            0%  {z-index:10001;}
            50%  {z-index:10001;}
            100%  {z-index:-1;}
        }

    </style>
</head>
<img class = loadingScreen src="https://i.imgur.com/GBCvzL7.gif?<?php echo time();?>" >
<body style="background-color:white;">

<p style="text-align:center;font-size:50px;color:#3e8e41;font-family:'Verdana';"><b>Habitat Database</b></p>

<iframe width="1" height="1" src="https://www.youtube.com/embed/ut2KhcNtnm8?autoplay=1&start=60" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<hr />

<h2>Insert Values into People</h2>
<form method="POST" action="people.php"> <!--refresh page when submitted-->
    <input class="btn" type="hidden" id="insertQueryRequest" name="insertQueryRequest">
    Person ID: <input class="btn" type="text" name="ID"> <br /><br />
    Name: <input class="btn" type="text" name="name"> <br /><br />
    Age: <input class="btn" type="text" name="age"> <br /><br />

    <input class="btn" type="submit" value="Insert" name="insertSubmit"></p>
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
            ":bind1" => $_POST['name'],
            ":bind2" => $_POST['ID'],
            ":bind3" => $_POST['age']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into People values (:bind1, :bind2, :bind3)", $alltuples);
        OCICommit($db_conn);

        echo "<br>Data successfully inserted! <br>";
    }

    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('insertQueryRequest', $_POST)) {
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

    if (isset($_POST['insertSubmit'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest'])) {
        handleGETRequest();
    }
    ?>
</body>
</html>


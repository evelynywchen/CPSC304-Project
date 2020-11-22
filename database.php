<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->

<html>
<head>
    <title>CPSC 304 Habitat Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .btn {
            background-color: #ddd;
            border: none;
            color: black;
            padding: 16px 32px;
            text-align: center;
            font-size: 16px;
            margin: 4px 2px;
            transition: 0.3s;
            z-index:0
        }
        .btn:hover {
            background-color: #3e8e41;
            color: white;
            z-index:0
        }
        .loadingScreen {
            opacity: 1;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index:1;
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
            0%  {z-index:1;}
            50%  {z-index:1;}
            100%  {z-index:-1;}
        }

        .loadingScreen2 {
            z-index:1;
            animation-name: example2;
            animation-duration: 4s;
            animation-fill-mode: forwards;
        }
        @keyframes example2 {
            0%  {background-color:black;}
            50%  {background-color:black;}
            100%  {background-color:white;}
            0%  {z-index:1;}
            50%  {z-index:1;}
            100%  {z-index:-1;}
        }

    </style>
</head>
<body class = loadingScreen2 style="background-color:black;">

<p style="text-align:center;font-size:50px;color:#3e8e41;font-family:'Verdana';"><b>Habitat Database</b></p>

<iframe width="1" height="1" src="https://www.youtube.com/embed/ut2KhcNtnm8?autoplay=1&start=60" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<img src="https://imgur.com/X6inV5F.jpg">
<img class = loadingScreen src="https://i.imgur.com/GBCvzL7.gif?rnd=<%=rnd()%>">


<div style="position:relative;">
    <div style="opacity:0.5;position:absolute;left:50px;top:-30px;width:300px;height:150px;background-color:#40B3DF"></div>
    <div style="opacity:0.3;position:absolute;left:120px;top:20px;width:100px;height:170px;background-color:#73AD21"></div>
    <div style="margin-top:30px;width:360px;height:130px;padding:20px;border-radius:10px;border:10px solid #EE872A;font-size:120%;">
        <h1>Habitat Database</h1>
        <div style="letter-spacing:12px;font-size:15px;position:relative;left:25px;top:25px;">Manipulate Text</div>
        <div style="color:#40B3DF;letter-spacing:12px;font-size:15px;position:relative;left:25px;top:30px;">Colors,
            <span style="background-color:#B4009E;color:#ffffff;"> Boxes</span></div>
    </div>
</div>

<hr />

<h2>Insert Values into Database</h2>
<!--        <form method="POST" action="database.php"> refresh page when submitted-->
<!--            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">-->
<!--            Number: <input type="text" name="insNo"> <br /><br />-->
<!--            Name: <input type="text" name="insName"> <br /><br />-->
<!---->
<!--            <input type="submit" value="Insert" name="insertSubmit"></p>-->
<!--        </form>-->
<form method="POST" action="database.php">
    <label class="btn" for="table">Choose a table:</label>
    <select class="btn" name="table" id="tableForm" onchange="if (this.value) window.location.href=this.value">
        <option value="" selected disabled hidden>Pick a table</option>
        <option value="animals.php">Animals</option>
        <option value="plants.php">Plants</option>
        <option value="hab.php">Habitat</option>
        <option value="org.php">Organization</option>
        <option value="people.php">People</option>
        <option value="res.php">Resources</option>
        <option value="AS.php">Artificial Structures</option>
    </select>
    <!-- <br><br> -->
    <!-- <input type="submit" value="Submit"> -->
</form>


<hr />

<h2 >Delete a Person</h2>
<form method="POST" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
    <p> Person ID: <input class="btn" type="text" name="pID"> <br /> <br />  </p>

    <input type="submit" value="Delete" name="deleteSubmit"></p>
</form>
 
<hr />

<h2 >Update Temperature in Habitat</h2>

<form method="POST" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
    Habitat ID: <label>
        <input class="btn" type="number" name="habID">
    </label> <br /><br />
    New Temperature: <label>
        <input class="btn" type="number" name="temperature">
    </label> <br /><br />

    <input class="btn" type="submit" value="Update" name="displayTuples"></p>
</form>

<hr />

<h2 >Finding Organizations by Funds and Size</h2>
<form method="GET" action="database.php">
    <input type="hidden" id="selectionRequest" name="selectionRequest">
    <label>Funds</label>
    <select class="btn" name="operators" id="tableForm">
        <option value="greater">greater than</option>
        <option value="smaller">smaller than</option>
        <option value="equals">equals</option>
    </select>
    <input class="btn" type="number" name="funds">
    <br /><br />
    <label>Size of Organization</label>
    <select class="btn" name="op2" id="tableForm">
        <option value="greater">greater than</option>
        <option value="smaller">smaller than</option>
        <option value="equals">equals</option>
    </select>
    <input class="btn" type="number" name="size">
    <br /><br />

    <input class="btn" type="submit" value="Submit" name="selectSubmit"></p>
</form>
<hr />

<h2 >Projection of Artificial Structures' Details</h2>
<form method="GET" action="database.php">
    <input type="hidden" id="handleProjectionRequest" name="handleProjectionRequest">
    <input class="btn" type="submit" value="Projection" name="updateSubmit"></p>
</form>

<hr />

<h2>Join Resource and Consume to Find Details of Animals Consuming Certain Resource</h2>
<p>The values are case sensitive and if you enter in the wrong case, the Join statement will not do anything.</p>
<form method="GET" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="handleJoinRequest" name="handleJoinRequest">
    Resource Type: <label>
        <input class="btn" type="text" name="type_R">
    </label> <br /><br />

    <input class="btn" type="submit" value="Join" name="updateSubmit"></p>
</form>

<hr />

<h2>Group By: Show the year each organization first founded a subsidiary</h2>
<form method="GET" action="database.php">
    <input type="hidden" id="handleGroupByRequest" name="handleGroupByRequest">
    <input class="btn" type="submit" name="GroupBy"></p>
</form>

<h2>Having: Show the people who own multiple organizations</h2>
<form method="GET" action="database.php">
    <input type="hidden" id="handleHavingRequest" name="handleHavingRequest">
    <input class="btn" type="submit" name="Having"></p>
</form>

<h2>Count the Tuples in DemoTable</h2>
<form method="GET" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="countTupleRequest" name="countTupleRequest">
    <input class="btn" type="submit" name="countTuples"></p>
</form>

<h2>Display the Animals in Database</h2>
<form method="GET" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
    <input class="btn" type="submit" name="displayTuples"></p>
</form>

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
    echo "<table>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr> </p>"; //or just use "echo $row[0]"
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

function handleJoinRequest() {
    global $db_conn;
    $type_R = $_GET['type_R'];
    $string = "SELECT Resources.type_R, Consume.aID, Consume.species FROM Resources RIGHT JOIN Consume ON Resources.resID = Consume.resID WHERE Resources.type_R='" . $type_R . "' ORDER BY Resources.resID";
    $result = executePlainSQL($string);
    OCICommit($db_conn);
    printResult($result);
}

function handleProjectionRequest() {
    global $db_conn;
    $string = "SELECT Builds_AS.org_name, Builds_AS.cost_AS, Builds_AS.completionYear FROM Builds_AS";
    $result = executePlainSQL($string);
    OCICommit($db_conn);
    printResult($result);
}

function handleResetRequest() {
    global $db_conn;
    // Drop old table
    executePlainSQL("DROP TABLE demoTable");
    //runDropTables();

    // Create new table
    echo "<br> creating new table <br>";
    executePlainSQL("create table Animals(aID int PRIMARY KEY, species char(40) not null, age int, amount int");
    //(id int PRIMARY KEY, name char(30))")
    OCICommit($db_conn);
}

function handleDeleteRequest() {
    global $db_conn;

    $pID = $_POST['pID'];

    executePlainSQL("DELETE FROM Owns WHERE pID ='" . $pID . "'");
    executePlainSQL("DELETE FROM People WHERE pID ='" . $pID . "'");

    OCICommit($db_conn);
}

function handleCountRequest() {
    global $db_conn;

    $result = executePlainSQL("SELECT Count(*) FROM demoTable");

    if (($row = oci_fetch_row($result)) != false) {
        echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
    }
}

function handleGroupByRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT min(founded), org_name FROM has_subsidiary GROUP BY org_name");
    echo "<br> The year each organization founded its first subsidiary <br>";
    echo "<table>";
    echo "<tr><th>Year founded</th><th>Organization name</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
    OCICommit($db_conn);
}

function handleHavingRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT name_people from people
								WHERE pID in (
									SELECT pID from Owns 
									GROUP BY pID
									HAVING COUNT(pID)>1)");
    echo "<br> A list of people who own more than one organization <br>";
    echo "<table>";
    echo "<tr><th>Name</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
    OCICommit($db_conn);

}

function handleDisplayRequest() {
    global $db_conn;

    $result = executePlainSQL("SELECT * FROM Animals");
    echo "<br>Retrieved data from table Animals:<br>";
    echo "<table>";
    echo "<tr><th>aID</th><th>Species</th><th>Age</th></tr>";
    printResult($result);

}

function handleSelectRequest() {
    global $db_conn,$statement;
    $result = 0;
    $fundsOp = $_GET['operators'];
    $sizeOp = $_GET['op2'];
    $funds = $_GET['funds'];
    $size = $_GET['size'];

    switch($fundsOp) {
        case "greater":
            switch($sizeOp) {
                case "greater":
                    $statement = "SELECT * FROM Organization WHERE funds>($funds) AND size_org>($size)";
                    break;
                case "smaller":
                    $statement = "SELECT * FROM Organization WHERE funds>($funds) AND size_org<($size)";
                    break;
                case "equals":
                    $statement = "SELECT * FROM Organization WHERE funds>($funds) AND size_org=($size)";
                    break;
            }
            break;
        case "smaller":
            switch($sizeOp) {
                case "greater":
                    $statement = "SELECT * FROM Organization WHERE funds<($funds) AND size_org>($size)";
                    break;
                case "smaller":
                    $statement = "SELECT * FROM Organization WHERE funds<($funds) AND size_org<($size)";
                    break;
                case "equals":
                    $statement = "SELECT * FROM Organization WHERE funds<($funds) AND size_org=($size)";
                    break;
            }
            break;
        case "equals":
            switch($sizeOp) {
                case "greater":
                    $statement = "SELECT * FROM Organization WHERE funds=($funds) AND size_org>($size)";
                    break;
                case "smaller":
                    $statement = "SELECT * FROM Organization WHERE funds=($funds) AND size_org<($size)";
                    break;
                case "equals":
                    $statement = "SELECT * FROM Organization WHERE funds=($funds) AND size_org=($size)";
                    break;
            }
            break;
    }

    $result = executePlainSQL($statement);
    OCICommit($db_conn);
    printResult($result);
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
        } else if (array_key_exists('deleteQueryRequest', $_POST)) {
            handleDeleteRequest();
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
        } else if (array_key_exists('displayTuples', $_GET)) {
            handleDisplayRequest();
        } else if (array_key_exists('handleJoinRequest', $_GET)) {
            handleJoinRequest();
        } else if (array_key_exists('handleProjectionRequest', $_GET)) {
            handleProjectionRequest();
        } else if (array_key_exists('selectSubmit', $_GET)) {
            handleSelectRequest();
        } else if (array_key_exists('handleGroupByRequest', $_GET)) {
            handleGroupByRequest();
        } else if (array_key_exists('handleHavingRequest', $_GET)) {
            handleHavingRequest();
        }
        disconnectFromDB();
    }
}

if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
    handlePOSTRequest();
} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTupleRequest']) || isset($_GET['handleJoinRequest']) || isset($_GET['handleProjectionRequest']) || isset($_GET['selectionRequest']) || isset($_GET['handleGroupByRequest']) || isset($_GET['handleHavingRequest'])) {
    handleGETRequest();
}
?>
</body>
</html>


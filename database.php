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
</head>

<body>

<hr />

<h1>Habitat Database</h1>
<img src="Habitat.jpg">

<hr />


<iframe width="1" height="1" src="https://www.youtube.com/embed/ut2KhcNtnm8?autoplay=1&start=60" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<hr />
<h2>Reset</h2>
<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

<form method="POST" action="database.php">
    <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
    <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
    <p><input type="submit" value="Reset" name="reset"></p>
</form>

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
    <label for="table">Choose a table:</label>
    <select name="table" id="tableForm" onchange="if (this.value) window.location.href=this.value">
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

<h2>Delete a Person</h2>
<form method="POST" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
    Person ID: <input type="text" name="pID"> <br /><br />

    <input type="submit" value="Delete" name="deleteSubmit"></p>
</form>
 
<hr />

<h2>Update Temperature in Habitat</h2>

<form method="POST" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
    Habitat ID: <label>
        <input type="number" name="habID">
    </label> <br /><br />
    New Temperature: <label>
        <input type="number" name="temperature">
    </label> <br /><br />

    <input type="submit" value="Update" name="displayTuples"></p>
</form>

<hr />

<h2>Finding Organizations by Funds and Size</h2>
<form method="GET" action="database.php">
    <input type="hidden" id="selectionRequest" name="selectionRequest">
    <label>Funds</label>
    <select name="operators" id="tableForm">
        <option value="greater">greater than</option>
        <option value="smaller">smaller than</option>
        <option value="equals">equals</option>
    </select>
    <input type="number" name="funds">
    <br /><br />
    <label>Size of Organization</label>
    <select name="op2" id="tableForm">
        <option value="greater">greater than</option>
        <option value="smaller">smaller than</option>
        <option value="equals">equals</option>
    </select>
    <input type="number" name="size">
    <br /><br />

    <input type="submit" value="Submit" name="selectSubmit"></p>
</form>
<hr />

<h2>Projection of Artificial Structures' Details</h2>
<form method="GET" action="database.php">
    <input type="hidden" id="handleProjectionRequest" name="handleProjectionRequest">
    <input type="submit" value="Projection" name="updateSubmit"></p>
</form>

<hr />

<h2>Join Resource and Consume to Find Details of Animals Consuming Certain Resource</h2>
<p>The values are case sensitive and if you enter in the wrong case, the Join statement will not do anything.</p>
<form method="GET" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="handleJoinRequest" name="handleJoinRequest">
    Resource Type: <label>
        <input type="text" name="type_R">
    </label> <br /><br />

    <input type="submit" value="Join" name="updateSubmit"></p>
</form>

<hr />

<h2>Count the Tuples in DemoTable</h2>
<form method="GET" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="countTupleRequest" name="countTupleRequest">
    <input type="submit" name="countTuples"></p>
</form>

<h2>Display the Animals in Database</h2>
<form method="GET" action="database.php"> <!--refresh page when submitted-->
    <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
    <input type="submit" name="displayTuples"></p>
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
    $type_R = $_POST['type_R'];
    print($type_R);
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

function handleDisplayRequest() {
    global $db_conn;

    $result = executePlainSQL("SELECT * FROM Animals");
    echo "<br>Retrieved data from table Animals:<br>";
    echo "<table>";
    echo "<tr><th>aID</th><th>Species</th><th>Age</th></tr>";
    printResult($result);

}

function handleSelectRequest() {
    global $db_conn;
    $result = 0;
    $fundsOp = $_GET['operators'];
    $sizeOp = $_GET['op2'];
    $funds = $_GET['funds'];
    $size = $_GET['size'];

    switch($fundsOp) {
        case "greater":
            switch($sizeOp) {
                case "greater":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds>($funds) AND size>($size)");
                    break;
                case "smaller":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds>($funds) AND size<($size)");
                    break;
                case "equals":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds>($funds) AND size=($size)");
                    break;
            }
            break;
        case "smaller":
            switch($sizeOp) {
                case "greater":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds<($funds) AND size>($size)");
                    break;
                case "smaller":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds<($funds) AND size<($size)");
                    break;
                case "equals":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds<($funds) AND size=($size)");
                    break;
            }
            break;
        case "equals":
            switch($sizeOp) {
                case "greater":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds=($funds) AND size>($size)");
                    break;
                case "smaller":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds=($funds) AND size<($size)");
                    break;
                case "equals":
                    $result = executePlainSQL("SELECT funds FROM Organization WHERE funds=($funds) AND size=($size)");
                    break;
            }
            break;
    }

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
        }
        else if (array_key_exists('selectSubmit', $_GET)) {
            handleSelectRequest();
        }
        disconnectFromDB();
    }
}

if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
    handlePOSTRequest();
} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTupleRequest']) || isset($_GET['handleJoinRequest']) || isset($_GET['handleProjectionRequest']) || isset($_GET['selectionRequest'])) {
    handleGETRequest();
}
?>
</body>
</html>


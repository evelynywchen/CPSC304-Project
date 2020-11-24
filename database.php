<html>
<head>
    <title>CPSC 304 Habitat Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="beautify.css">
</head>
<img class ="loadingScreen" src="https://i.imgur.com/GBCvzL7.gif?<?php echo time();?>" >
<body>

<p id="title"><b>Habitat Database</b></p>

<iframe width="1" height="1" src="https://www.youtube.com/embed/ut2KhcNtnm8?autoplay=1&start=60" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<hr />

<table class="half">
    <tr>
        <td>
            <h2>Insert Values into Database</h2>
            <form method="POST" action="database.php">
                <label for="table">Choose a table:</label>
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
            </form>
        </td>

        <td>
            <h2 >Delete a Person</h2>
            <form method="POST" action="database.php"> <!--refresh page when submitted-->
                <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
                Person ID: <input class="btn" type="text" name="pID">
                &emsp;&emsp;<input class="btn" type="submit" value="Delete" name="deleteSubmit"></p>
            </form>
        </td>
    </tr>
</table>

<hr />

<div class="single">
    <h2 >Update Temperature in Habitat</h2>
    <form method="POST" action="database.php"> <!--refresh page when submitted-->
        <input type="hidden" id="handleUpdateRequest" name="handleUpdateRequest">
        Habitat ID:
        <label>
            <input class="btn" type="number" name="habID">
        </label>
        &emsp;&emsp;&emsp;New Temperature:
        <label>
            <input class="btn" type="number" name="temperature">
        </label>
        &emsp;&emsp;<input class="btn" type="submit" value="Update" name="displayTuples"></p>
    </form>
</div>

<hr />

<table class="half">
    <tr>
        <td>
            <h2 >Selection: Finding Organizations by Funds and Size</h2>
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
        </td>
        <td>
            <h2>Join Resource and Consume to Find Details of Animals Consuming Certain Resource</h2>
            <p>The values are case sensitive and if you enter in the wrong case, the Join statement will not do anything.</p>
            <form method="GET" action="database.php"> <!--refresh page when submitted-->
                <input type="hidden" id="handleJoinRequest" name="handleJoinRequest">
                Resource Type: <label>
                    <input class="btn" type="text" name="type_R">
                </label> <br /><br />

                <input class="btn" type="submit" value="Join" name="updateSubmit"></p>
            </form>
        </td>
    </tr>
</table>

<hr />

<table class="half">
    <tr>
        <td>
            <h2 >Projection of Artificial Structures' Details</h2>
            <form method="GET" action="database.php">
                <input type="hidden" id="handleProjectionRequest" name="handleProjectionRequest">
                <input class="btn" type="submit" value="Projection" name="updateSubmit"></p>
            </form>
        </td>

        <td>
            <h2>Division: Find the animals that ate all the plants</h2>
            <form method="GET" action="database.php">
                <input type="hidden" id="handleDivisionRequest" name="handleDivisionRequest">
                <input class="btn" type="submit" name="Division"></p>
            </form>
        </td>
    </tr>
</table>

<hr />

<table class="half">
    <tr>
        <td>
            <h2>Group By: Show the year each organization first founded a subsidiary</h2>
            <form method="GET" action="database.php">
                <input type="hidden" id="handleGroupByRequest" name="handleGroupByRequest">
                <input class="btn" type="submit" name="GroupBy"></p>
            </form>
        </td>

        <td>
            <h2>Having: Show the people who own multiple organizations</h2>
            <form method="GET" action="database.php">
                <input type="hidden" id="handleHavingRequest" name="handleHavingRequest">
                <input class="btn" type="submit" name="Having"></p>
            </form>
        </td>
    </tr>
</table>

<hr />

<div class="single">
    <h2>Nested aggregation: Count the population of each species where the average age is above the average age of a certain species</h2>
    <p>Please use lowercases only.</p>
    <form method="GET" action="database.php"> <!--refresh page when submitted-->
        <input type="hidden" id="countTupleRequest" name="countTupleRequest">
        Species: <label> <input class="btn" type="text" name="species"> </label>
        &emsp;&emsp;<input class="btn" type="submit" name="countTuples"></p>
    </form>
</div>


<hr />

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
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr> </p>"; //or just use "echo $row[0]"
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

function handleUpdateRequest() {
    global $db_conn;

    $habitat_id = $_POST['habID'];
    $new_temperature = $_POST['temperature'];

    // you need the wrap the old name and new name values with single quotations



    $result = executePlainSQL("SELECT habID, temperature FROM Habitat");
    echo "<br> Temperature of habitat <b>before</b> updating<br>";
    echo "<table class='table table-striped'>";
    echo "<tr><th>Habitat ID</th><th>Temperature</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";

    executePlainSQL("UPDATE Habitat SET temperature='" . $new_temperature . "' WHERE habID='" . $habitat_id . "'");
    OCICommit($db_conn);

    $result = executePlainSQL("SELECT habID, temperature FROM Habitat");
    echo "<br> Temperature of habitat <b>after</b>  updating<br>";
    echo "<table class='table table-striped'>";
    echo "<tr><th>Habitat ID</th><th>Temperature</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
}

function handleJoinRequest() {
    global $db_conn;
    $type_R = $_GET['type_R'];
    $string = "SELECT Resources.type_R, Consume.aID, Consume.species FROM Resources RIGHT JOIN Consume ON Resources.resID = Consume.resID WHERE Resources.type_R='" . $type_R . "' ORDER BY Resources.resID";
    $result = executePlainSQL($string);
    OCICommit($db_conn);
    echo "<table class='table table-striped'>";
    echo "<tr><th>Resource Type</th><th>Animal ID</th><th>Species</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
}

function handleProjectionRequest() {
    global $db_conn;
    $string = "SELECT Builds_AS.org_name, Builds_AS.cost_AS, Builds_AS.completionYear FROM Builds_AS";
    $result = executePlainSQL($string);
    OCICommit($db_conn);
    echo "<table class='table table-striped'>";
    echo "<tr><th>Organization Name</th><th>Cost</th><th>completionYear</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
}

function handleDeleteRequest() {
    global $db_conn;

    $pID = $_POST['pID'];

    $result = executePlainSQL("SELECT name_people, pID FROM People");
    echo "<br> A list of people <b>before</b> deleting<br>";
    echo "<table class='table table-striped'>";
    echo "<tr><th>Name</th><th>pID</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";

    //executePlainSQL("DELETE FROM Owns WHERE pID ='" . $pID . "'");
    executePlainSQL("DELETE FROM People WHERE pID ='" . $pID . "'");

    $result = executePlainSQL("SELECT name_people, pID FROM People");
    echo "<br> A list of people <b>after</b> deleting<br>";
    echo "<table class='table table-striped'>";
    echo "<tr><th>Name</th><th>pID</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";

    OCICommit($db_conn);

}

//Nested aggregation: Count the population of each species where the average age is above the average age of a certain species
function handleCountRequest() {
    global $db_conn;
    $species = $_GET['species'];

    $result = executePlainSQL("SELECT species, Count(*), AVG(age) FROM Animals 
                                        GROUP BY species
                                        HAVING AVG(age) > (SELECT AVG(a2.age) 
                                                            FROM Animals a2 
                                                            GROUP BY a2.species 
                                                            HAVING a2.species ='". $species. "')");
    OCICommit($db_conn);
    echo "<table class='table table-striped'>";
    echo "<tr><th>Species</th><th>Count</th><th>Average age</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
}

function handleGroupByRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT min(founded), org_name FROM has_subsidiary GROUP BY org_name");
    echo "<br> The year each organization founded its first subsidiary <br>";
    echo "<table class='table table-striped'>";
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
    echo "<table class='table table-striped'>";
    echo "<tr><th>Name</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
    OCICommit($db_conn);

}


function handleDivisionRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT aID, species
                                        FROM Animals A
                                        WHERE NOT EXISTS 
                                        ((SELECT P.plantID  
                                        FROM Plants P)
                                        MINUS
                                        (SELECT E.plantID 
                                        FROM Eats_Plant E
                                        WHERE E.aID = A.aID))");
    echo "<br> A list of animals that ate all plants <br>";
    echo "<table class='table table-striped'>";
    echo "<tr><th>aID</th><th>Species Name</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
    OCICommit($db_conn);

}


function handleDisplayRequest() {
    global $db_conn;

    $result = executePlainSQL("SELECT * FROM Animals");
    echo "<br>Retrieved data from table Animals:<br>";
    echo "<table class='table table-striped'>";
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
    echo "<table class='table table-striped'>";
    echo "<tr><th>Name</th><th>ID</th><th>Funds</th><th>Founded</th><th>Size</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "</p> <tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr> </p>"; //or just use "echo $row[0]"
    }
    echo "</table>";
}

// HANDLE ALL POST ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handlePOSTRequest() {
    if (connectToDB()) {
        if (array_key_exists('handleUpdateRequest', $_POST)) {
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
        } else if (array_key_exists('handleDivisionRequest', $_GET)) {
            handleDivisionRequest();
        }
        disconnectFromDB();
    }
}

if (isset($_POST['handleUpdateRequest']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
    handlePOSTRequest();
} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTupleRequest']) || isset($_GET['handleJoinRequest']) || isset($_GET['handleProjectionRequest']) || isset($_GET['selectionRequest']) || isset($_GET['handleGroupByRequest']) || isset($_GET['handleHavingRequest']) || isset($_GET['handleDivisionRequest'])) {
    handleGETRequest();
}
?>
</body>
</html>


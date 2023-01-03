<?php

session_start();

function addToLog($action) {
    $user = "";
    if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
        $user = $_SESSION['username'];
    }
    else{
        $user = 'AnonymousUser';
    }
    $time = date("Y-m-d h:i:s", time());
    $input = $time . " -- " . $user . ": " . $action;
    $logfile = file_put_contents('userlogs.log', $input.PHP_EOL , FILE_APPEND | LOCK_EX);

    return $logfile;
}

if (
    !isset($_POST['myuser']) ||
    empty($_POST['myuser']) ||
    !isset($_POST['mypass']) ||
    empty($_POST['mypass'])
){
    addToLog("Tried to log in without filling up form properly.");
    ?>
    <script>
        alert("Form was not filled properly!")
        location.assign("login.php");
    </script>
    <?php
}

$username = $_POST['myuser'];
$pass = $_POST['mypass'];

$conn = new PDO("mysql:host=localhost:3306;dbname=websec;", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$querystring = "SELECT * FROM users WHERE username = ".$conn->quote($username)." AND pass = ".$conn->quote($pass);
echo $querystring;

$returnobj = $conn->query($querystring);
$returntable = $returnobj->fetchAll();
if ($returnobj->rowCount() == 0){
    addToLog("Entered incorrect username or password.");
    ?>
    <script>
        alert("No such user found!")
        location.assign("login.php");
    </script>
    <?php
}
else if ($returnobj->rowCount() != 0){
    foreach($returntable as $row){
        $_SESSION['firstname'] = $row["firstname"];
        $_SESSION['lastname'] = $row["lastname"];
        $_SESSION['username'] = $row['username'];
        $_SESSION['userid'] = $row['id'];
        $_SESSION['usertype'] = $row['usertype'];
    }
    addToLog("Logged in successfully.");
    ?>
    <script>
        location.assign("home.php")
    </script>
    <?php
}

?>
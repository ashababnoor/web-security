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

$userid = $_POST['userid'];
$title = $_POST['title'];
$body = $_POST['body'];


$conn = new PDO("mysql:host=localhost:3306;dbname=websec;", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$querystring = "SELECT * FROM users WHERE id = '$userid' limit 1";

$returnobj = $conn->query($querystring);
$returntable = $returnobj->fetchAll();
if ($returnobj->rowCount() == 1){
    foreach($returntable as $row){
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $username = $row['username'];
    }
}

$notequery = "INSERT INTO notes (title, body, userid)
              VALUES ('$title', '$body', $userid)";

$conn->exec($notequery);

addToLog("Successfully added new note.");
addToLog("Being redirected to homepage.");

?>

<script>
    location.assign("home.php?user=<?php echo $username ?>")
</script>
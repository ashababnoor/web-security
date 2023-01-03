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

addToLog("Logging out.");

session_destroy();
?>
    <script>location.assign("login.php");</script>
<?php
?>
<?php

// $logfile = fopen("userlogs.log", "w") or die("Unable to open file!");
// $txt = "John Doe\n";
// fwrite($logfile, $txt);
// fclose($myfile);

function addToLog($action) {
    $action = "logged in";
    if (isset($_SESSION['userid']) && $_SESSION['userid']){
        $user = $_SESSION['username'];
    }
    else{
        $user = 'AnonymousUser';
    }
    $time = date("Y-m-d h:i:s", time());
    $input = $time . " -- " . $user . ": " . $action;
    echo $input;
    $logfile = file_put_contents('userlogs.log', $input.PHP_EOL , FILE_APPEND | LOCK_EX);

    return $logfile;
}

?>
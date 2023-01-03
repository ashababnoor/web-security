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

    if (!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
        addToLog("Tried to access to users logs without logging in first.");
        ?>
        <script>
            alert("Please log in first!")
            location.assign("login.php");
        </script>
    <?php
    }

    if (!($_SESSION['usertype'] == "superadmin")){
        addToLog("Tried to access users logs without access.");
        ?>
        <script>
            alert("You can not access this page!")
            location.assign("home.php");
        </script>
        <?php
    }

    addToLog("Entered userlists page.");
    
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $username = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    $usertype = $_SESSION['usertype'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/css/style.css">

    <title>Protected App User List</title>
</head>
<body>
    <div class="container container-fluid" style="padding:4em 2em">
        <div class="welcome">
            <h2>Welcome <?php echo "$firstname $lastname" ?></h2>
            <div class="my-4">
                <span class="alert alert-sm alert-primary py-2">You are a <strong> <?php echo $usertype ?> </strong></span> &nbsp;
                <? if ($usertype == "admin" || $usertype == "superadmin") { ?>
                    <a href="userlist.php" class="btn btn-sm btn-primary"> User List</a>
                <?php } ?>
                <? if ($usertype == "superadmin") { ?>
                    <a href="logs.php" class="btn btn-sm btn-primary"> User Logs</a>
                <?php } ?>
                <a href="logoutProcess.php" class="btn btn-sm btn-outline-danger">Log Out</a>
            </div>
        </div>
        <hr>
        
        <div class="mt-4">
        <h5>User Logs</h5>
        <a href="userlogs.log" download="" class="btn btn-warning">Click here to <strong>download</strong> log file</a>
        </div>
        <div class="mt-3">
            <code>
            <?php echo nl2br(file_get_contents( "userlogs.log" )); ?>
            </code>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>
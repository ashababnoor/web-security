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
        addToLog("tried to enter homepage without logging in!");
        ?>
        <script>
            alert("Please log in first!")
            location.assign("login.php");
        </script>
    <?php
    }

    addToLog("Entered homepage.");
    
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

    <title>Protected App Home</title>
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

        <div class="new-note mt-4">
            <h5>Create a new note</h5>
            <form action="addNoteProcess.php" method="post">
                <input type="hidden" name="userid" value="<?php echo $userid ?>">
                <div class="form-control">
                    <input type="text" name="title" placeholder="Title" class="no-border no-outline full-width">
                    <hr>
                    <textarea type="text" name="body" placeholder="Write your note" class="no-border no-outline full-width" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-between mt-3" style="margin-bottom: 1em;">
                    <input class="btn btn-success" type="submit" value="Save Note">
                </div>
            </form>
        </div>
        <hr>
        
        <div class="note-list mt-4">
            <h5 class="mb-3">Here are your existing notes</h5>
            <?php
                try{
                    $conn = new PDO("mysql:host=localhost:3306;dbname=websec;", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    $querystring = "SELECT * FROM notes WHERE userid = $userid ORDER BY id DESC";
            
                    $returnobj = $conn->query($querystring);
                    $returntable = $returnobj->fetchAll();
                    
                    if($returnobj->rowCount()==0){
                        ?>
                            <div class="alert alert-warning">
                                No Notes Found.
                            </div> 
                        <?php
                    }
                    else{
                        ?>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                <?php
                                foreach($returntable as $row){
                                    $title = $row['title'];
                                    $body = $row['body'];
                                    ?>
                                    <div class="col">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="card-title"><?php echo $title ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?php echo $body ?></p>
                                        </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php
                    }
                }
                catch(PDOException $ex){
                    ?>
                        <script>
                            alert("Database error!");
                        </script>
                    <?php
                }
            ?>
    
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>
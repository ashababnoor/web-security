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
        addToLog("Tried to access userslist page without logging in.");
        ?>
        <script>
            alert("Please log in first!")
            location.assign("login.php");
        </script>
    <?php
    }

    if (!($_SESSION['usertype'] == "admin" || $_SESSION['usertype'] == "superadmin")){
        addToLog("Tried to access userslist page without access.")
        ?>
        <script>
            alert("You can not access this page!")
            location.assign("home.php");
        </script>
        <?php
    }

    addToLog("Entered userslist page.");
    
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
        <h5>User List</h5>
            <div class="table-responsive">
                <!-- Recipe Table -->
                <table class="table table-hover" id="dataTable">
                    <thead class="thead-light">
                        <th> ID </th> 
                        <th> Name </th>
                        <th> Email </th>
                        <th> User Type </th>
                    </thead>

                    <!-- Main Body of the table -->
                    <tbody>
                        <?php
                            try{
                                $conn = new PDO("mysql:host=localhost:3306;dbname=websec;", "root", "");
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                                $querystring = "SELECT * FROM users";
                    
                                $returnobj = $conn->query($querystring);
                                $returntable = $returnobj->fetchAll();
                    
                                if($returnobj->rowCount()==0){                    
                                    ?>
                                        <tr>
                                            <td colspan="10"> No Values Found </td>
                                        </tr>
                                    <?php
                                }
                                else{
                                    foreach($returntable as $rows){
                                        ?>
                                            <tr>
                                                <td> <?php echo $rows['id'] ?> </td>
                                                <td><?php echo $rows['firstname']." ".$rows['lastname'] ?></td>
                                                <td> <?php echo $rows['email'] ?> </td>
                                                <td> <?php echo $rows['usertype'] ?> </td>
                                            </tr>
                                        <?php
                                    }
                                }
                            }
                            catch(PDOException $ex){
                                ?>
                                    <tr>
                                        <td colspan="11"> No Data Found </td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>
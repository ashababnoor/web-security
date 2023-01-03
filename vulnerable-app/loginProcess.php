<?php

$username = $_POST['myuser'];
$pass = $_POST['mypass'];

$conn = new PDO("mysql:host=localhost:3306;dbname=websec;", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$querystring = "SELECT * FROM users WHERE username = '$username' AND pass = '$pass'";

$returnobj = $conn->query($querystring);
$returntable = $returnobj->fetchAll();
if ($returnobj->rowCount() != 0){
    foreach($returntable as $row){
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $username = $row['username'];
    }
}

?>

<script>
    location.assign("home.php?user=<?php echo $username ?>")
</script>
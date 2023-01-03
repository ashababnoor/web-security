<?php

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

?>

<script>
    location.assign("home.php?user=<?php echo $username ?>")
</script>
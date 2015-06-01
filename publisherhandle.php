<?php include 'includes/sessioncookie.php'; ?>
<?php
$_SESSION["timeout"] = time();
$action = $_GET['action'];
$isbn = $_GET['isbn'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "azteka";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if($action == "remove")
{
    $_SESSION["timeout"] = time();
    $removebestsellersql = "UPDATE books SET bestseller = 'No' WHERE ISBN = '$isbn'";
    $conn->query($removebestsellersql);
    echo "done";
}
if($action == "add")
{
    $_SESSION["timeout"] = time();
    $addbestsellersql = "UPDATE books SET bestseller = 'Yes' WHERE ISBN = '$isbn'";
    $conn->query($addbestsellersql);
    echo "done";
}
if($action == "cost")
{
    $_SESSION["timeout"] = time();
    $cost = $_GET['cost'];
    $costsql = "UPDATE books SET Price = $cost WHERE ISBN = '$isbn'";
    $conn->query($costsql);
    echo "done";
}
if($action == "Publish")
{
    $_SESSION["timeout"] = time();
   
    $psql = "UPDATE books SET status = '$action' WHERE ISBN = '$isbn'";
    $conn->query($psql);
    echo "done";
}
if($action == "Unpublish")
{
    $_SESSION["timeout"] = time();
    $upsql = "UPDATE books SET status = '$action' WHERE ISBN = '$isbn'";
    $conn->query($upsql);
    echo "done";
}


?>
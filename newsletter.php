<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'rentacardb');

function getDB(){
    $dbhost = DB_SERVER;
    $dbuser = DB_USERNAME;
    $dbpass = DB_PASSWORD;
    $dbname = DB_DATABASE;
    $dbconnection = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $dbconnection->exec("set names 'utf8';");
    $dbconnection->exec("SET CHARACTER SET 'utf8';");
    $dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbconnection;
}

$fusername = $_POST['username'];
$fname = $_POST['name'];
$femail = $_POST['email'];

$sql = "INSERT INTO clients (username, name, email) VALUES (:fusername, :fname, :femail)";

try{
    $dbCon = getDB();
    $stmt = $dbCon->prepare($sql);
    $stmt->bindParam("fusername", $fusername);
    $stmt->bindParam("fname", $fname);
    $stmt->bindParam("femail", $femail);
    $stmt->execute();
    $dbCon = null;
} catch(PDOException $e) {
    if($e->errorInfo[1] == 1062){
        echo '"error": Το e-mail είναι ήδη εγγεγραμμένο!';
    }else{
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
?>
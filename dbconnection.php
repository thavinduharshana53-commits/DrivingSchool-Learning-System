 <?php 
  $sever = "localhost";
  $name = "root";
  $password = "YOUR_MYSQL_PASSWORD";
  $dbname="YOUR_DATABASE_NAME";

  $conn = mysqli_connect($sever, $name, $password, $dbname);

  if(!$conn){
    die ("Connection Failed: ". mysqli_connect_error());
  }
 ?>
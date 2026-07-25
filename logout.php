 <?php 
  if(session_status()){
    session_start();
    session_destroy();
    header("location: index.php");
  }
 ?>
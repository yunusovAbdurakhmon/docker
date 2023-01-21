<?php 
$connect = mysqli_connect(
    'db', # service name
    'php_docker', #username
    'password', # password
    'php_docker' # db table
);

// Check connection
if ($connect -> connect_errno) {
    echo "Failed to connect to MySQL: " . $connect -> connect_error;
    exit();
  }
?>
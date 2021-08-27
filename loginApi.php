<?php
session_start();

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "logintest";


$login = $_GET['action'];

switch($login) {
    case 'signup':
        
        $uid = "";
        $array = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
                        'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        for ($i=0; $i < 10 ; $i++ ) { 
            $uid = $uid . $array[rand(0 , 35)];
        }
        
    
        $phonenumber = "";
        if (!isset($_GET['phone'])) {
            $phonenumber = "-";
        }else{
            $phonenumber = $_GET['phone'];
        }
        if (!isset($_GET['email'])) {
            echo json_encode(['error_code'=>'6' , 'success'=>'0' , 'message'=>'No Email Found' ]);
        }else if (!isset($_GET['password'])) {
            echo json_encode(['error_code'=>'7' , 'success'=>'0' , 'message'=>'No Password Found' ]);
        }else if (!isset($_GET['username'])) {
            echo json_encode(['error_code'=>'8' , 'success'=>'0' , 'message'=>'No Username Found' ]);
        }else{
            $email = $_GET['email'];
            $password = $_GET['password'];
            $username = $_GET['username'];
            $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
            if ($connection) {
                $sql = "SELECT * FROM `logintable` WHERE `email` = '$email' AND `password` = '$password'";
                $result = $connection->query($sql);
                mysqli_fetch_assoc($result);
                $num_rows = $result->num_rows;                
                if ($num_rows > 0 ) {
               //    $sqlNewQueryForDelete = "DELETE FROM `logintable` WHERE `email` = '$email' AND `password` = '$password'";
                    $sqlUpdate = "UPDATE `logintable`
                    SET `email`='$email', `password` = '$password', `username` = '$username' ,  `phonenumber` = '$phonenumber' 
                    WHERE `email` = '$email' AND `password` = '$password'" ;
                    $result2 = $connection->query($sqlUpdate);
                    echo json_encode(['error_code'=>'0' , 'success'=>'3' , 'message'=>'Login Updated Successfully' ]);

                }else{
                    $sqlNewQuery = "INSERT INTO `logintable`(`SrNo`, `uid`, `email`, `password`, `username`, `phonenumber`) VALUES ('','$uid','$email','$password','$username','$phonenumber')";
                    $result3 = $connection->query($sqlNewQuery);
                    echo json_encode(['error_code'=>'0' , 'success'=>'2' , 'message'=>'Login Inserted Successfully' ]);
                    

                }

              //  $sqlNewQuery = "INSERT INTO `logintable`(`SrNo`, `uid`, `email`, `password`, `username`, `phonenumber`) VALUES ('','$uid','$email','$password','$username','$phonenumber')";
              //  $result2 = $connection->query($sqlNewQuery);
                

            }else{
                echo json_encode(['error_code'=>'9' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
            }
        }
        break;

    case 'login':
        if (!isset($_GET['email'])) {
            echo json_encode(['error_code'=>'3' , 'success'=>'0' , 'message'=>'No Email Found' ]);
        }else if (!isset($_GET['password'])) {
            echo json_encode(['error_code'=>'4' , 'success'=>'0' , 'message'=>'No Password Found' ]);
        }else{
            $email = $_GET['email'];
            $password = $_GET['password'];
            
            $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
            if ($connection) {
                
                $sql = "SELECT * FROM `logintable` WHERE `email` = '$email' AND `password` = '$password'";
                
                $result = $connection->query($sql);
                mysqli_fetch_assoc($result);
                $num_rows = $result->num_rows;                
                if ($num_rows > 0 ) {
                    echo json_encode(['error_code'=>'0' , 'success'=>'1' , 'message'=>'Correct Login Email And Password' ]);
                }else{
                    echo json_encode(['error_code'=>'5' , 'success'=>'0' , 'message'=>'Wrong Email Or Password' ]);
                }

            }else{
                echo json_encode(['error_code'=>'1' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
            }
        }


        break;
  

    
    
    
    
    
    case 'get':

        if (isset($_GET['email'])) {
            $email = $_GET['email'];

            $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
            if ($connection) {
                
                $sql = "SELECT * FROM `logintable` WHERE `email` = '$email'";
                $result = $connection->query($sql);
                $num_rows = $result->num_rows;                
                if ($num_rows > 0 ) {

                for ($j=0; $j < $num_rows ; $j++) { 
                    
                    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

                    echo json_encode(['error_code'=>'0' , 'success'=>'4',
                        'uid'=>$row[1], 'email'=>$row[2], 'username'=>$row[4], 'phonenumber'=>$row[5],
                        'message'=>'Correct Login Email And Password' ]);
                    break;
                }
          
                }else{
                    echo json_encode(['error_code'=>'13' , 'success'=>'0' , 'message'=>'Wrong Email' ]);
                }

            }else{
                echo json_encode(['error_code'=>'10' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
            }
        }else if (isset($_GET['uid'])) {
            $uid = $_GET['uid'];

            $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
            if ($connection) {
                
                $sql = "SELECT * FROM `logintable` WHERE `uid` = '$uid'";
                $result = $connection->query($sql);
                $num_rows = $result->num_rows;                
                if ($num_rows > 0 ) {

                for ($j=0; $j < $num_rows ; $j++) { 
                    
                    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

                    echo json_encode(['error_code'=>'0' , 'success'=>'4',
                        'uid'=>$row[1], 'email'=>$row[2], 'username'=>$row[4], 'phonenumber'=>$row[5],
                        'message'=>'Correct Login Email And Password' ]);
                    break;
                }
          
                }else{
                    echo json_encode(['error_code'=>'14' , 'success'=>'0' , 'message'=>'Wrong UID' ]);
                }

            }else{
                echo json_encode(['error_code'=>'10' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
            }
        }else if (isset($_GET['phone'])) {
            $phone = $_GET['phone'];

            $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
            if ($connection) {
                
                $sql = "SELECT * FROM `logintable` WHERE `phonenumber` = '$phone'";
                $result = $connection->query($sql);
                $num_rows = $result->num_rows;                
                if ($num_rows > 0 ) {

                for ($j=0; $j < $num_rows ; $j++) { 
                    
                    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

                    echo json_encode(['error_code'=>'0' , 'success'=>'4',
                        'uid'=>$row[1], 'email'=>$row[2], 'username'=>$row[4], 'phonenumber'=>$row[5],
                        'message'=>'Correct Login Email And Password' ]);
                    break;
                }
          
                }else{
                    echo json_encode(['error_code'=>'15' , 'success'=>'0' , 'message'=>'Wrong Phone Number' ]);
                }

            }else{
                echo json_encode(['error_code'=>'10' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
            }
        }else if (isset($_GET['username'])) {
            $username = $_GET['username'];

            $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
            if ($connection) {
                
                $sql = "SELECT * FROM `logintable` WHERE `username` = '$username'";
                $result = $connection->query($sql);
                $num_rows = $result->num_rows;                
                if ($num_rows > 0 ) {

                for ($j=0; $j < $num_rows ; $j++) { 
                    
                    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

                    echo json_encode(['error_code'=>'0' , 'success'=>'4',
                        'uid'=>$row[1], 'email'=>$row[2], 'username'=>$row[4], 'phonenumber'=>$row[5],
                        'message'=>'Correct Login Email And Password' ]);
                    break;
                }
          
                }else{
                    echo json_encode(['error_code'=>'17' , 'success'=>'0' , 'message'=>'Wrong Username' ]);
                }

            }else{
                echo json_encode(['error_code'=>'10' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
            }
        }else{
            echo json_encode(['error_code'=>'17' , 'success'=>'0' , 'message'=>'No Information Found To Search' ]);

        }

        break;

default:
    echo json_encode(['error_code'=>'2' , 'success'=>'0' , 'message'=>'Unknown Action' ]);
    break;
        
}







?>
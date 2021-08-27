<?php
session_start();

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "logintest";

if(!isset($_GET['action'])){
    echo json_encode(['error_code'=>'1' , 'success'=>'0' , 'message'=>'Unknown Action' ]);
}else{
    $action = $_GET['action'];
    switch ($action) {
        case 'put':
            
            if (!isset($_GET['key'])) {
                echo json_encode(['error_code'=>'4' , 'success'=>'0' , 'message'=>'Key Not Found' ]);
            }else if(!isset($_GET['value'])){
                echo json_encode(['error_code'=>'5' , 'success'=>'0' , 'message'=>'Value Not Found' ]);
            }else{
                $key=$_GET['key'];
                $value=$_GET['value'];
                
                $sqlquery = "INSERT INTO `databasetable` (`SrNo`, `databaseKey`, `databaseValue`) VALUES('', '$key', '$value') ON DUPLICATE KEY UPDATE `databaseValue`='$value'";

                $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
                if ($connection) {
                    $result = $connection->query($sqlquery);                  
                    if($result){
                        echo json_encode(['error_code'=>'0' , 'success'=>'1' , 'message'=>'Data Inserted Successfully', 'key'=>$key ,'value'=>$value ]);
                    }else{
                        echo json_encode(['error_code'=>'3' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
    
                    }
                
                }else{
                    echo json_encode(['error_code'=>'2' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
    
                }
    
            }


        break;
        case 'get':
            if (!isset($_GET['key'])) {
                echo json_encode(['error_code'=>'7' , 'success'=>'0' , 'message'=>'Key Not Found' ]);
            }else{
                $key = $_GET['key']; 
                $sqlquery = "SELECT `SrNo`, `databaseKey`, `databaseValue` FROM `databasetable` WHERE `databaseKey`='$key'";
                $connection = mysqli_connect($db_host , $db_username,$db_password , $db_name );
                if ($connection) {
                    $result = $connection->query($sqlquery);                  
                    if($result){
                        $num_rows = $result->num_rows;  
                        if ($num_rows > 0) {
                            while ($row = $result->fetch_row()) {
                                echo json_encode(['error_code'=>'0' , 'success'=>'2' , 'message'=>'Data Retrived Successfully', 'key'=>$row[1] ,'value'=>$row[2] ]);
                                break;
                            } 
                       }else{
                            echo json_encode(['error_code'=>'9' , 'success'=>'0' , 'message'=>'No Data Found' ]);
                       }              
                }else{
                        echo json_encode(['error_code'=>'3' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
    
                    }
                }else{
                    echo json_encode(['error_code'=>'8' , 'success'=>'0' , 'message'=>'Connection Failed' ]);
                }
            
            }

        break;
        

        default:
            echo json_encode(['error_code'=>'6' , 'success'=>'0' , 'message'=>'Unknown Action' ]);
        break;

    }
}




















?>
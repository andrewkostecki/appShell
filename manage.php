<?php
    require("config.php");

    if(empty($_POST['username'])) die("Username required");	
    if(empty($_POST['name'])) die("Name required");	
    if(empty($_POST['email'])) die("email required");

    $username = $_POST['username'];
	$name = $_POST['name'];
    $email = $_POST['email'];
    $ID = $_POST['ID'];

    $query = "SELECT 1 FROM users WHERE username = :username";
	$query_params = array(':username' => $username);

    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } catch(PDOException $ex) { 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error on select checking for dupes: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
       	exit();
    } 
	
   
    $row = $stmt->fetch(); 
    if($row) { 
       	http_response_code(500);

		echo json_encode(array(
			'error' => array(	
				'msg' => 'This username is already registered: ',
			),
		));

        exit();
    }

    // update data
    $sql = "UPDATE users SET name = '$name', username = '$username', email = '$email' WHERE ID = '$ID'";

    $query_params = array(
		':username' => $username, 
		':name' => $name, 
        ':email' => $email,
        ':ID' => $ID
    );
    

    try {  
        $stmt = $db->prepare($sql); 
        $result = $stmt->execute($query_params); 

         

    } catch(PDOException $ex) { 
        
        http_response_code(500);
        echo json_encode(array(
                'error' => array(
                'msg' => 'Error on edit user info: ' . $ex->getMessage(),
                'code' => $ex->getCode(),
            ),
        ));
        exit();
    }
    
    $query = "SELECT ID, username, name, email, password FROM users WHERE username = :username";
    $query_params = array(':username' => $username);
    
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
            
            $outData = array();
            while($row = $stmt->fetch()) {
                $outData[] = $row;
            } 
            //echo json_encode($outData);
            echo '{"user":' . json_encode($outData) . '}'; 
            exit();
        } catch(PDOException $ex){ 
            http_response_code(500);
            echo json_encode(array(
                'error' => array(	
                'msg' => 'Error on select user: ' . $ex->getMessage(),
                'code' => $ex->getCode(),
                ),
            ));
               exit();
        }






?>
<?php
     require("config.php");


    
   //  print_r($_POST); exit();


    
    if(empty($_POST['username'])) die("Username required");
    if(empty($_POST['password'])) die("Password required");	

    $username = $_POST['username'];
    // $email = $_POST['username'];
    $password = $_POST['password'];
    $hash = md5($password);

    // $rememberMe = $_POST['rememberMe'];
    // $loginToken = $_POST['loginToken'];
    

    // $email = filter_var($email, FILTER_SANITIZE_EMAIL);


    $query = "SELECT 1 FROM users WHERE username = :username AND password = :password";
    $query_params = array(':username' => $username, ':password' => $hash);
    
   

    try { 
        $stmt = $db->prepare($query);  
        $result = $stmt->execute($query_params); //echo "here"; exit();
         
    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error on select checking for username: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
       	exit();
    } 
	
   
    $row = $stmt->fetch(); 
    if($row) { 
        // 	$query = "SELECT ID, username, name, email FROM users WHERE username = :userName";

        $query = "SELECT ID, username, name, email, password FROM users WHERE username = :username AND password = :password";
        $query_params = array(':username' => $username, ':password' => $hash);
    
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
    } else {
        http_response_code(500);
        echo json_encode(array(
            'error' => array(	
            'msg' => 'Error logging in: ',
            ),
        ));
    }



?>
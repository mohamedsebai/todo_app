<?php
ob_start();
session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['login'])){

        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email)){
            $_SESSION['error_login'] = 'email can not be empty';
            header('Location: ../login.php');
            exit();
        }
        if(empty($password)){
            $_SESSION['error_login'] = 'password can not be empty';
            header('Location: ../login.php');
            exit();
        }

        $file = file_get_contents('../data/users_data.json');
        $json_data = json_decode($file, true);

        if(!empty($json_data)){
            foreach($json_data as $data){
            if($data['email'] == $email){
                $stored_password = $data['password'];
                if($stored_password == $password){
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['email'] = $data['email'];
                        $_SESSION['user_id'] = $data['id'];

                        header('Location: ../index.php');
                }else{
                    $_SESSION['error_login'] = 'somthing is wrong with email and password';
                    header('Location: ../login.php');
                }
                
            }else{
                $_SESSION['error_login'] = 'you have to create account first';
                header('Location: ../login.php');
            }
            }
        }else{
            $_SESSION['error_login'] = 'you have to create account first';
            header('Location: ../login.php');
        }
    }
}else{
    header('location: ../index.php');
}

ob_end_flush();
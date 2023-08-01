<?php

session_start();

require('../includes/functions.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    if(isset($_POST['createTodo'])){

        $title = handelInput($_POST['title']);
        $user_id = $_POST['user_id'];

        $form_errors = array();

        if(strlen($title) < 3){
            $form_errors[] = 'title Must be larger than 2 characters';
        }

        if(strlen($title) > 30){
            $form_errors[] = 'title Must not be more than 30 characters';
        }


        $file = file_get_contents('../data/todoList.json');
        $json_data = json_decode($file, true);


        
        if(empty($json_data)){
            $json_data = [];
        }

        foreach($json_data as $data){
            if($data['title'] == $_POST['title']){
                $form_errors[] = 'This title for list is aleardy exists try different title';
                break;
            }
        }

        if(! empty($form_errors) ){
            $_SESSION['errors'] = $form_errors;
            header('Location: ../createTodo.php');
            exit();
        }
        // not empty error

        if(empty($form_errors)){

            $id = end($json_data)['id'] + 1;

            $extra = array(
                'id'      => $id,
                'title'   => $title,
                'status'  => 0,
                'user_id' => intval($user_id)
            );
            array_push($json_data, $extra);
            $final_data = json_encode($json_data);
        
            file_put_contents('../data/todoList.json', $final_data);
            $_SESSION['success'] = 'one mission added to your todo list successfully';
            header('Location: ../createTodo.php');

            ?>

        <?php } // empty form_errors ?>
<?php
}// end 
}else{
        header('Location: ../index.php');
} // end check request method ?>
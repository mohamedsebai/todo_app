<?php

session_start();

require('../includes/functions.php');


// first fo all we will recive id for all operation so we can check and validate it first
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $data_id = $_GET['id'];
}
if(isset($_GET['id']) && !is_numeric($_GET['id'])){
    $_SESSION['error'] = 'Do not play with our id boy';
    header('Location: ../list.php');
}


// check to update 
if(isset($_POST['update'])){
    $jsonString = file_get_contents('../data/todoList.json');
    $data = json_decode($jsonString, true);

    $title = handelInput($_POST['title']);

    $form_errors = array();

    foreach ($data as $entry) {
        if ($entry['title'] == $title) {
            $form_errors[] = 'this title is in todo list aleardy try anthor title';
        }
    }

    if(strlen($title) < 3){
        $form_errors[] = 'title Must be larger than 2 characters';
    }

    if(strlen($title) > 30){
        $form_errors[] = 'title Must not be more than 30 characters';
    }

    if(! empty($form_errors) ){
        $_SESSION['errors'] = $form_errors;
        header("Location: ../updateTodoList.php?id=$data_id");
    }

    if(empty($form_errors)){
        foreach ($data as $key => $entry) {
            if ($entry['id'] == $data_id) {
                $data[$key]['title'] = $title;
                $_SESSION['success'] = 'data updated successfully';
                header("Location: ../updateTodoList.php?id={$data_id}");
            }
        }
        $newJsonString = json_encode($data);
        file_put_contents('../data/todoList.json', $newJsonString);

    } // empty form_errors 


}else{
    header('Location: ../index.php');
}// end chekc to update 





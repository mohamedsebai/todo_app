<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header('location: login.php');
  die();
}
include 'includes/header.php';
include 'includes/navigation.php';


$file = file_get_contents('data/todoList.json');
$json_data = json_decode($file, true);

if(empty($json_data)){
    $json_data = [];
}



$new_array = [];
foreach($json_data as $key => $entry){
    if($entry['user_id']  == $_SESSION['user_id']){
      $new_array[] = $entry;
    }
}

if(isset($_POST['filter_data'])){
  $_SESSION['filter_data'] = $_POST['filter_data'];
}
if(isset($_GET['filter'])){
  $_SESSION['filter_data'] = $_GET['filter'];
}
if(!isset($_GET['filter']) && !isset($_POST['filter_data'])){
  $_SESSION['filter_data'] = 2;
}


if(isset($_SESSION['filter_data']) ){
    $new_array = [];
    
    // return data from user by status
    if($_SESSION['filter_data'] == 1 || $_SESSION['filter_data'] == 0){
      foreach($json_data as $key => $entry){
        if($entry['user_id']  == $_SESSION['user_id'] && $entry['status'] == $_SESSION['filter_data']){
          $new_array[] = $entry;
        }
      }
    }
    

    // return all data for user
    if($_SESSION['filter_data'] == 2){
      foreach($json_data as $key => $entry){
        if($entry['user_id']  == $_SESSION['user_id']){
          $new_array[] = $entry;
        }
      }
    }
    

    

    if(!empty($new_array)){
      $paginate_array = array_chunk($new_array, 3);
      $number_of_page = count($paginate_array);
    }

}else{
  $_SESSION['filter_data'] = $_GET['filter'];
}


if(!empty($new_array)){
  $paginate_array = array_chunk($new_array, 3);
  $number_of_page = count($paginate_array);
}else{
  $number_of_page = 0;
}






if (!isset ($_GET['page'])) {
    $page = 1;  
}
if(isset($_GET['page']) && is_numeric($_GET['page'])){
  $page = $_GET['page'];  
}
if(isset($_GET['page']) && !is_numeric($_GET['page'])){
  $page = 1;
}
if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > $number_of_page){
  $page = 1;  
}

// delete
if(isset($_GET['delete_id']) && !is_numeric($_GET['delete_id'])){
    $_SESSION['error'] = 'Do not play with our id boy';
}
if(isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])){
    $json_data = array_filter($json_data, function ($data) {
    if($data['id'] == $_GET['delete_id']){
      return false;
    }
    return true;
  });
  header("Location: list.php?page=$page&filter={$_SESSION['filter_data']}");
  $newJsonString = json_encode((array_values($json_data)));
  file_put_contents('data/todoList.json', $newJsonString);
}

// change status
if(isset($_GET['change_status_id']) && !is_numeric($_GET['change_status_id'])){
    $_SESSION['error'] = 'Do not play with our id boy';
}
if(isset($_GET['change_status_id']) && is_numeric($_GET['change_status_id'])){
  foreach ($json_data as $key => $entry) {
      if ($entry['id'] == $_GET['change_status_id']) {
            if($entry['status'] == 0){
              $json_data[$key]['status'] = 1;
            }else{
              $json_data[$key]['status']  = 0;
            }
            header("Location: list.php?page=$page&filter={$_SESSION['filter_data']}");
            $newJsonString = json_encode(array_values($json_data));
            file_put_contents('data/todoList.json', $newJsonString);
      }
  }
}
?>
<div class="profile_page">
  <div class="container">
    <h2 class="text-center">My list Todo for user name is : <?php echo $_SESSION['username']; ?></h2>
      <div class="profile_info">
      <div class="row">

        <?php if(isset($_SESSION['error'])) : ?>
          <div class="container">
                    <div class='alert alert-danger' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
                    <?php echo $_SESSION['error']; ?>
                    </div>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>


        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <select name="filter_data">
            <option value="2" 
            <?php if(isset($_SESSION['filter_data']) && $_SESSION['filter_data'] == 1){ echo 'selected'; } ?>>All</option>
            <option value="1" 
            <?php if(isset($_SESSION['filter_data']) && $_SESSION['filter_data'] == 1){ echo 'selected'; } ?>>complated</option>
            <option value="0" 
            <?php if(isset($_SESSION['filter_data']) && $_SESSION['filter_data'] == 0){ echo 'selected'; }?>>Not complated</option>
          </select>
          <input type="submit" value="filter" class="btn btn-primary pt-0 pb-0">
        </form>

      <table class="table table-sm table-dark">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">status</th>
            <th scope="col">Options</th>
          </tr>
        </thead>
          <tbody>

            <?php
            if(!empty($json_data)){
              if(isset($paginate_array)){
              foreach($paginate_array[$page - 1] as $data){
            ?>
            <tr>
              <td><?php echo $data['id']; ?></td>
              <td><?php echo $data['title']; ?></td>
              <td>
                <?php 
                  if($data['status'] == 0 ){ echo '<span class="btn btn-danger">Not completed</span>';} else{ echo '<span class="btn btn-success">Completed</span>'; }
                ?>
            </td>
              <td>
                <a class="btn btn-primary" href="updateTodoList.php?id=<?php echo $data['id']; ?>">update</a>
                <a class="btn btn-danger" href="list.php?page=<?php echo $page ?>&delete_id=<?php echo $data['id']; ?>&filter=<?php echo $_SESSION['filter_data']; ?>">delete</a>
                <a class="btn btn-warning" href="list.php?page=<?php echo $page ?>&change_status_id=<?php echo $data['id']; ?>&filter=<?php echo $_SESSION['filter_data']; ?>">change_Status</a>
              </td>
            </tr>
            <?php     } }else{ ?>
              <div class='alert alert-danger text-center' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
                    <?php echo 'create your first todo list'; ?> <a href="createTodo.php">Create_one</a>
              </div>
            <?php } } ?>
          </tbody>
      </table>

      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php for($page = 1; $page <= $number_of_page; $page ++): ?>
            <li class="page-item">
              <a class="page-link" href="list.php?page=<?php echo $page; ?>&filter=<?php echo $_SESSION['filter_data']; ?>"><?php echo $page; ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
      <?php if(empty($json_data)){ ?>
                <div class='alert alert-danger text-center' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
                    <?php echo 'create your first todo list'; ?> <a href="createTodo.php">Create_one</a>
                </div>
          <?php } ?>
      </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

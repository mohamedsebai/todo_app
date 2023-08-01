<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header('location: login.php');
  die();
}
include 'includes/header.php';
include 'includes/navigation.php';
?>

  <div class="admin-dashboard">
    </div>


    <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h2 class="text-center">Update Your todo list</h2>

        <?php if(isset($_SESSION['success'])):?>
          <div class="container">
                    <div class='alert alert-success text-center' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
                    <?php echo $_SESSION['success']; ?>
                    </div>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php 
          if(isset($_SESSION['errors'])){
            foreach ( $_SESSION['errors'] as $error ) {
              ?>
                <div class="container">
                    <div class='alert alert-danger' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
                    <?php echo $error; ?>
                    </div>
                </div>
              <?php
            }
            unset($_SESSION['errors']);
          }



      $file = file_get_contents('data/todoList.json');
      $json_data = json_decode($file, true);
      foreach($json_data as $data){
          if($data['id'] == $_GET['id']){ ?>
              <form action="handelers/handelTodoListOptions.php?id=<?php echo $data['id']?>" method="POST" class="m-auto">
              <!-- Start Username -->
              <div class="form-group">
                <label>Title:</label>
                <input type="text" placeholder="Type what you want to do" class="form-control" name="title" value="<?php echo $data['title']; ?>">
              </div>
              <!-- Start Profile Image -->
              <input type="submit" class="form-control btn btn-primary d-block" value="update" name="update">
            </form>
          <?php }
      }
      ?>
        
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>


  </div>

<?php include 'includes/footer.php'; ?>

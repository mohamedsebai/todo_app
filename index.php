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
    <div class="container">
      <div class="row">
        <div class="col-md-9">
        <?php 
          if(isset($_SESSION['username']) && isset($_SESSION['email'])){
              ?>
                <div class="container">
                    <div class='alert alert-success' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
                    <?php echo 'welcome back:=> ' . $_SESSION['username']; ?>
                    </div>
                </div>

                <div class="container">
                    <div class='alert alert-danger' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
                    <?php echo 'Email is : ' . $_SESSION['email']; ?>
                    </div>
                </div>
              <?php
          }
        ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include 'includes/footer.php'; ?>

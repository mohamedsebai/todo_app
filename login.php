<?php 
session_start();
if(isset($_SESSION['user_id'])){
  header('location: index.php');
  die();
}
include 'includes/header.php'; 
?>

<div class="Login">
  <div class="container">
    <div class="row">
<?php 
    if(isset($_SESSION['error_login'])){
        ?>
          <div class="container">
              <div class='alert alert-danger' style="padding: 2px 10px; max-width: 500px; margin: auto; margin-top: 5px; ">
              <?php echo $_SESSION['error_login']; ?>
              </div>
          </div>
        <?php
      unset($_SESSION['error_login']);
    }
?>
  <form action="handelers/handelLogin.php" method="POST" class="m-auto">
        <!-- Start Username -->
        <div class="form-group">
          <label>Email:</label>
          <input type="text" placeholder="email" class="form-control" name="email">
        </div>
        <!-- Start Password -->
        <div class="form-group">
          <label>Password:</label>
          <input type="text" placeholder="Password" class="form-control" name="password">
        </div>
        <input type="submit" class="form-control btn btn-primary d-block" value="login" name="login">
      </form>
      <a href="register.php">register</a>
    </div>
  </div>
</div>


<?php include 'includes/footer.php'; ?>

<header role="banner">
  <div class="top-bar">
    <div class="container">
      <div class="row">
        <div class="col-9 social">

        <?php if(isset($_SESSION['user_id'])): ?>
          <a class="nav-link active d-inline-block" href="index.php">Home</a>
          <a class="nav-link d-inline-block" href="createTodo.php">CreateTodo</a>
          <a class="nav-link d-inline-block" href="list.php">list</a>
          <a class="nav-link d-inline-block" href="logout.php">Logout</a>
          <?php else: ?>
          <a class="nav-link active d-inline-block" href="login.php">login</a>
          <a class="nav-link d-inline-block" href="register.php">register</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</header>

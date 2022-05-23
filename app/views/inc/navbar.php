<nav class="navbar navbar-expand-lg navbar-dark p-4 " style="background-color:#2a0182">
  <div class="container">
    <a class="navbar-brand col-5" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-5">
        <li class="nav-item">
          <a class="nav-link  mr-5" href="<?php echo URLROOT; ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo URLROOT; ?>/pages/Posts">Posts</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['user_id'])) :
          ?>
          <li class="nav-item">
          <li class="h-25 d-inline-block " ><img style="width: 3rem; height: 3rem " class="rounded-circle" src="./img/upload/<?php echo  $_SESSION['user_image']; ?>" alt="image_profile"></li>
          <li>
            <a class="nav-link" href="#">Welcome <?php echo $_SESSION['user_name']; ?></a>
          </li>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-danger " href="<?php echo URLROOT; ?>/users/logout">Logout</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="btn btn-success mr-3" href="<?php echo URLROOT; ?>/users/register">Register</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-success " href="<?php echo URLROOT; ?>/users/login">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
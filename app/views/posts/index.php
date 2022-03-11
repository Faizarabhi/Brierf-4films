<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
<div class="row mb-3 mt-5">
  <div class="col-md-6">
    <h1>Posts</h1>
  </div>
  <div class="col-md-6">
    <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
      <i class="fa fa-pencil"></i> Add Post
    </a>
  </div>
</div>
<?php foreach ($data['posts'] as $post) : ?>


  <div class="card card-body mb-3 d-flex ">
    <div class="p-2 mb-3 " style="color:#000">
      <div class="h-25 d-inline-block " style="width: 5%"><img class="rounded-circle" src="./img/upload/<?php echo  $post->imageprofile; ?>" alt=""></div>

      <h6>Written by <?php echo $post->name; ?> on <?php echo $post->postCreated; ?></h6>
    </div>
    <h2 class="card-title"><?php echo $post->title; ?></h2>

    <div class=" d-inline-block  align-self-center" style="width: 30%;height:30%"><img src="./img/upload/<?php echo  $post->image; ?>" alt=""></div>



    <p class="card-text"><?php echo $post->body; ?></p>

    <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark" style="background-color:#a80000">More</a>
  </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
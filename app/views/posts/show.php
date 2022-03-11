<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="mt-4 mb-4">

  <a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <br>
  <?php if ($data['post']->user_id == $_SESSION['user_id']) : ?>
    <hr>
    <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit</a>

    <form class="pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">

      <input type="submit" value="Delete" class="btn btn-danger">
    </form>
  <?php endif; ?>
  <div class="card card-body mb-3 d-flex ">
  <div class="h-25 d-inline-block " style="width: 5%">
  <img class="rounded-circle" src="./img/upload/<?php echo  $data['post']->image; ?>" alt="">
</div>

    Written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created_at; ?>

    <h1 class="mt-5"><?php echo $data['post']->title; ?></h1>
    <div class="h-25 d-inline-block " style="width: 50%">image <img src="./img/upload/<?php echo  $data['post']->image; ?>" alt=""></div>

    <p><?php echo $data['post']->body; ?></p>
    <!-- < foreach ($data['comment'] as $comment) : ?> -->
    <!-- if comment  -->
    <?php foreach($data["comments"] as $comment): ?>

    <div class=" bg-light text-dark d-flex align-items-center" style="height :2.7em">
        <img src="./img/upload/<?=$comment->image?>" alt="photo de <?= $comment->name?>">
        <p>name is <?= $comment->name?></p>
        <?= $comment->comment_body?>
    </div>
    <?php endforeach ?>
    <!-- // nullish coalesing -->
   
    <!-- < endforeach;?> -->
  </div>

</div>
<form action="<?php echo URLROOT; ?>/posts/addComment" method="post" >
    <div class="form-group">
      <input type="hidden" name="post_id" value="<?= $data["post"]->id?>">
      <input type="text" name="comment_body" class="form-control form-control-lg ">
    </div>
    
    <input type="submit" class="btn btn-success" value=" Add ">
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>
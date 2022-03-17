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
  <div class="card card-body mb-3 d-flex justify-content-center">
  <div class="h-25 d-inline-block " style="width: 5%">
  <img class="rounded-circle" src="./img/upload/<?php echo  $data['post']->image; ?>" alt="">
</div>

    Written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created_at; ?>

    <h1 class="mt-5 align-self-center"><?php echo $data['post']->title; ?></h1>
    <div class="h-25 d-inline-block align-self-center" style="width: 50%"> <img src="./img/upload/<?php echo  $data['post']->image; ?>" alt=""></div>

    <p class="align-self-center"><?php echo $data['post']->body; ?></p>
    <!-- < foreach ($data['comment'] as $comment) : ?> -->
    <!-- if comment  -->
    <?php foreach($data["comments"] as $comment): ?>

    <div class=" bg-light text-dark h-25  d-flex align-items-center border border-secondary rounded-pill" style="height :2.7em" style="height:9%">
        <img  style="width:9%" class="rounded-circle"src="./img/upload/<?=$comment->image?>" alt="photo de <?= $comment->name?>">
      
        <p class="width:auto text-info" style="margin-bottom: 4rem;">name is <?= $comment->name?></p>
        <div class="" style="    position: absolute;
    left: 13%;"><?= $comment->comment_body?></div>
    </div>
    <?php endforeach ?>
    <!-- // nullish coalesing -->
   
    <!-- < endforeach;?> -->
  </div>

</div>
<form class="d-flex justify-content-around" action="<?php echo URLROOT; ?>/posts/addComment" method="post" >
    <div class="form-group">
      <input type="hidden" name="post_id" value="<?= $data["post"]->id?>">
      <input type="text" name="comment_body" class="form-control form-control-lg ">
    </div>
    
    <input type="submit" class="btn btn-success" value=" Add ">
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php
class Posts extends Controller
{
  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }

    $this->postModel = $this->model('Post');
    $this->userModel = $this->model('User');
  }

  public function index()
  {
    // Get posts
    $posts = $this->postModel->getPosts();

    $data = [
      'posts' => $posts
    ];

    $this->view('posts/index', $data);
  }

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'image' => $_FILES['image']['name'],
        'title_err' => '',
        'body_err' => '',
        'image_err' => ''
      ];
      $image_ex = strtolower(pathinfo($data['image'], PATHINFO_EXTENSION));
      if (empty($data['image'])) {
        $data['image'] = 'Pleae enter image';
      }
      if (
        $image_ex != "jpg" && $image_ex != "png" && $image_ex != "jpeg"
        && $image_ex != "gif"
      ) {
        $data['image_err'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      }
      $new_name = uniqid('IMG-', true) . "." . "$image_ex";
      $data['image'] = $new_name;

      // Validate data
      if (empty($data['title'])) {
        $data['title_err'] = 'Please enter title';
      }
      if (empty($data['body'])) {
        $data['body_err'] = 'Please enter body text';
      }
      if (empty($data['image'])) {
        $data['image_err'] = 'Please enter image file';
      }

      // Make sure no errors
      if (empty($data['title_err']) && empty($data['body_err']) && empty($data['image_err'])) {
        // Validated
        $tmp = $_FILES['image']['tmp_name'];

        $upload = "./img/upload/" . $new_name;
        move_uploaded_file($tmp, $upload);

        if ($this->postModel->addPost($data)) {

          flash('post_message', 'Post Added');
          redirect('posts');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('posts/add', $data);
      }
    } else {
      $data = [
        'title' => '',
        'image' => '',
        'body' => ''
      ];

      $this->view('posts/add', $data);
    }
  }
  public function addComment()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // comment_body, id_user	, id_post
      $data = [
        'comment_body' => trim($_POST['comment_body']),
        'id_user' => $_SESSION['user_id'],
        'id_post' => $_POST['post_id'],
        'comment_body_err' => ''

      ];


      // Validate data
      if (empty($data['comment_body'])) {
        $data['comment_body_err'] = 'Please enter comment_body';
      }

      // Make sure no errors
      if (empty($data['comment_body_err'])) {
        // Validated


        if ($this->postModel->addComment($data)) {

          flash('post_message', 'Comment Added');
          redirect('posts');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('posts/show', $data);
      }
    } else {
      $data = [
        'comment_body' => '',
        'id_user' => '',
        'id_post' => ''
      ];

      $this->view('posts/show', $data);
    }
  }
  

  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'id' =>  $id,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'image' => trim($_FILES['image']['name']),
        'user_id' => $_SESSION['user_id'],
        'title_err' => '',
        'body_err' => '',
        'image_err' => ''
      ];
      $image_ex = strtolower(pathinfo($data['image'], PATHINFO_EXTENSION));
      if (empty($data['image'])) {
        $data['image'] = 'Pleae enter image';
      }
      if (
        $image_ex != "jpg" && $image_ex != "png" && $image_ex != "jpeg"
        && $image_ex != "gif"
      ) {
        $data['image_err'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      }
      $new_name = uniqid('IMG-', true) . "." . "$image_ex";
      $data['image'] = $new_name;

      // Validate data
      if (empty($data['title'])) {
        $data['title_err'] = 'Please enter title';
      }
      if (empty($data['body'])) {
        $data['body_err'] = 'Please enter body text';
      }
      if (empty($data['image'])) {
        $data['image_err'] = 'Please enter image file';
      }

      // Make sure no errors
      if (empty($data['title_err']) && empty($data['body_err']) && empty($data['image_err'])) {
        // Validated
        $tmp = $_FILES['image']['tmp_name'];
        $upload = "./img/upload/" . $new_name;
        move_uploaded_file($tmp, $upload);
        if ($this->postModel->updatePost($data)) {
          flash('post_message', 'Post Updated');
          redirect('posts');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('posts/edit', $data);
      }
    } else {
      // Get existing post from model
      $post = $this->postModel->getPostById($id);

      // Check for owner
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }

      $data = [
        'id' => $id,
        'title' => $post->title,
        'body' => $post->body,
        'image' => $post->image
      ];

      $this->view('posts/edit', $data);
    }
  }
  

  public function show($id)
  {
    $post = $this->postModel->getPostById($id);
    $user = $this->userModel->getUserById($post->user_id);
    $comments = $this->postModel->getCommentByIdpost($id);

    $data = [
      'post'     => $post,
      'user'     => $user,
      'comments'  => $comments
    ];

    $this->view('posts/show', $data);
  }

  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Get existing post from model
      $post = $this->postModel->getPostById($id);

      // Check for owner
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }

      if ($this->postModel->deletePost($id)) {
        flash('post_message', 'Post Removed');
        redirect('posts');
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('posts');
    }
  }
}

<?php
class Post
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function getPosts()
  {
    $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.image as image,
                        users.image as imageprofile,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        
                        ORDER BY posts.created_at DESC
                        ');

    $results = $this->db->resultSet();

    return $results;
  }

  public function addPost($data)
  {
    $this->db->query('INSERT INTO posts (title, user_id, image ,body) VALUES(:title, :user_id,:image, :body)');
    // Bind values
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':user_id', $data['user_id']);
    $this->db->bind(':body', $data['body']);
    $this->db->bind(':image', $data['image']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function addComment($data)
  {
    $this->db->query('INSERT INTO comment ( comment_body, id_user	, id_post) VALUES( :comment_body,	:id_user	, :id_post)');
    // Bind values
    $this->db->bind(':comment_body', $data['comment_body']);
    $this->db->bind(':id_user', $data['id_user']);
    $this->db->bind(':id_post', $data['id_post']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function updatePost($data)
  {
    $this->db->query('UPDATE posts SET title = :title,image = :image, body = :body WHERE id = :id');
    // Bind values
    $this->db->bind(':id', $data['id']);
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':image', $data['image']);
    $this->db->bind(':body', $data['body']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function getPostById($id)
  {
    $this->db->query('SELECT * FROM posts WHERE id = :id');
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }
  public function getCommentByIdpost($idpost)
  {
    $this->db->query('SELECT comment.*,users.* FROM comment 
        INNER JOIN users
        ON comment.id_user = users.id
      WHERE id_post = :id_post ');
    $this->db->bind(':id_post', $idpost);

    $rows = $this->db->resultSet();

    return $rows;
  }
  // public function getPostById($id)
  // {
  //   $this->db->query('SELECT *,
    
  //   posts.image as image,
  //   users.image as imageprofile,
  //   posts.created_at as postCreated,
  //   users.created_at as userCreated
  //   FROM posts
  //   INNER JOIN users
  //   ON posts.user_id = users.id
  //   WHERE id = :id');
  //   $this->db->bind(':id', $id);

  //   $row = $this->db->single();

  //   return $row;
  // }
  public function deletePost($id)
  {
    $this->db->query('DELETE FROM posts WHERE id = :id');
    // Bind values
    $this->db->bind(':id', $id);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}

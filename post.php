<?php
$page_title = "post";
?>


<!DOCTYPE html>
<html lang="en">

<?php
include_once ("includes/header.php");
?>

  <body>

    <!-- Navigation -->
    <?php
        include_once ("includes/navigation.php");
    ?>
    <div class="clearfix"></div>
    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">
            <?php
            include_once ("includes/connection.php");
            if(isset($_GET['post_id'])) {
                $post_id = $_GET['post_id'];
                $query_all_posts = "SELECT * FROM posts WHERE post_id = $post_id";
                $all_posts_results = mysqli_query($connection, $query_all_posts);
                while ($post = mysqli_fetch_assoc($all_posts_results)) {
//                    $post_id = $post['post_id'];
                    $post_title = $post['post_title'];
                    $post_author = $post['post_author'];
                    $post_date = $post['post_date'];
                    $post_content = $post['post_content'];
                    $post_tags = $post['post_tags'];
                    $post_image = $post['post_image'];

                    ?>
                    <!-- Title -->
                    <h1 class="mt-4"><?php echo $post_title?></h1>

                    <!-- Author -->
                    <p class="lead">
                        by
                        <a href="#"><?php echo $post_author?></a>
                    </p>

                    <hr>

                    <!-- Date/Time -->
                    <p><?php echo $post_date ?></p>

                    <hr>

                    <!-- Preview Image -->
                    <img class="img-fluid rounded" src="images/<?php echo $post_image?>" alt="">

                    <hr>

                    <!-- Post Content -->
                    <p class="lead">
                        <?php
                        echo $post_content;
                        ?>
                    </p>

                    <hr>
                    <?php
                        if(isset($_POST['post_comment'])){
                            $comment_author = $_POST['comment_author'];
                            $comment_email = $_POST['comment_email'];
                            $comment_content = $_POST['comment_content'];
                            $comment_date = date("Y-m-d");
                            include_once ("includes/connection.php");
                            $query_insert_comment = "INSERT INTO comments (comment_post_id,comment_author,comment_email,comment_content,comment_date) VALUES ($post_id,'$comment_author','$comment_email','$comment_content','$comment_date')";
                            mysqli_query($connection,$query_insert_comment);
                            if(mysqli_errno($connection)){
                                die("problm in connction".mysqli_error($connection));
                            }
                        }
                    ?>






                    <!-- Comments Form -->
                    <div class="card my-4">
                        <h5 class="card-header">Leave a Comment:</h5>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="comment_author">Your name</label>
                                    <input type="text" name="comment_author" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="comment_email">Your email</label>
                                    <input type="text" name="comment_email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="comment_content">Your comment</label>
                                    <textarea class="form-control" rows="3" name="comment_content"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" name="post_comment">Submit</button>
                            </form>
                        </div>
                    </div>

                    <?php
                    $condition = "comment_post_id = $post_id and comment_status = 'approved'";
                    $comment_resultset = getAllComments($condition);
                    while($comment = mysqli_fetch_assoc($comment_resultset)) {
                        $comment_author = $comment['comment_author'];
                        $comment_date = $comment['comment_date'];
                        $comment_content = $comment['comment_content'];


                        ?>


                        <!-- Single Comment -->
                        <div class="media mb-4">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                            <div class="media-body">
                                <h5 class="mt-0"><?php echo $comment_author ?> <span class="small"> <?php echo $comment_date;?></span></h5>
                                <?php
                                echo $comment_content;
                                ?>
                            </div>
                        </div>


                        <?php
                    }
                }
            }
            ?>
        </div>

        <!-- Sidebar Widgets Column -->
          <?php
          include_once ("includes/sidebar.php");
          ?>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
        <?php
        include_once ("includes/footer.php");
        ?>

    <!-- Bootstrap core JavaScript -->
        <?php
        include_once ("includes/core-scripts.php");
        ?>

  </body>

</html>

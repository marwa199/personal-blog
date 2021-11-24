<?php
  include('include/header.php');
  include('include/connection.php');

?>

      <!-- start content -->

      <div class="container ">
        <div class="row">

          <!-- start left side -->
          <div class="col-8">

            <?php
              $id = $_GET['id'];
              $stmt= $db->prepare("SELECT * FROM posts WHERE id = '$id'");
              $stmt->execute();
              $cols = $stmt-> fetchAll();
              foreach($cols as $col){
              ?>
              <div class="post text-center my-5 bg-light p-5">
                <div class="post-image">
                <img class="w-100" src="uploaded/<?php echo $col['postImage']; ?>" width="500px" height="300px" alt="">
                </div>
                <div class="post-title my-3">
                  <h4><?php echo $col['postTitle']; ?></h4>
                </div>
                <div class="post-content">
                  <p class="info">
                    <span class="px-2"><i class="fas fa-user px-1" ></i><?php echo $col['postAuther']; ?></span>
                    <span class="px-2"><i class="fas fa-calendar-day px-1"></i><?php echo $col['postDate']; ?></span>
                    <span class="px-2"><i class="fas fa-tag px-1"></i><?php echo $col['postCategory']; ?></span>
                  </p>
                  <p> 
                    <?php 
                      echo $col['postContent']; ?>
                  </p>
                </div>
              </div>
              <?php } ?>
          </div>

          <!-- end left side -->


          <!-- start right side -->
            <div class="col-4 d-flex flex-column flex-wrap">

            <div class="py-5 mt-5 ">
                    <h3 class="mx-3 p-3">Latest Articles</h3>
                    <ul class="list-group list-group-flush">
                      <?php
                        $stmt=$db->prepare("SELECT * FROM posts ORDER BY id DESC limit 10");
                        $stmt->execute();
                        $cols = $stmt->fetchAll();
                        foreach($cols as $col){
                      ?>
                        <li class="list-group-item bg-transparent">
                          <a href="article.php?id=<?php echo $col['id']; ?>" class=" btn link-secondary" target="_parent">
                            <span class="float-start"><img src="uploaded/<?php echo $col['postImage']; ?>" alt="" width="80px" height="60px"></span>
                            <span class="align-baseline p-3 "><?php echo $col['postTitle']; ?> </span>
                          </a>
                        </li>
                       <?php }?>
                        </ul>
                </div>


            </div>
          <!-- end right side -->

        </div>
    </div>

    <!-- end content -->

    <?php
      include('include/footer.php');
    ?>
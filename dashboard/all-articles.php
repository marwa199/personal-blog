<?php
  include('../include/dashboard-header.php');
  include('../include/connection.php');

   $id="";
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    if($_SERVER['REQUEST_METHOD']=='GET'){    
      $id=$_GET['id'];
           
        $stmt=$db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->execute(); 
  
    }
  }
  ?>

      <div class="container">
        <div class="row">
            
          <div class="w-75 m-auto mb-5">
                <h4 class="p-2 my-5  text-outline-secondary text-black text-decoration-underline">All Articles</h4>
                <table class="mt-3 table">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">id</th>
                        <th scope="col" class="text-center">name</th>
                        <th scope="col" class="text-center">category</th>
                        <th scope="col" class="text-center">image</th>
                        <th scope="col" class="text-center">auther</th>
                        <th scope="col" class="text-center">publishing date</th>
                        <th scope="col" class="text-center">delete article</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                        $stmt=$db->prepare("SELECT * FROM posts ORDER BY id DESC");
                        $stmt->execute();
                        $cols=$stmt->fetchAll();
                        $no=0;
                        foreach($cols as $col){
                            $no++;
                      ?>

                      <tr>
                        <th  class="text-center"><?php echo $no ?></th>
                        <td  class="text-center"><?php echo $col['postTitle'];  ?></td>
                        <td  class="text-center"><?php echo $col['postCategory'];  ?></td>
                        <td  class="text-center"><img src="../uploaded/<?php echo $col['postImage'];  ?> " width="70px" height="45px"></td>
                        <td  class="text-center"><?php echo $col['postAuther'];  ?></td>
                        <td  class="text-center"><?php echo $col['postDate'];  ?></td>
                        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="GET">
                          <td class="text-center">
                              <a type="button" href="all-articles.php?id=<?php echo $col['id']; ?>" class="btn btn-danger">Delete</a>
                          </td>
                        </form>
                      </tr>

                    <?php } ?>
                    </tbody>
                  </table>
            </div>  

        </div>
    </div>

    <?php
      include('../include/footer.php');
    ?>
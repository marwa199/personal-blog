<?php
  include('../include/dashboard-header.php');
  include('../include/connection.php');

  ?>

      <div class="container">
        <div class="row">

            <div class="w-75 m-auto">
              <form class="mb-5" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
              <h4 class="p-2 mt-5 mb-3 text-outline-secondary text-black text-decoration-underline">New Article</h4>

                <?php
                   if($_SERVER['REQUEST_METHOD'] === 'POST'){

                    $pTitle = $_POST['title'];
                    $pCategory = $_POST['category'];
                    $pContent = $_POST['content'];
                    $pAuthor = $_POST['authorName'];
                
                    $errors = array();
                
                  $imageName = $_FILES['image']['name'];
                  $imageTmp = $_FILES['image']['tmp_name'];
                  $imageType = $_FILES['image']['type'];
                  $imageSize = $_FILES['image']['size'];
                  $imageError = $_FILES['image']['error'];
                
                    $allowed_extentions = array('jpg','png','jpeg','gif','jfif');
                    $image_ext = explode('.' ,  $imageName);
                    $image_exten = end($image_ext);
                    $image_extention = strtolower($image_exten);
                
                    if($imageError === 4){
                      $errors[] = "<div class='alert alert-danger'>" ." no file uploaded " . "</div>";
                    }
                   
                    if(! in_array($image_extention , $allowed_extentions)){
                      $errors[] = "<div class='alert alert-danger'>" . "file is not valid" . "</div>";
                    }
                
                    if(empty($pTitle) || empty($pContent) || empty($pAuthor)){
                      $errors[] = "<div class='alert alert-danger'>" . "this field is required" . "</div>";
                    }
                  
                
                    if(empty($errors) ){
                        $pImage = rand(0,1000)."_". $imageName;
                        move_uploaded_file($imageTmp, $_SERVER['DOCUMENT_ROOT']. '\blog\uploaded\\' . $pImage);
                
                        $stmt=$db->prepare("INSERT INTO posts (postTitle,postCategory,postImage,postContent,postAuther)
                                             VALUES (:a,:b,:c,:d,:e)");
                        $stmt->bindParam(':a',$pTitle);
                        $stmt->bindParam(':b',$pCategory);
                        $stmt->bindParam(':c',$pImage);
                        $stmt->bindParam(':d',$pContent);
                        $stmt->bindParam(':e',$pAuthor);
                
                        $stmt->execute();
                        echo "<div class='alert alert-success'>" . "post added successfully" . "</div>";
                    }
                
                    else{
                        foreach($errors as $error){
                            echo $error;
                        }
                    }
                  }
                ?>

                <div class="mb-3">
                  <label for="formGroupExampleInput" class="form-label">Article Name </label>
                  <div class="text-danger d-inline-block">*</div>
                  <input type="text" name="title" class="form-control" id="formGroupExampleInput">
                </div>
                <div class="mb-3">
                  <label for="formGroupExampleInput2" class="form-label">Category </label>
                  <select id="inputState" name="category" class="form-select">
                  <?php
                              $stmt=$db->prepare("SELECT * FROM categories");
                              $stmt->execute();
                              $cols=$stmt->fetchAll();
                              foreach($cols as $col){
                                ?>
                                <option name=""><?php echo $col['categoryName']; ?></option>
                           <?php } ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="formGroupExampleInput" class="form-label">Article image </label>
                  <div class="text-danger d-inline-block">*</div>
                  <input type="file" class="form-control" name="image"  value="">
                </div>
                <div class="mb-3">
                  <label for="formGroupExampleInput" class="form-label">Article </label>
                  <div class="text-danger d-inline-block">*</div>
                  <textarea class="form-control" name="content" id="floatingTextarea" rows="12"></textarea>
                </div>
                <div class="mb-3">
                  <label for="formGroupExampleInput" class="form-label">Author Name </label>
                  <div class="text-danger d-inline-block">*</div>
                  <input type="text" name="authorName" class="form-control" id="formGroupExampleInput">
                </div>
                <div class="mb-3">
                  <button type="submit" class="btn mb-5 p-3">Publish</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <?php
      include('../include/footer.php');
    ?>
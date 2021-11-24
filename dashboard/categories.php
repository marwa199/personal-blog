<?php
session_start();
  include('../include/dashboard-header.php');
  include('../include/connection.php');

  $stmt=$db->prepare("INSERT INTO categories (categoryName) values (:x) ");
  $stmt->bindParam(":x",$catName);


  $id="";
  if(isset($_SESSION['id'])){
    echo "<div class='alert alert-danger'>" . "this page allowed only for admins" . "</div>";
    header('REFRESH:2;URL=../sign-in.php');               
  }
else{

  if(isset($_GET['id'])){
    $id = $_GET['id'];
  if($_SERVER['REQUEST_METHOD'] == "GET"){
    $id = $_GET['id'];
   
    $stmt3=$db->prepare("DELETE FROM categories WHERE id=:id");
    $stmt3->bindParam(":id",$id);
    $stmt3->execute();
  }
}

?>

      <div class="container">           
            <div class="w-75 m-auto">
                <div class="bg-transparent p-1 mt-2">
                        <form class="mb-5" action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                          <h4 class="p-2 mt-5 mb-3 text-outline-secondary text-black text-decoration-underline">Add New Category</h4>
                            <?php
                            if($_SERVER['REQUEST_METHOD']=='POST'){
                              $catName=$_POST['category'];
                              $addName=$_POST['add'];
                            
                              if(isset($addName)){
                                if(empty($catName)){
                                  echo "<div class='alert alert-danger'>" . "category name is required" . "</div>";
                                }
                                elseif(strlen($catName) > 100){
                                  echo "<div class='alert alert-danger'>" . "category name is too long" . "</div>";
                                }
                                // elseif(errno && errno === 1062){
                                //   echo "this category is already exists";
                                // }
                                else{
                                  $stmt->execute();
                                  echo "<div class='alert alert-success'>" . "category name added successfully" . "</div>";
                                }
                              }
                            }
                            ?>
                            
                          <div class="input-group mb-3 p-1">
                            <input type="text" name="category" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary mx-2" name="add" type="text" id="button-addon2">Add</button>
                            </div>
                          </div> 
                        </form>
                </div>
            
                
                    <table class="my-5 table">
                        <thead>
                          <tr>
                            <th scope="col" class="text-center">category id</th>
                            <th scope="col" class="text-center">category name</th>
                            <th scope="col" class="text-center"> adding date</th>
                            <th scope="col" class="text-center">delete category</th>
                          </tr>
                        </thead>
                        <tbody>

                            <?php
                              $stmt2=$db->prepare("SELECT * FROM categories ORDER BY id DESC");
                              $stmt2->execute();
                              $cols=$stmt2->fetchAll();
                              $no = 0;
                              foreach($cols as $col){
                                $no++;
                                ?>
                          <tr>
                            <th  class="text-center"><?php echo $no ?></th>
                            <td  class="text-center"><?php echo $col['categoryName'] ?></td>
                            <td  class="text-center"><?php echo $col['categoryDate'] ?></td>
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                              <td class="text-center">
                                <a type="button" class="btn btn-danger" href="categories.php?id=<?php echo $col['id']?> ">Delete</a>
                                </td>
                            </form>
                          </tr>

                          <?php
                              }
                              ?>

                        </tbody>
                      </table>
            </div>
        </div>
    </div>
    

    <?php
}
      include('../include/footer.php');
    ?>
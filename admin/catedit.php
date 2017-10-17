<?php
    include_once '../classes/Category.php';
    $cat = new Category();

    include_once 'inc/header.php';
    include_once 'inc/sidebar.php';

    if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
        echo "<script>window.location = 'catlist.php';</script>";
    }else{
        $id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['catid']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $catName = $_POST['catName'];

        $updateCat = $cat->catUpdate($catName, $id);
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update Category</h2>
               <div class="block copyblock">
        <?php 
            if (isset($updateCat)) {
                echo $updateCat;
            }

            $getCat = $cat->getCatById($id);
            if ($getCat) {
                while ($result = $getCat->fetch_assoc()) {
         ?>
                    <form action="" method="post">
                        <table class="form">	
                            <tr>
                                <td>
                                    <input type="text" name="catName" value="<?php echo $result['catName']; ?>" class="medium" />
                                </td>
                            </tr>
    						<tr>
                                <td>
                                    <input type="submit" name="submit" Value="Update" />
                                </td>
                            </tr>
                        </table>
                    </form>
        <?php } }else{
            echo "<span style='color:red;'>Category not found !</span>";
        } ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>
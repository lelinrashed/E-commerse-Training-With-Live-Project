<?php
    include_once '../classes/Product.php';
    $pd = new Product();
    include_once '../classes/Category.php';
    $cat = new Category();
    include_once '../classes/Brand.php';
    $brand = new Brand();

    include_once 'inc/header.php';
    include_once 'inc/sidebar.php';

    if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
        echo "<script>window.location = 'productlist.php';</script>";
    }else{
        $id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['proid']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $updateProduct = $pd->productUpdate($_POST, $_FILES, $id);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Product</h2>
        <div class="block">
        <?php
            if (isset($updateProduct)) {
                echo $updateProduct;
            }
         ?>
         <?php
            $getPro = $pd->getProById($id);
            if ($getPro) {
                while ($value = $getPro->fetch_assoc()) {
          ?>  
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" name="productName" value="<?php echo $value['productName']; ?>" class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Category</label>
                    </td>
                    <td>
                        <select id="select" name="catId">
                            <option>Select Category</option>
                        <?php 
                            
                            $getCat = $cat->getAllCat();
                            if ($getCat) {
                                while ($result = $getCat->fetch_assoc()) {
                         ?>
                            <option <?php 
                                if ($value['catId'] == $result['catId']) { ?>
                                    selected = "selected"
                            <?php  }
                             ?> value="<?php echo $result['catId']; ?>"><?php echo $result['catName']; ?></option>
                        <?php } } ?>
                        </select>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Brand</label>
                    </td>
                    <td>
                        <select id="select" name="brandId">
                            <option>Select Brand</option>
                        <?php 
                            
                            $getBrand = $brand->getAllBrand();
                            if ($getBrand) {
                                while ($result = $getBrand->fetch_assoc()) {
                         ?>
                            <option <?php 
                                if ($value['brandId'] == $result['brandId']) { ?>
                                    selected = "selected"
                            <?php  }
                             ?> value="<?php echo $result['brandId']; ?>"><?php echo $result['brandName']; ?></option>
                        <?php }  } ?>
                        </select>
                    </td>
                </tr>
				
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Description</label>
                    </td>
                    <td>
                        <textarea rows="10" cols="62" name="body">
                            <?php echo $value['body']; ?>
                        </textarea>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Price</label>
                    </td>
                    <td>
                        <input type="text" name="price" value="<?php echo $value['price']; ?>" class="medium" />
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <img height="150px;" width="200px;" src="<?php echo $value['image']; ?>" alt=""></br>
                        <input type="file" name="image" />
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <label>Product Type</label>
                    </td>
                    <td>
                        <select id="select" name="type">
                            <option>Select Type</option>
                        <?php 
                            if ($value['type'] == 0) { ?>
                                <option selected = "selected" value="0">Featured</option>
                                <option value="1">General</option>
                        <?php  }else{
                         ?>
                            <option value="0">Featured</option>
                            <option selected = "selected" value="1">General</option>
                        <?php } ?>
                        </select>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
    <?php }   } ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>



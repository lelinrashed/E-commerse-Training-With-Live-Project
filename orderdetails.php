<?php include_once 'inc/header.php'; ?>
<?php 
	$login = Session::get("Custlogin");
	if ($login == false) {
		header("Location:login.php");
	}
 ?>
<style>
    .tblone tr td{text-align: justify;}
</style>
 <div class="main">
    <div class="content">
    	 	<div class="section group">
    	 		<div class="order">
    	 			<h2>Your order details</h2>
                    <table class="tblone">
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
            <?php 
                $cmrId = Session::get("cmrId");
                $getOrder = $ct->getOrderProduct($cmrId);
                if ($getOrder) {
                    $i = 0;
                    while ($result = $getOrder->fetch_assoc()) {
                        $i++;
             ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $result['productName']; ?></td>
                            <td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
                            <td><?php echo $result['quantity']; ?></td>
                            <td>Tk. <?php 
                                $total = $result['price'] * $result['quantity'];
                                echo $total;
                             ?></td>
                            <td><?php echo $fm->formatDate($result['date']); ?></td>
                            <td><?php 
                                if ($result['status'] == '0') {
                                    echo "Pending";
                                }else{
                                    echo "Shifted";
                                }
                             ?></td>
                            <?php 
                                if ($result['status'] == '1') { ?>
                                    <td><a onclick="return confirm('Are you sure to delete !');" href="">X</a></td>
                            <?php }else{ ?>
                                <td>N/A</td>
                            <?php  } ?>
                            
                        </tr>
            <?php } } ?>
                    </table>
    	 		</div>
    	 	</div>
       <div class="clear"></div>
    </div>
 </div>

 <?php include_once 'inc/footer.php'; ?>
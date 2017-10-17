<?php include_once 'inc/header.php'; ?>
<?php 
	$login = Session::get("Custlogin");
	if ($login == false) {
		header("Location:login.php");
	}
 ?>
<style>
	.psuccess{width: 500px; min-height: 200px;text-align: center;border: 1px solid #ddd; margin: 0 auto;padding: 50px;}
	.psuccess h2{border-bottom: 1px solid $ddd;margin-bottom: 20px; padding-bottom: 10px;}
    .psuccess p {line-height: 25px;text-align: justify;font-size: 18px;}
</style>
<div class="main">
    <div class="content">
    	<div class="section group">
    		<div class="psuccess">
    			<h2 class="success">Success</h2>
        <?php 
            $cmrId = Session::get("cmrId");
            $amount = $ct->payableAmount($cmrId);
            if ($amount) {
                $sum = 0;
                while ($result = $amount->fetch_assoc()) {
                    $price = $result['price'];
                    $sum = $sum + $price;
                }
            }
         ?>
         
                <p style="color:red;">Total payable amount(Including Vat) : 

        <?php 
            $vat = $sum * 0.1;
            $total = $sum + $vat;
            echo $total;
         ?>
                </p>
                <p>Thanks for purchase. Receive Your Order Successfully. We will contact you as soon as possible with delivery details. Here is your details.... <a href="orderdetails.php">Visit here....</a></p>
    		</div>
 		</div>
 	</div>
</div>
<?php include_once 'inc/footer.php'; ?>
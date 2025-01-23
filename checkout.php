<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   if (strlen($number) != 10) {
      // Handle error: number must be exactly 10 digits
      $message[] = 'Mobile Number Must Be Exactly 10 digits';
   }
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart`  WHERE user_id = ?");
   $check_cart->execute([$user_id]);
   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order Placed Successfully!';
   }else{
      $message[] = 'Your Cart Is Empty Shop Now!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>

</head>
<body>
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '₹'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Grand Total : <span>₹<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Enter Your Name:</span>
            <input type="text" name="name"   onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)"placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Your Number :</span>
            <!-- <input type="number" id="mobileNumber" name="mobileNumber" inputmode="numeric" oninput="this.value = this.value.slice(0, 10)" pattern="\d{10}" placeholder="0123456789" required> -->
            <input type="number" name="number" maxlength="10" oninput="this.value = this.value.slice(0, 10)" pattern="\d{10}"  placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>Your Email :</span>
            <input type="email" name="email" id="to" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment Method:</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash On Delivery</option>
               <option value="credit card">Credit Card</option>
               <option value="paytm">Paytm</option>
               <option value="paypal">PayPal</option> 
            </select>
         </div>
         <div class="inputBox">
            <span>Address line 01 :</span>
            <input type="text" name="flat" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode > 48 && event.charCode < 57) || (event.charCode == 32)" placeholder="e.g. Flat number" class="box" maxlength="550" required>
         </div>
         <div class="inputBox">
            <span>Address line 02 :</span>
            <input type="text" name="street" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode > 48 && event.charCode < 57) || (event.charCode == 32)" placeholder="Street name" class="box" maxlength="550" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" placeholder="Ahemdabad" class="box" maxlength="550" required>
         </div>
         <div class="inputBox">
            <span>Province:</span>
            <input type="text" name="state"  onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" placeholder="Sanand Sarkhej Road" class="box" maxlength="550" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country"  onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" placeholder="India" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>ZIP CODE :</span>
            <input type="number" min="0" name="pin_code" placeholder="E.g:-380008" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>
         <div class="placeorder">
      <input type="submit" name="order" id="submittbtn" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">
         </div>
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
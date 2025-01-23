<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script src="script.js"></script>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="heading">ALL Products.</h1>
   
   <!-- Changes For Price Sorting According To Product Price -->
   <section class="minmax">
   <form method="post" action="">
   
<div class="inputs">
   Price-Sorting Products<input type="number" class="box" name="min" placeholder="Enter-Price" value="200" min="200" max="80000" required>
   <input type="number" class="box" name="max" placeholder="Enter-Max-Price" min="200" max="80000" required>
   <button type="submit" class="btns" class="button" name="sort">Sorting</button>
   </div>
   </form>
   </section>



   
   
   <section class="products">

   
   <div class="box-container">

   <?php
    function subString($string){
 
 // strip tags to avoid breaking any html
 $string = strip_tags($string);
 if (strlen($string) > 25) {
 
     // truncate string
     $stringCut = substr($string, 0, 25);
     $endPoint = strrpos($stringCut, ' ');
 
     //if the string doesn't contain any space then it will cut without word basis.
     $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
     $string .= '...';
 }
 
 return $string;
    }
      
      $is_sort = false;
     if(isset($_POST['min']) OR isset($_POST['sort'])){
     $min = $_POST['min'];
     $max = $_POST['max'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE price BETWEEN $min and $max ORDER BY `price`desc"); 
   
     $select_products->execute();
     if($select_products->rowCount() > 0){
      $is_sort = true;
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= subString($fetch_product['name']); ?></div>
      <div class="flex">
         <div class="price"><span>₹</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">No Products Found!</p>';
      }
   }
   ?>

   </div>

</section>
   
   
   
   
  
   
   <!-- Changes For Price Sorting According To Product Price END -->
    <?php
   if(!$is_sort){
?>
   <div class="box-container">
   <?php
      
     $select_products = $conn->prepare("SELECT * FROM `products`"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){

      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= subString($fetch_product['name']); ?></div>
      <div class="flex">
         <div class="price"><span>₹</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products found!</p>';
      
   }
}

   ?>

   </div>

</section>












<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
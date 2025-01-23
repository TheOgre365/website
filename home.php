<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
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
   <title>Playpedia.Com</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <div class="home-bg">

      <section class="home">

         <div class="swiper home-slider">

            <div class="swiper-wrapper">

               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/r-3.png" alt="">
                  </div>
                  <div class="content">
                     <span>Form Playpedia For Free !</span>
                     <h3>Ikigai - The Japanese secret to a long and happy life</h3>
                     <a href="category.php?group=smart phone" class="btn">Shop Now</a>
                  </div>
               </div>

               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/r-2.png" alt="">
                  </div>
                  <div class="content">
                     <span>Form Playpedia For Free !</span>
                     <h3>Never Let Me Go</h3>
                     <a href="category.php?group=Cooling fans" class="btn">Shop Now.</a>
                  </div>
               </div>

               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/r-4.png" alt="">
                  </div>
                  <div class="content">
                     <span>Form Playpedia For Free !</span>
                     <h3>me before you</h3>
                     <a href="category.php?group=headsets" class="btn">Shop Now.</a>
                  </div>
               </div>


               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/r-5.png" alt="">
                  </div>
                  <div class="content">
                     <span>Form Playpedia For Free !</span>
                     <h3>Chanakya Neeti</h3>
                     <a href="category.php?group=finger sleeves" class="btn">Shop Now.</a>

                  </div>
               </div>


               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/r-6.png" alt="">
                  </div>
                  <div class="content">
                     <span>Form Playpedia For Free !</span>
                     <h3>Rich Dad Poor Dad</h3>
                     <a href="category.php?group=triggers" class="btn">Shop Now.</a>

                  </div>
               </div>

            </div>

            <div class="swiper-pagination"></div>

         </div>

      </section>

   </div>

   <section class="category">

      <h1 class="heading">Read by Category</h1>

      <div class="swiper category-slider">

         <div class="swiper-wrapper">

            <a href="category.php?group=gaminglaptop" class="swiper-slide slide">
               <img src="images/ED-book.png" alt="">
               <h3>Educational</h3>
            </a>

            <a href="category.php?group=Gaming keyboards" class="swiper-slide slide">
               <img src="images/th-book.png" alt="">
               <h3>Thriller</h3>
            </a>

            <a href="category.php?group=gaming mouses" class="swiper-slide slide">
               <img src="images/sc-book.png" alt="">
               <h3>Science</h3>
            </a>

            <a href="category.php?group=gaming moniters" class="swiper-slide slide">
               <img src="images/fn-book.png" alt="">
               <h3>Finance</h3>
            </a>

            <a href="category.php?group=headsets" class="swiper-slide slide">
               <img src="images/ph-book.png" alt="">
               <h3>Psychology</h3>
            </a>

            <a href="category.php?group=gaming mics" class="swiper-slide slide">
               <img src="images/ma-book.png" alt="">
               <h3>Manga</h3>
            </a>

            <a href="category.php?group=smartphone5g" class="swiper-slide slide">
               <img src="images/bu-book.png" alt="">
               <h3>Business</h3>
            </a>

            <a href="category.php?group=gaming chairs" class="swiper-slide slide">
               <img src="images/co-book.png" alt="">
               <h3>Comics</h3>
            </a>

         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>

   <!-- Latest Products Contanier -->

   <section class="home-products">

      <h1 class="heading">Latest E-Books</h1>

      <div class="swiper products-slider">

         <div class="swiper-wrapper">

            <?php

            $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 8");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
               while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                  <form action="" method="post" class="swiper-slide slide">
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
            } else {
               echo '<p class="empty">no products added yet!</p>';
            }
            ?>

         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>

   <!-- Best Selling Contanier -->

   <section class="home-products">

      <h1 class="heading">All Time Best Selling E-Books</h1>

      <div class="swiper products-slider">

         <div class="swiper-wrapper">

            <?php
            function subString($string)
            {

               // strip tags to avoid breaking any html
               $string = strip_tags($string);
               if (strlen($string) > 25) {

                  // truncate string
                  $stringCut = substr($string, 0, 25);
                  $endPoint = strrpos($stringCut, ' ');

                  //if the string doesn't contain any space then it will cut without word basis.
                  $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                  $string .= '...';
               }

               return $string;
            }
            $select_products = $conn->prepare("SELECT * FROM `products` order by rand() limit 9;");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
               while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                  <form action="" method="post" class="swiper-slide slide">
                     <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                     <a href="quick_view.php"><input type="hidden" name="name" value="<?= $fetch_product['name']; ?>"></a>
                     <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                     <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                     <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                     <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
                     <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                     <div class="name"><?= subString($fetch_product['name']); ?></div>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                     <div class="flex">
                        <div class="price"><span>₹</span><?= $fetch_product['price']; ?><span>/-</span></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                     </div>
                     <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                  </form>
            <?php
               }
            } else {
               echo '<p class="empty">no products added yet!</p>';
            }
            ?>

         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>


   <div class="game-icon" id="game1"><a href="gamespage.html">
        <img src="images\game.png" alt="Game Icon" />
        <p>Game Title</p></a>
    </div>





   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".home-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
      });

      var swiper = new Swiper(".category-slider", {
         loop: false,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 0,
            },
            650: {
               slidesPerView: 3,
            },
            768: {
               slidesPerView: 4,
            },
            1024: {
               slidesPerView: 5,
            },
         },
      });

      var swiper = new Swiper(".products-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 0,
            },
            550: {
               slidesPerView: 2,
            },
            768: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,

            },
         },
      });
   </script>

</body>

</html>
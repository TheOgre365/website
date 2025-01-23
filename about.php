<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="about">

      <div class="row">

         <div class="image">
            <img src="images/23.png" alt="">
         </div>

         <div class="content">
            <h3>Developer's Message:</h3>
            <p>Hey There ! I'm Akshat Darji. A Student of LJ University in Infromation Technology Department from LJ College [Batch : 2021] . I love designing websites and exploring new things. Learning new things is my hobby.</p>

            <p>I would like to thank <a href="#">MY Faculty</a> for guiding me through the session and making me able to develop projects like this. </p>
            <a href="contact.php" class="btn">Contact Us</a>
         </div>

      </div>

   </section>


   <section class="reviews">

      <h1 class="heading">Client's Reviews.</h1>

      <div class="swiper about-slider">
         <div class="swiper-wrapper">
            <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            if ($select_messages->rowCount() > 0) {
               while ($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)) {
            ?>
                  <div class="swiper-slide slide">
                     <p><?= $fetch_message['message']; ?></p>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                     <h3> <a href="mailto:<?= $fetch_message['email']; ?>" target="_blank"><?= $fetch_message['name']; ?></a></h3>
                  </div>
            <?php
               }
            } else {
               echo '<p class="empty">you have no messages</p>';
            }
            ?>
         </div>
      </div>

   </section>


   <!-- <div class="swiper-pagination"></div> -->


   <?php include ('components/footer.php') ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
      let is_slide = false;
      window.onload = function(){
          let temp  =  document.querySelectorAll('.swiper-slide').length;
         if(temp >= 3){
            is_slide =true;
         }
      }
      var swiper = new Swiper(".about-slider", {
         loop: is_slide,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            768: {
               slidesPerView: 2,
            },
            991: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>
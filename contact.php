<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $userid = $_POST['user_id'];
   $userid = filter_var($user_id, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
 
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages`");
   $select_message->execute();

   if($select_message->rowCount() > 5){
      $message[] = 'Already Sent Message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$userid ,$name, $email, $number, $msg]);

      $message[] = 'Sent Message Successfully!';

    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  
   <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>


</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Get in touch.</h3>
      <input type="hidden" name="user_id">
      <input type="text" name="name" placeholder="Enter Your Name"  onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" required maxlength="20" class="box">
      <input type="email" name="email" id="to" placeholder="Enter Your Email" required maxlength="50" class="box">
      <input type="number" name="number" id="phno" placeholder="Enter Your Phone Number"  required class="box"/>
      <textarea name="msg" class="box" placeholder="Enter Your Comments Or Review." cols="3000" rows="1000"></textarea>
      <input type="submit" id="submittbtn" value="send message" name="send" class="btn">
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<script>
   $(document).ready(function(){

      $('#submittbtn').click(function(e){
       var phno =  $('#phno').val();
       if(phno.length == 10){
 
         $('#submittbtn').submit();
       }
       else{
         e.preventDefault();
          alert("Please Enter Only 10 Digits")
         
       }
      })

   })
</script>

</body>
</html>
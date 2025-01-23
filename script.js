let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

let mainImage = document.querySelector('.quick-view .box .row .image-container .main-image img');
let subImages = document.querySelectorAll('.quick-view .box .row .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});

function alpha(e) {
   var k;
   document.all ? k = e.keyCode : k = e.which;
   return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}

$(document).ready(function() {
   $('#submittbtn').click(function(e) {

   if(!validateEmail()){
   e.preventDefault();
   alert('Check Your Email-ID It Is Not Valid');
   }
   });
   
   $('#to').blur(function() {
   validateEmail();
   });
   $('#email-error').remove();
   function validateEmail() {
   $('#to').removeClass('border');
   $('#to').removeClass('border-danger');
   var email = $('#to').val();
   var domain = email.split("@");
   $('#email-error').text('');
   if (email === '') {
   $("<span/>", {
   id: "email-error",
   text: 'You Must Provide An Correct Email',
   class: 'text-danger d-block mt-1'
   }).insertAfter("#to");
   $('#to').addClass('border border-danger');
   return false;
   }
   if (!validateEmailFormat(email)) {
   $("<span/>", {
   id: "email-error",
   text: 'Check Your Email-ID It Is Not Valid',
   class: 'text-danger d-block mt-1'
   }).insertAfter("#to");
   $('#to').addClass('border border-danger');
   return false;
   }
   
   $('#email-error').text('');
   return true;
   }
   
   function validateEmailFormat(email) {
   var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
   return regex.test(email);
   }
   });

   $(".textbox").keypress(function (e) {
      let myArray = [];
      for (i = 48; i < 58; i++) myArray.push(i);
      if (!(myArray.indexOf(e.which) >= 0)) e.preventDefault();
  });
  $("form").submit(function (e) {
      if ($(".textbox").val().length === 10) {
          alert("Submitted successfully!");
      } else {
          e.preventDefault();
          alert("Enter Ten numbers");
      }
  });
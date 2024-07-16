<?php
session_start(); // Bắt đầu phiên làm việc

@include 'config.php';

if(isset($_SESSION['message'])){
   echo '<div class="message flex items-center justify-between bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
         <span>'.$_SESSION['message'].'</span>
         <i class="fas fa-times cursor-pointer" onclick="this.parentElement.style.display = `none`;"></i>
         </div>';
   unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <link rel="stylesheet" href="dist/styles.css">
    <title>JokerFace Home</title>
</head>
<body>
<?php



?>
<?php include 'header1.php'; ?>
    <section class="px-6 md:px-20 py-24 border-2 border-red-500">
        <div class="flex max-xl:flex-col ">   
            </div>
    <?php include_once('../ass/components/HeroCarousel.php'); ?>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-5 pb-7">
    <?php include 'product1.php'; ?>
    
 
</section>
<footer class="bg-gray-900 text-white py-8 pt-5">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <div class="mb-4 md:mb-0">
            <h2 class="text-lg font-semibold">Thông tin liên hệ</h2>
            <p class="mt-2">123 Đường ABC, Phường XYZ, Quận ABC, Thành phố XYZ</p>
            <p>Điện thoại: 0123 456 789</p>
            <p>Email: example@example.com</p>
        </div>
        <div class="flex items-center">
            <a href="#" class="text-white hover:text-gray-300 mr-4">
                <i class="fab fa-facebook-square text-xl"></i>
            </a>
            <a href="#" class="text-white hover:text-gray-300 mr-4">
                <i class="fab fa-twitter-square text-xl"></i>
            </a>
            <a href="#" class="text-white hover:text-gray-300">
                <i class="fab fa-instagram-square text-xl"></i>
            </a>
        </div>
    </div>
</footer>

</body>
</html>

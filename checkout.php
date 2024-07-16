<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
  
   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   $product_names = [];
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name = $product_item['name'] .' ('. $product_item['quantity'] .')';
         $product_names[] = $product_name;
         $product_price = $product_item['price'] * $product_item['quantity'];
         $price_total += $product_price;
      }
   }

   $total_product = implode('<br>', $product_names);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, city, state, country, total_products, total_price) VALUES('$name','$number','$email','$city','$state','$country','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
      // Xóa giỏ hàng sau khi đã hoàn tất đơn hàng
      mysqli_query($conn, "DELETE FROM `cart`");

      echo "
      <div class='order-message-container flex items-center justify-center min-h-screen'>
      <div class='message-container bg-white p-6 rounded-lg shadow-lg'>
         <h3 class='text-xl font-semibold mb-4'>Thank you for shopping!</h3>
         <div class='order-detail mb-4'>
            <span class='block mb-2'>".$total_product."</span>
            <span class='total block text-lg font-bold'>Total: $".$price_total."</span>
         </div>
         <div class='customer-details mb-4'>
            <p class='mb-1'>Your name: <span class='font-semibold'>".$name."</span></p>
            <p class='mb-1'>Your number: <span class='font-semibold'>".$number."</span></p>
            <p class='mb-1'>Your email: <span class='font-semibold'>".$email."</span></p>
            <p class='mb-1'>Your address: <span class='font-semibold'>".$city.", ".$country."</span></p>
         </div>
         <a href='index.php' class='btn bg-blue-500 text-white py-2 px-4 rounded-md'>Continue shopping</a>
      </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Tailwind CSS CDN link -->
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

<?php include 'header1.php'; ?>

<div class="container mx-auto mt-10">

<section class="checkout-form bg-white p-8 rounded-lg shadow-lg">

   <h1 class="heading text-3xl font-bold mb-8 text-center">Complete your order</h1>

   <form action="" method="post">

   <div class="display-order mb-8">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total = $total += $total_price;
      ?>
      <div class="flex items-center mb-4">
         <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="<?= $fetch_cart['name']; ?>" class="w-16 h-16 object-cover rounded mr-4">
         <span class="block"><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity']; ?>)</span>
      </div>
      <?php
         }
      } else {
         echo "<div class='display-order'><span>Your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total text-xl font-bold">Total: $<?= number_format($grand_total); ?></span>
   </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
         <div class="inputBox">
            <label for="name" class="block mb-2">Your Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" class="w-full p-2 border border-gray-300 rounded-md" required>
         </div>
         <div class="inputBox">
            <label for="number" class="block mb-2">Your Number</label>
            <input type="number" id="number" name="number" placeholder="Enter your number" class="w-full p-2 border border-gray-300 rounded-md" required>
         </div>
         <div class="inputBox">
            <label for="email" class="block mb-2">Your Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" class="w-full p-2 border border-gray-300 rounded-md" required>
         </div>
         <div class="inputBox">
            <label for="city" class="block mb-2">City</label>
            <input type="text" id="city" name="city" placeholder="e.g. ĐN" class="w-full p-2 border border-gray-300 rounded-md" required>
         </div>
         <div class="inputBox">
            <label for="state" class="block mb-2">State</label>
            <input type="text" id="state" name="state" placeholder="Enter your state" class="w-full p-2 border border-gray-300 rounded-md" required>
         </div>
         <div class="inputBox">
            <label for="country" class="block mb-2">Country</label>
            <input type="text" id="country" name="country" placeholder="e.g. VN" class="w-full p-2 border border-gray-300 rounded-md" required>
         </div>
      </div>
      <input type="submit" value="Order Now" name="order_btn" class="btn bg-blue-500 text-white py-2 px-4 rounded-md mt-6 cursor-pointer">
   </form>

</section>

</div>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>

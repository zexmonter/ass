<?php
@include 'config.php';

if(isset($_POST['add_to_cart'])){
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_description = $_POST['product_description'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");

   if(mysqli_num_rows($select_cart) > 0){
      $_SESSION['message'] = 'product already added to cart';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity, description) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity', '$product_description')");
      $_SESSION['message'] = 'product added to cart successfully';
   }

   header('location: index.php'); // Chuyển hướng tới index.php
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Tailwind CSS CDN Link -->
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans">

<div class="container mx-auto bg-zinc-900 text-white p-4">
   <div class="text-center mb-8">
      <h2 class="text-xl font-bold">Lọc Theo Truyện Và Nhân Vật</h2>
      <div class="flex justify-center space-x-4 mt-4">
         <a href="#" class="text-blue-400">One Piece (10)</a>
         <a href="#" class="text-blue-400">Naruto (8)</a>
         <a href="#" class="text-blue-400">Dragon Ball (5)</a>
         <a href="#" class="text-blue-400">Attack on Titan (6)</a>
         <a href="#" class="text-blue-400">My Hero Academia (4)</a>
      </div>
   </div>

   <div class="mb-8">
      <h2 class="text-xl font-bold text-center mb-4 text-black">Sản Phẩm</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_product = mysqli_fetch_assoc($select_products)){
         ?>
         <div class="w-max bg-gray-100 rounded-md p-6">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="Product" class="w-full h-64 object-cover mb-2">
            <p class="text-sm text-black"><?php echo $fetch_product['name']; ?></p>
            <p class="text-sm text-black">Giá: <?php echo $fetch_product['price']; ?> VND</p>
            <form action="" method="post"> 
               <input type="hidden" name="product_name"  class="text-black" value="<?php echo $fetch_product['name']; ?>">
               <input type="hidden" name="product_price" class="text-black" value="<?php echo $fetch_product['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
               <input type="submit" class="bg-blue-500 text-white py-1 px-2 mt-2 w-full cursor-pointer" value="Chi tiết và giá" name="add_to_cart">
            </form>
         </div>
         <?php
            }
         }
         ?>
      </div>
   </div>

   <div class="mb-8 w-max  ">
      <img src="assets/images/banner__1.webp" alt="Advertisement" class="w-full h-24 object-cover">
   </div>

   <div>
      <h2 class="text-xl font-bold text-center mb-4 text-black">Sản Phẩm Pre-Order</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_product = mysqli_fetch_assoc($select_products)){
         ?>
         <div class="w-max bg-gray-100 rounded-md p-6">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="Pre-Order" class="w-full h-64 object-cover mb-2">
            <p class="text-sm text-black"><?php echo $fetch_product['name']; ?></p>
            <p class="text-sm text-black">Giá: <?php echo $fetch_product['price']; ?> VND</p>
            <form action="" method="post">
               <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
               <input type="submit" class="bg-blue-500 text-white py-1 px-2 mt-2 w-full cursor-pointer" value="Chi tiết và giá" name="add_to_cart">
            </form>
         </div>
         <?php
            }
         }
         ?>
      </div>
   </div>
</div>
</body>
</html>

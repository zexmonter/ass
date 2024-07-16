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

   header('location: index.php'); 
   exit();
}
?>
<?php include 'header1.php'; ?>
    <section class="px-6 md:px-20 py-24 border-2 border-red-500">
        <div class="flex max-xl:flex-col ">   
            </div>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Tailwind CSS CDN link -->
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans">

<div class="container mx-auto">

<section class="products">

   <h1 class="heading text-center text-5xl uppercase text-black mb-8">Sản phẩm</h1>

   <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <div class="bg-gray-100 rounded-md p-6">
         <a href="product_view.php?id=<?php echo $fetch_product['id']; ?>">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="w-full">
            <h3 class="text-xl font-semibold mt-4"><?php echo $fetch_product['name']; ?></h3>
            <div class="text-lg font-semibold"><?php echo $fetch_product['price']; ?>$</div>
           
         </a>
         <form action="" method="post">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn bg-blue-500 text-white font-semibold py-2 px-4 rounded-md mt-4 cursor-pointer" value="thêm vào giỏ hàng" name="add_to_cart">
         </form>
      </div>

      <?php
         };
      };
      ?>

   </div>
</section>

</div>
</body>
</html>

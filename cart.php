<?php

@include 'config.php';

if (isset($_POST['update_update_btn'])) {
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if ($update_quantity_query) {
      header('location:cart.php');
   }
}

if (isset($_GET['remove'])) {
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Tailwind CSS -->
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header1.php'; ?>

<div class="container mx-auto py-8">

<section class="shopping-cart bg-white p-6 rounded-lg shadow-lg">

   <h1 class="text-3xl font-semibold mb-6">Shopping Cart</h1>

   <table class="w-full border-collapse">

      <thead class="bg-gray-100">
         <tr>
            <th class="border p-3">Ảnh</th>
            <th class="border p-3">Tên sản phẩm</th>
            <th class="border p-3">Giá</th>
            <th class="border p-3">Số lượng</th>
            <th class="border p-3">Tổng</th>
            <th class="border p-3">Hành động</th>
         </tr>
      </thead>

      <tbody>

         <?php 
         
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $grand_total = 0;
         if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
               $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
         ?>

         <tr class="border-b">
            <td class="p-3"><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" class="w-24 h-24 object-cover" alt=""></td>
            <td class="p-3"><?php echo $fetch_cart['name']; ?></td>
            <td class="p-3">$<?php echo number_format($fetch_cart['price']); ?>/-</td>
            <td class="p-3">
               <form action="" method="post" class="flex items-center">
                  <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>" class="w-16 border text-center">
                  <input type="submit" value="Cập nhật" name="update_update_btn" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded cursor-pointer">
               </form>   
            </td>
            <td class="p-3">$<?php echo number_format($sub_total); ?>/-</td>
            <td class="p-3">
               <a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Bạn có muốn xóa sản phẩm này không?')" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded cursor-pointer"> <i class="fas fa-trash"></i> Xóa</a>
            </td>
         </tr>
         <?php
            $grand_total += $sub_total;  
            }
         } else {
            echo "<tr><td colspan='6' class='text-center py-4'>Giỏ hàng trống.</td></tr>";
         }
         ?>
         <tr class="table-bottom">
            <td class="p-3"><a href="products.php" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded inline-block">Tiếp tục mua hàng</a></td>
            <td colspan="3" class="p-3 text-right font-semibold">Tổng</td>
            <td class="p-3">$<?php echo number_format($grand_total); ?>/-</td>
            <td class="p-3">
               <a href="cart.php?delete_all" onclick="return confirm('Bạn có chắc chắn muốn xóa tất cả không?');" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded inline-block"> <i class="fas fa-trash"></i> Xóa tất cả </a>
            </td>
         </tr>

      </tbody>

   </table>

   <div class="text-right mt-6">
      <a href="checkout.php" class="btn bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded <?= ($grand_total > 1) ? '' : 'opacity-50 cursor-not-allowed'; ?>">Mua hàng</a>
   </div>

</section>

</div>
   
<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>

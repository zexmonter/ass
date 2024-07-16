<?php

@include 'config.php';

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `order` WHERE id = $delete_id") or die('query failed');
   if($delete_query){
      header('location:user.php');
      $message[] = 'Product has been deleted';
   }else{
      header('location:user.php');
      $message[] = 'Product could not be deleted';
   };
};

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_dia_chi = $_POST['update_p_dia_chi'];
   $update_p_email = $_POST['update_p_email'];
   $update_p_sdt = $_POST['update_p_sdt'];
   $update_p_state = $_POST['update_p_state'];
   
   $update_query = mysqli_query($conn, "UPDATE `order` SET name = '$update_p_name', country = '$update_p_dia_chi', state = '$update_p_state', email = '$update_p_email' WHERE id = '$update_p_id'");

   if($update_query){
      $message[] = 'Product updated successfully';
      header('location:user.php');
   }else{
      $message[] = 'Product could not be updated';
      header('location:user.php');
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Tailwind CSS CDN link -->
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<?php

if(isset($message)){
   foreach($message as $msg){
      echo '<div class="message bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert"><span class="block sm:inline">'.$msg.'</span> <i class="fas fa-times cursor-pointer" onclick="this.parentElement.style.display = `none`; return false;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>

<div class="container mx-auto mt-10">

<section class="display-product-table">

   <table class="min-w-full bg-white">

      <thead>
         <tr>
            <th class="py-2">Tên khách hàng</th>
            <th class="py-2">Địa chỉ</th>
            <th class="py-2">Số điện thoại</th>
            <th class="py-2">Email</th>
            <th class="py-2">Ngày sinh</th>
            <th class="py-2">Action</th>
         </tr>
      </thead>

      <tbody>
         <?php
            $select_order = mysqli_query($conn, "SELECT * FROM `order`");
            if(mysqli_num_rows($select_order) > 0){
               while($row = mysqli_fetch_assoc($select_order)){
         ?>

         <tr class="border-b">
            <td class="py-2 px-4"><?php echo $row['name']; ?></td>
            <td class="py-2 px-4"><?php echo $row['country']; ?></td>
            <td class="py-2 px-4"><?php echo $row['number']; ?></td>
            <td class="py-2 px-4"><?php echo $row['email']; ?></td>
            <td class="py-2 px-4"><?php echo $row['state']; ?></td>
            <td class="py-2 px-4 flex space-x-2">
               <a href="user.php?delete=<?php echo $row['id']; ?>" class="delete-btn bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('Are you sure you want to delete this?');"> <i class="fas fa-trash"></i> Xóa </a>
               <a href="user.php?edit=<?php echo $row['id']; ?>" class="option-btn bg-blue-500 text-white px-3 py-1 rounded"> <i class="fas fa-edit"></i> Cập nhật </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty text-center py-6'>No product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">

   <?php
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `order` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <div class="mb-4">
         <label for="update_p_name" class="block mb-2">Tên khách hàng</label>
         <input type="text" id="update_p_name" name="update_p_name" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $fetch_edit['name']; ?>" required>
      </div>
      <div class="mb-4">
         <label for="update_p_dia_chi" class="block mb-2">Địa chỉ</label>
         <input type="text" id="update_p_dia_chi" name="update_p_dia_chi" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $fetch_edit['country']; ?>" required>
      </div>
      <div class="mb-4">
         <label for="update_p_sdt" class="block mb-2">Số điện thoại</label>
         <input type="number" id="update_p_sdt" name="update_p_sdt" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $fetch_edit['number']; ?>" required>
      </div>
      <div class="mb-4">
         <label for="update_p_email" class="block mb-2">Email</label>
         <input type="email" id="update_p_email" name="update_p_email" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $fetch_edit['email']; ?>" required>
      </div>
      <div class="mb-4">
         <label for="update_p_state" class="block mb-2">Ngày sinh</label>
         <input type="text" id="update_p_state" name="update_p_state" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $fetch_edit['state']; ?>" required>
      </div>
      <div class="flex space-x-2">
         <input type="submit" value="Cập nhật khách hàng" name="update_product" class="bg-blue-500 text-white py-2 px-4 rounded-md cursor-pointer">
         <input type="reset" value="Cancel" id="close-edit" class="bg-gray-500 text-white py-2 px-4 rounded-md cursor-pointer" onclick="document.querySelector('.edit-form-container').style.display = 'none';">
      </div>
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>

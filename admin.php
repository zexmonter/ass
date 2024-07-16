<?php

@include 'config.php';

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_description = $_POST['p_description'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image, description) VALUES('$p_name', '$p_price', '$p_image','$p_description')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product add succesfully';
   }else{
      $message[] = 'could not add the product';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:admin.php');
      $message[] = 'product has been deleted';
   }else{
      header('location:admin.php');
      $message[] = 'product could not be deleted';
   };
};

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_description = $_POST['update_p_description'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image', description = '$update_p_description' WHERE id = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated succesfully';
      header('location:admin.php');
   }else{
      $message[] = 'product could not be updated';
      header('location:admin.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible"="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Tailwind CSS -->
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

   <style>
      .edit-form-container {
         display: none;
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(0, 0, 0, 0.5);
         justify-content: center;
         align-items: center;
      }
      .description {
  max-width: 200px; /* Adjust the max-width as needed */
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}


   </style>
</head>
<body>
   
<?php
@include 'config.php';

if (isset($message)) {
   foreach ($message as $message) {
      echo '<div class="message flex items-center justify-between bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative"><span>' . $message . '</span> <i class="fas fa-times cursor-pointer" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   }
}
?>

<?php include 'header.php'; ?>

<div class="container mx-auto py-8">

   <section class="text-center mb-8">
      <form action="" method="post" class="add-product-form mx-auto bg-gray-100 p-8 rounded shadow-md w-full max-w-lg" enctype="multipart/form-data">
         <h3 class="text-2xl mb-4">Thêm sản phẩm mới</h3>
         <input type="text" name="p_name" placeholder="Enter the product name" class="box p-4 mb-4 w-full border" required>
         <input type="text" name="p_description" placeholder="Mô tả sản phẩm" class="box p-4 mb-4 w-full border overflow-hidden" required>

         <input type="number" name="p_price" min="0" placeholder="Enter the product price" class="box p-4 mb-4 w-full border" required>
         <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box p-4 mb-4 w-full border" required>
         <input type="submit" value="Thêm sản phẩm" name="add_product" class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
      </form>
   </section>

   <section class="display-product-table">

      <table class="w-3/4 mx-auto bg-white shadow-md rounded-lg overflow-hidden">
         <thead class="bg-gray-800 text-white">
            <tr>
               <th class="p-3 text-left w-1/5">Ảnh sản phẩm</th>
               <th class="p-3 text-left w-1/3">Tên sản phẩm</th>
               <th class="p-3 text-left w-1/6">Giá</th>
               <th class="p-3 text-left w-1/6  ">Mô tả </th>
               <th class="p-3 text-left w-1/5">Hành động</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if (mysqli_num_rows($select_products) > 0) {
               while ($row = mysqli_fetch_assoc($select_products)) {
                  ?>
                  <tr class="border-b ">
                     <td class="w-16 h-16 p-3"><img src="uploaded_img/<?php echo $row['image']; ?>" class="w-16 h-16 object-cover" alt=""></td>
                     <td class="p-3"><?php echo $row['name']; ?></td>
                     <td class="p-3">$<?php echo $row['price']; ?>/-</td>
                     <td class="p-3  description"><?php echo $row['description']; ?></td>
                     <td class="p-3 flex gap-4">
    <form action="admin.php?delete=<?php echo $row['id']; ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
        <button type="submit" class="delete-btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
            <i class="fas fa-trash"></i> Xóa
        </button>
    </form>
    <button onclick="openEditForm('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['price']; ?>')" class="option-btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
        <i class="fas fa-edit"></i> Sửa
    </button>
</td>

                  </tr>
                  <?php
               }
            } else {
               echo "<tr><td colspan='4' class='empty p-3 text-center bg-gray-200'>Không có sản phẩm nào.</td></tr>";
            }
            ?>
         </tbody>
      </table>

   </section>

   <section class="edit-form-container flex">
      <div class="bg-white p-8 rounded shadow-md w-full max-w-lg">
         <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" id="update_p_id">
            <div class="mb-4">
               <label for="update_p_name" class="block text-gray-700">Tên sản phẩm</label>
               <input type="text" class="box p-4 mb-4 w-full border" required name="update_p_name" id="update_p_name">
            </div>
            <div class="mb-4">
               <label for="update_p_price" class="block text-gray-700">Giá sản phẩm</label>
               <input type="number" min="0" class="box p-4 mb-4 w-full border" required name="update_p_price" id="update_p_price">
            </div>
            <div class="mb-4">
   <label for="update_p_description" class="block text-gray-700 ">Mô tả</label>
   <input type="text" class="box p-4 mb-4 w-full border" required name="update_p_description" id="update_p_description">
</div>
            <div class="mb-4">
               <label for="update_p_image" class="block text-gray-700">Hình ảnh sản phẩm</label>
               <input type="file" class="box p-4 mb-4 w-full border" required name="update_p_image" id="update_p_image" accept="image/png, image/jpg, image/jpeg">
            </div>
            <input type="submit" value="Cập nhật sản phẩm" name="update_product" class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
            <button type="button" onclick="closeEditForm()" class="option-btn bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Hủy</button>
         </form>
      </div>
   </section>

</div>

<!-- custom js file link -->
<script>
   function openEditForm(id, name, price,description) {
      document.getElementById('update_p_id').value = id;
      document.getElementById('update_p_name').value = name;
      document.getElementById('update_p_price').value = price;
      document.getElementById('update_p_description').value = description;
      document.querySelector('.edit-form-container').style.display = 'flex';
   }

   function closeEditForm() {
      document.querySelector('.edit-form-container').style.display = 'none';
   }
</script>

</body>
</html>

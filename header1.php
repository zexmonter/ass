<!-- Ensure the database connection is established before this code -->

<header class="w-full bg-white shadow-md">
    <nav class="flex items-center justify-between px-6 py-4 md:px-20">
        <a href="index.php" class="flex items-center gap-1 no-underline">
            <img src="assets/icons/logo.svg" width="27" height="27" alt="logo">
            <p class="text-lg font-semibold text-gray-800">
                Joker<span class="text-primary">Face</span>
            </p>
        </a>

        <!-- Navigation Icons -->
        <div class="flex items-center gap-5 text-2xl ">
        <a href="index.php"> Trang chủ </a>
         <a href="products.php">xem  sản phẩm</a>
         <a href="lienhe.php">Liên hệ</a>
         <a href="user.php"></a>
            <?php
                // Example of using mysqli_num_rows to count rows
                $select_rows = mysqli_query($conn, "SELECT * FROM `cart`");
                $row_count = mysqli_num_rows($select_rows);
            ?>
            <div class="relative">
                <a href="cart.php" class="flex items-center">
                    <img src="assets/icons/cart.svg" width="27" height="27" alt="cart">
                    <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                        <?php echo $row_count; ?>
                    </span>
                </a>
            </div>
            <a href="login_form.php">
                <img src="assets/icons/login.png" width="27" height="27" alt="login">
            </a>
        </div>
    </nav>
</header>

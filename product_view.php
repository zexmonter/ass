<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "shop_db");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy chi tiết sản phẩm theo ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id === 0) {
    die("ID sản phẩm là bắt buộc. Vui lòng kiểm tra URL của bạn.");
}

$product_query = $conn->prepare("SELECT * FROM products WHERE id = ?");
$product_query->bind_param("i", $product_id);
$product_query->execute();
$product_result = $product_query->get_result();

if ($product_result->num_rows === 0) {
    header('Location: index.php');
    exit();
}

$product = $product_result->fetch_assoc();

// Lấy các sản phẩm tương tự
$similar_products_query = $conn->prepare("SELECT * FROM products WHERE id != ? LIMIT 4");
$similar_products_query->bind_param("i", $product_id);
$similar_products_query->execute();
$similar_products_result = $similar_products_query->get_result();
$similar_products = $similar_products_result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['add_to_cart'])) {
    $product_name = htmlspecialchars($_POST['product_name']);
    $product_price = htmlspecialchars($_POST['product_price']);
    $product_image = htmlspecialchars($_POST['product_image']);
   
    $product_quantity = 1;

    $select_cart = $conn->prepare("SELECT * FROM cart WHERE name = ?");
    $select_cart->bind_param("s", $product_name);
    $select_cart->execute();
    $cart_result = $select_cart->get_result();

    if ($cart_result->num_rows > 0) {
        echo "<script>alert('Product is already in the cart');</script>";
    } else {
        $insert_product = $conn->prepare("INSERT INTO cart (name, price, image, quantity) VALUES (?, ?, ?, ?)");
        $insert_product->bind_param("sssi", $product_name, $product_price, $product_image, $product_quantity);
        $insert_product->execute();
        echo "<script>alert('Product added to cart');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="dist/styles.css">
    <style>
      .product-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem;
  border-radius: 10px;
  background-color: #f9f9f9;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.product-card:hover {
  transform: translateY(-5px);
}

.product-card_img-container {
  width: 200px;
  height: 200px;
  overflow: hidden;
  border-radius: 10px;
}

.product-card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-title {
  font-size: 1.2rem;
  font-weight: bold;
  margin-top: 0.5rem;
  
}

.product-price {
  font-size: 1rem;
  color: #333;
}

.product-category {
  font-size: 0.8rem;
  color: #666;
}
    </style>
  </head>
  <body>
  <?php include 'header.php'; ?>
    <div class="container mx-auto p-4">
      <div class="flex flex-col lg:flex-row">
        <div class="w-full lg:w-1/2 p-4">
          <div class="border rounded-md p-2">
            <img src="uploaded_img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="600" height="600" class="w-full mb-2">
          </div>

        </div>

        <div class="w-full lg:w-1/2 p-4">
          <h1 class="text-2xl font-bold mb-2">
            <?= htmlspecialchars($product['name']) ?>
          </h1>
          <div class="flex items-center mb-4">
            <button class="bg-zinc-200 p-2 rounded-full mr-2">
              <img
                src="https://placehold.co/24x24"
                alt="Heart Icon"
                aria-hidden="true"
              />
            </button>
            <button class="bg-zinc-200 p-2 rounded-full mr-2">
              <img
                src="https://placehold.co/24x24"
                alt="Bookmark Icon"
                aria-hidden="true"
              />
            </button>
            <button class="bg-zinc-200 p-2 rounded-full">
              <img
                src="https://placehold.co/24x24"
                alt="Share Icon"
                aria-hidden="true"
              />
            </button>
          </div>
          <div class="text-3xl font-bold text-red-500 mb-2"><?= number_format($product['price']) ?>₫</div>
          <div class="flex items-center mb-4">
            <span class="text-yellow-500 mr-2">⭐ 25</span>
            <span class="text-zinc-500">(100 Reviews)</span>
          </div>
          <p class="text-zinc-500 mb-4">
            93% of buyers have commented on this (source: trust me bro)
          </p>
          <div class="grid grid-cols-2 gap-2 mb-4">
            <div class="border p-2 rounded-md text-center">
              <p class="text-zinc-500">Giá gốc</p>
              <p class="text-xl font-bold"><?= number_format($product['price']) ?>$</p>
            </div>
            <div class="border p-2 rounded-md text-center">
              <p class="text-zinc-500">Giá TB</p>
              <p class="text-xl font-bold"><?= number_format($product['price']) ?>$</p>
            </div>
            <div class="border p-2 rounded-md text-center">
              <p class="text-zinc-500">Giá tăng</p>
              <p class="text-xl font-bold text-red-500"><?= number_format($product['price']) ?>$</p>
            </div>
            <div class="border p-2 rounded-md text-center">
              <p class="text-zinc-500">Giá giảm</p>
              <p class="text-xl font-bold text-green-500"><?= number_format($product['price']) ?>$</p>
            </div>
          </div>
          <button class="bg-black text-white py-2 px-4 rounded-md w-full">
            Thêm vào giỏ hàng
          </button>
        </div>
      </div>

      <div class="mt-8">
        <h2 class="text-xl font-bold mb-2">Mô tả sản phẩm</h2>
        <p class="mb-4">
            <div class="flex flex-col gap-4 text-lg">
                <?php foreach (explode("\n", $product['description']) as $line): ?>
                    <p><?= htmlspecialchars($line) ?></p>
                <?php endforeach; ?>
            </div>
        </p>
      </div>
    </div>

<?php if (!empty($similar_products)): ?>
    <div class="p-20 flex flex-col gap-5 w-full mb-20">
        <p class="text-2xl text-secondary font-semibold">Sản phẩm tương tự</p>
   
        <div class="flex flex-wrap gap-10 mt-7 w-full">
            <?php foreach ($similar_products as $similar_product): ?>
                <div class="flex flex-col">
                    <div class="product-card_img-container">
                        <img class="product-card-img " src="uploaded_img/<?= htmlspecialchars($similar_product['image']) ?>" alt="<?= htmlspecialchars($similar_product['name']) ?>">
                    </div>
                    <div class="flex flex-col gap-3  ">
                        <p><?= htmlspecialchars($similar_product['name']) ?></p>
                        <p><?= number_format($similar_product['price']) ?> VND</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

</body>
</html>

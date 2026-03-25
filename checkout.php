```php
<?php
session_start();
include("config.php");
include("includes/header.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

/* 🔐 LOGIN CHECK */
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])){
    echo "<script>
            alert('Please login first');
            window.location='customer/login.php';
          </script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

/* 🛒 CART CHECK */
if(empty($_SESSION['cart'])) {
    echo "<h3 class='text-center mt-5 text-danger'>Cart is Empty</h3>";
    include("includes/footer.php");
    exit();
}

$total = 0;

/* 💰 CALCULATE TOTAL */
foreach($_SESSION['cart'] as $id => $qty) {

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);
    
    if($product){
        $total += $product['price'] * $qty;
    }
}

/* 📍 GET ADDRESS (FIXED: using user_id) */
$address = "";
$addr_query = mysqli_query($conn,"SELECT * FROM addresses WHERE user_id='$user_id' LIMIT 1");

if(mysqli_num_rows($addr_query) > 0){
    $addr_data = mysqli_fetch_assoc($addr_query);
    $address = $addr_data['address'];
}

/* 🚀 PLACE ORDER */
if(isset($_POST['place_order'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $order_insert = mysqli_query($conn,
    "INSERT INTO orders (user_id,user_name,email,address,payment_method,total_amount,status)
    VALUES ('$user_id','$user_name','$email','$address','$payment_method','$total','Pending')"
    );

    if($order_insert){

        $order_id = mysqli_insert_id($conn);

        /* 📦 ORDER ITEMS */
        foreach($_SESSION['cart'] as $id => $qty){

            $product = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
            $row = mysqli_fetch_assoc($product);

            if($row){
                $price = $row['price'];

                mysqli_query($conn,
                "INSERT INTO order_items (order_id,product_id,quantity,price)
                VALUES ('$order_id','$id','$qty','$price')"
                );
            }
        }

        /* 📧 EMAIL */
        $mail = new PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true;
            $mail->Username='YOUR_REAL_GMAIL@gmail.com';
            $mail->Password='YOUR_APP_PASSWORD';

            $mail->SMTPSecure='ssl';
            $mail->Port=465;

            $mail->setFrom('YOUR_REAL_GMAIL@gmail.com','GrihaMart');
            $mail->addAddress($email,$user_name);

            $mail->isHTML(true);
            $mail->Subject='Order Confirmation - GrihaMart';

            $mail->Body="
            <h2>Thank you for your order $user_name</h2>
            <p><b>Order ID:</b> $order_id</p>
            <p><b>Total Amount:</b> ₹$total</p>
            <p><b>Payment Method:</b> $payment_method</p>
            <p><b>Delivery Address:</b> $address</p>
            ";

            $mail->send();

        }catch(Exception $e){
            // email error ignore
        }

        /* 🧹 CLEAR CART */
        unset($_SESSION['cart']);

        echo "<script>
                alert('Order Placed Successfully');
                window.location='my_orders.php';
              </script>";

    } else {
        echo "Order Error: ".mysqli_error($conn);
    }
}
?>

<div class="container mt-4">
<div class="row justify-content-center">
<div class="col-md-6">

<div class="checkout-box">

<h2 class="text-center mb-3">🧾 Checkout</h2>

<h4 class="text-center mb-4 text-success">
Total: ₹<?php echo $total; ?>
</h4>

<form method="POST">

<input type="text"
name="name"
class="form-control mb-3"
value="<?php echo htmlspecialchars($user_name); ?>"
readonly>

<input type="email"
name="email"
class="form-control mb-3"
placeholder="Enter Email"
required>

<label class="fw-bold">Delivery Address</label>

<textarea name="address"
class="form-control mb-3"
required><?php echo htmlspecialchars($address); ?></textarea>

<label class="fw-bold">Payment Method</label>

<div class="form-check">
<input class="form-check-input"
type="radio"
name="payment_method"
value="Cash on Delivery"
required>

<label class="form-check-label">
Cash on Delivery
</label>
</div>

<button type="submit"
name="place_order"
class="btn btn-success w-100 mt-3">
Confirm Order
</button>

</form>

</div>
</div>
</div>
</div>

<?php include("includes/footer.php"); ?>
```

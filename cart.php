<?php 
include('config/database.php'); 
include('includes/header.php');

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get cart items
$sql = "SELECT cart.*, foods.name, foods.price, foods.image, restaurants.name as restaurant_name 
        FROM cart 
        JOIN foods ON cart.food_id = foods.id 
        JOIN restaurants ON foods.restaurant_id = restaurants.id 
        WHERE cart.user_id = $user_id
        ORDER BY cart.id DESC";
$result = mysqli_query($conn, $sql);
$total = 0;
$restaurant_name = '';
?>

<section class="cart-section">
    <div class="container">
        <h1>Shopping Cart</h1>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="cart-container">
            <div class="cart-items">
                <div class="cart-header">
                    <div>Item</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Total</div>
                    <div></div>
                </div>
                
                <?php while($item = mysqli_fetch_assoc($result)): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    $restaurant_name = $item['restaurant_name'];
                ?>
                <div class="cart-item" data-id="<?php echo $item['id']; ?>">
                    <div class="item-info">
                        <img src="images/foods/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        <div>
                            <h3><?php echo $item['name']; ?></h3>
                            <p class="restaurant"><?php echo $item['restaurant_name']; ?></p>
                        </div>
                    </div>
                    <div class="item-price">₹<?php echo $item['price']; ?></div>
                    <div class="item-quantity">
                        <button onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                        <span id="qty-<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?></span>
                        <button onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">+</button>
                    </div>
                    <div class="item-total" id="total-<?php echo $item['id']; ?>">₹<?php echo $subtotal; ?></div>
                    <button class="remove-btn" onclick="removeItem(<?php echo $item['id']; ?>)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <?php endwhile; ?>
            </div>
            
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Items Total</span>
                    <span>₹<?php echo $total; ?></span>
                </div>
                <div class="summary-row">
                    <span>Delivery Fee</span>
                    <span>₹40</span>
                </div>
                <div class="summary-row">
                    <span>Packaging Fee</span>
                    <span>₹10</span>
                </div>
                <div class="summary-row discount">
                    <span>Discount</span>
                    <span>-₹0</span>
                </div>
                <div class="summary-row total">
                    <span>Total Amount</span>
                    <span>₹<?php echo $total + 50; ?></span>
                </div>
                
                <form action="checkout.php" method="POST">
                    <input type="hidden" name="total_amount" value="<?php echo $total + 50; ?>">
                    <input type="hidden" name="restaurant_name" value="<?php echo $restaurant_name; ?>">
                    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                </form>
                
                <div class="payment-options">
                    <p>We accept:</p>
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                    <i class="fab fa-google-pay"></i>
                    <i class="fab fa-apple-pay"></i>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any items yet</p>
            <a href="index.php" class="btn-primary">Browse Restaurants</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function updateQuantity(cartId, change) {
    fetch('update-cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId + '&change=' + change
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        }
    });
}

function removeItem(cartId) {
    if(confirm('Remove this item from cart?')) {
        fetch('remove-cart.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'cart_id=' + cartId
        })
        .then(() => location.reload());
    }
}
</script>

<?php include('includes/footer.php'); ?>
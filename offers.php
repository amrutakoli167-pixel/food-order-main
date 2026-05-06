<?php 
include('config/database.php'); 
include('partials-front/menu.php');
?>

<style>
    .offers-page {
        background: #f8f9fa;
        padding: 80px 0;
    }
    
    .offers-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .offers-header h1 {
        font-size: 48px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }
    
    .offers-header p {
        font-size: 18px;
        color: #666;
    }
    
    .offers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .offer-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s;
        position: relative;
    }
    
    .offer-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    
    .offer-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #ff6b6b;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        z-index: 1;
    }
    
    .offer-img {
        height: 200px;
        overflow: hidden;
    }
    
    .offer-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .offer-card:hover .offer-img img {
        transform: scale(1.05);
    }
    
    .offer-content {
        padding: 25px;
    }
    
    .offer-content h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #1a1a2e;
    }
    
    .offer-discount {
        font-size: 36px;
        font-weight: 800;
        color: #ff6b6b;
        margin-bottom: 15px;
    }
    
    .offer-desc {
        color: #666;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .coupon-code {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
        border: 1px dashed #ff6b6b;
    }
    
    .coupon-code span {
        font-size: 20px;
        font-weight: 700;
        font-family: monospace;
        letter-spacing: 2px;
        color: #ff6b6b;
    }
    
    .btn-copy {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        width: 100%;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-copy:hover {
        transform: scale(1.02);
    }
    
    .validity {
        font-size: 12px;
        color: #999;
        text-align: center;
        margin-top: 15px;
    }
    
    @media (max-width: 768px) {
        .offers-header h1 {
            font-size: 32px;
        }
        .offers-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="offers-page">
    <div class="container">
        <div class="offers-header">
            <h1>🎉 Special Offers & Coupons</h1>
            <p>Grab these amazing deals before they expire!</p>
        </div>
        
        <div class="offers-grid">
            <?php 
                $sql = "SELECT * FROM tbl_offers WHERE active='Yes' AND valid_to >= CURDATE() ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                if($count > 0) {
                    while($offer = mysqli_fetch_assoc($res)) {
                        $title = $offer['title'];
                        $discount_value = $offer['discount_value'];
                        $description = $offer['description'];
                        $coupon_code = $offer['coupon_code'];
                        $badge = $offer['badge'];
                        $min_order = $offer['min_order'];
                        $valid_to = $offer['valid_to'];
                        
                        // Random image based on title
                        $images = [
                            'Welcome Offer' => 'https://images.pexels.com/photos/2338407/pexels-photo-2338407.jpeg?auto=compress&cs=tinysrgb&w=400',
                            'Biryani Lovers' => 'https://images.pexels.com/photos/1600727/pexels-photo-1600727.jpeg?auto=compress&cs=tinysrgb&w=400',
                            'Free Delivery' => 'https://images.pexels.com/photos/3020919/pexels-photo-3020919.jpeg?auto=compress&cs=tinysrgb&w=400',
                            'Weekend Special' => 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&w=400',
                            'Pizza Mania' => 'https://images.pexels.com/photos/1146760/pexels-photo-1146760.jpeg?auto=compress&cs=tinysrgb&w=400',
                            'Burger Combo' => 'https://images.pexels.com/photos/2983101/pexels-photo-2983101.jpeg?auto=compress&cs=tinysrgb&w=400'
                        ];
                        $img = isset($images[$title]) ? $images[$title] : 'https://images.pexels.com/photos/2338407/pexels-photo-2338407.jpeg?auto=compress&cs=tinysrgb&w=400';
            ?>
            <div class="offer-card">
                <div class="offer-badge"><?php echo $badge; ?></div>
                <div class="offer-img">
                    <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                </div>
                <div class="offer-content">
                    <h3><?php echo $title; ?></h3>
                    <div class="offer-discount"><?php echo $discount_value; ?></div>
                    <p class="offer-desc"><?php echo $description; ?></p>
                    <?php if($min_order > 0): ?>
                        <p style="font-size: 12px; color: #666;">Minimum order: ₹<?php echo $min_order; ?></p>
                    <?php endif; ?>
                    <div class="coupon-code">
                        <span><?php echo $coupon_code; ?></span>
                    </div>
                    <button class="btn-copy" onclick="copyCode('<?php echo $coupon_code; ?>')">Copy Code</button>
                    <div class="validity">Valid till: <?php echo date('d M Y', strtotime($valid_to)); ?></div>
                </div>
            </div>
            <?php 
                    }
                } else {
                    echo '<div class="no-offers" style="text-align:center; grid-column:1/-1; padding:60px;">
                            <i class="fas fa-tags" style="font-size:64px; color:#ff6b6b;"></i>
                            <h3>No Active Offers</h3>
                            <p>Check back later for amazing deals!</p>
                          </div>';
                }
            ?>
        </div>
    </div>
</section>

<script>
function copyCode(code) {
    navigator.clipboard.writeText(code);
    alert('Coupon code ' + code + ' copied to clipboard!');
}
</script>

<?php include('partials-front/footer.php'); ?>
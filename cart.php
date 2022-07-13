<?php require_once('includes/header.php');?>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php"><i class="fa fa-home"></i> Accueil</a>
                        <span>Panier</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="shopping_cart_area">
        <div class="container">  
            <form action="#"> 
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc" id="getCartDetail"></div>
                     </div>
                 </div>
                 <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code left">
                                <h3>Code promo</h3>
                                <div class="coupon_inner">   
                                    <p>Saisissez un code promo si vous en avez un.</p>                                
                                    <input placeholder="Code promo" type="text" id="discountcode">
                                    <button type="submit" onclick="addDiscountCode();return false;">Appliquer</button>
                                    <p class="mt-3">Saisissez le code de votre chèque cadeau JOeMA.</p>                                
                                    <input placeholder="JOeMA CheQue" type="text" id="giftCertificateCode">
                                    <button type="submit" onclick="addGiftCertificateCode();return false;">Appliquer</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6"  id="pageCartPrice">
                            <div class="coupon_code right">
                                <div class="coupon_inner">
                                   <div class="cart_subtotal">
                                       <p>Sous-total</p>
                                       <p class="cart_amount"><?=$system->totalCart()?>€</p>
                                   </div>
                                   <div class="checkout_btn">
                                       <a href="checkout.php">Commander</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->
            </form> 
        </div>
    </section>

<?php require_once('includes/footer.php');?>
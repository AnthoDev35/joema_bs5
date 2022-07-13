<?php require_once('includes/header.php');
$getCountAllCustomers = $db->query('SELECT * FROM `customers`')->num_rows;
$getCountAllOrders = $db->query('SELECT * FROM `customers_orders`')->num_rows;
$getAllOrders = $db->query('SELECT * FROM `customers_orders`');
$countAmount = 0;
while($getAllOrder = $getAllOrders->fetch_object()){
	$countAmount += $getAllOrder->TotalCart;
}
$getCountAllCarts = 0; /*$db->query(''); @TODO*/ 
?>
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="overview-wrap">
                                    <h2 class="title-3">Bienvenue <?=$acc->username?>! Que voulez-vous faire ?</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon"><i class="fa fa-user"></i></div>
                                            <div class="text">
                                                <h2><?=$getCountAllCustomers?></h2>
                                                <span>Comptes crées</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                                            <div class="text">
                                                <h2><?=$getCountAllCarts?></h2>
                                                <span>Paniers</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon"><i class="fa fa-calendar"></i></div>
                                            <div class="text">
                                                <h2><?=$getCountAllOrders?></h2>
                                                <span>Commandes</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon"><i class="fa fa-euro"></i></div>
                                            <div class="text">
                                                <h2><?=number_format($countAmount, 2)?> €</h2>
                                                <span>Total</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="setMailBoxResults"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php require_once('includes/footer.php');?>
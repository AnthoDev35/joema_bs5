<?php require_once('includes/header.php');?>
            <div class="main-content">
                <div class="section__content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
								<h6 style="float:right">Nombre de lignes : <?php $getCounter = $db->query('SELECT * FROM `articles`'); echo $getCounter->num_rows;?></h6>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="overview-wrap">
									<h2 class="title-3">Gestion des articles
										<input type="text" class="form-control float-right" id="getArticleSearch" placeholder="Rechercher" style="width:300px"/>
										<div class="dropdown-menu dropdown-menu-right " id="articleSearchResults"></div>
									</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="setAllArticles"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php require_once('includes/footer.php');
if(isset($_GET['isRefreshPage'], $_GET['getArticlePage'])){
	echo '<script>$(window).on( "load", function() {getArticlePages('.$_GET['getArticlePage'].');});</script>';
}
else{
	echo '<script>$(window).on( "load", function() {getArticlePages(0);});</script>';
}?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons col-red">filter_9_plus</i>
                    </div>
                    <div class="content">
                        <div class="text">COMPROBANTES</div>
                        <div class="number count-to" data-from="0" data-to="<?=$comprobantes['cantidad']?>" data-speed="2000" data-fresh-interval="20"><?=$comprobantes['cantidad']?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons col-red">shopping_cart</i>
                    </div>
                    <div class="content">
                        <div class="text">COTIZACIONES</div>
                        <div class="number count-to" data-from="0" data-to="<?=$cotizaciones['cantidad']?>" data-speed="1000" data-fresh-interval="20"><?=$cotizaciones['cantidad']?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
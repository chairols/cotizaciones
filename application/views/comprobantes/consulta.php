<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CONSULTA DE COMPROBANTES
                        </h2>
                    </div>
                    <div class="body">
                        <form class="form-horizontal" method="POST">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label>Tipo de Comprobante</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="tipo_comprobante" class="form-control" required>
                                                <?php foreach($tipos as $tipo) { ?>
                                                <option value="<?=$tipo['comprobanteDescripcion']?>"><?=$tipo['comprobanteDescripcion']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label>Número</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="numero" placeholder="Ingrese Número de Comprobante" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">BUSCAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php if(isset($factura)) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2><?=$cliente['cliente']?></h2>
                        <br>
                        <h2><?=$factura['comprobanteDescripcion']?> <?=$factura['numeroFactura']?></h2>
                    </div>
                    <div class="body">
                        <div class="icon-and-text-button-demo">
                            <a href="/comprobantes/pdf/<?=$factura['id']?>/I/" target="_blank">
                                <button type="button" class="btn bg-green waves-effect">
                                    <i class="material-icons">remove_red_eye</i>
                                    <span>VISUALIZAR</span>
                                </button>
                            </a>
                            <a href="/comprobantes/pdf/<?=$factura['id']?>/D/" target="_blank">
                                <button type="button" class="btn bg-green waves-effect">
                                    <i class="material-icons">file_download</i>
                                    <span>DESCARGAR</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</section>
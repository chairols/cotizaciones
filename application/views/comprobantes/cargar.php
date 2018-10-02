<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CARGAR COMPROBANTES
                        </h2>
                    </div>
                    <div class="body">
                        <form action="/comprobantes/upload/" id="my-dropzone" class="dropzone" method="post" enctype="multipart/form-data">
                            <div class="dz-message">
                                <div class="drag-icon-cph">
                                    <i class="material-icons">touch_app</i>
                                </div>
                                <h3>Arrastre los archivos aquí o click para subir.</h3>
                            </div>
                            <div class="fallback">
                                <input accept="text/plain" name="file" type="file" multiple />
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            COMPROBANTES DISPONIBLES PARA PROCESAR
                            <a onclick="procesar();" class="btn btn-success waves-effect waves-white pull-right">PROCESAR</a>
                        </h2>
                    </div>
                    <div class="body table-responsive" id="body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>COMPROBANTE</th>
                                    <th>CLIENTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($valores as $valor) { ?>
                                <tr>
                                    <td><?=$valor['comprobanteDescripcion']?> <?=$valor['comprobante']?> <?=substr($valor['cabecera'], 15, 5)?>-<?=$valor['numeroFactura']?></td>
                                    <td><?=$valor['razonSocial1']?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php //var_dump($archivos); ?>
                        <!--<pre>
                        <?php //print_r($valores); ?>
                        <?php //print_r($items); ?>
                        </pre>-->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>

<script type="text/javascript" src="/assets/js/comprobantes/cargar.js"></script>
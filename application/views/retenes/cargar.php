<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CARGAR LISTA DBH
                        </h2>
                    </div>
                    <div class="body">
                        <form action="/retenes/upload/" id="my-dropzone" class="dropzone" method="post" enctype="multipart/form-data">
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
                            LISTAS DISPONIBLES PARA PROCESAR
                            <a onclick="procesar();" class="btn btn-success waves-effect waves-white pull-right">PROCESAR</a>
                        </h2>
                    </div>
                    <div class="body table-responsive" id="body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ARCHIVO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($archivos as $archivo) { ?>
                                <tr>
                                    <td><?=$archivo?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>

<script type="text/javascript" src="/assets/js/retenes/cargar.js"></script>
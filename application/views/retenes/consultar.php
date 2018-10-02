<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CONSULTA DE RETENES
                        </h2>
                    </div>
                    <div class="body">
                        <form class="form-horizontal" method="POST">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label>Número</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="numero" id="numero" placeholder="Ingrese Número de Retén" required selected>
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
    <?php if(isset($retenes)) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Retén</th>
                                    <th>Diseño</th>
                                    <th>Eje</th>
                                    <th>Alojamiento</th>
                                    <th>Altura</th>
                                    <th>Precio de Lista</th>
                                    <th>Precio Neto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($retenes as $reten) { ?>
                                <tr>
                                    <td><?=$reten['reten']?></td>
                                    <td><?=$reten['disenio']?></td>
                                    <td><?=$reten['eje']?></td>
                                    <td><?=$reten['alojamiento']?></td>
                                    <td><?=$reten['altura']?></td>
                                    <td>$ <?=$reten['precio']?></td>
                                    <td><strong>$ <?=($reten['precio']*0.30)?></strong></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</section>
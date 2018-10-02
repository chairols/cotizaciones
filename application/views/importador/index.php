<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>404 | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="/assets/AdminBSBMaterialDesign-master/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="/assets/AdminBSBMaterialDesign-master/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="/assets/AdminBSBMaterialDesign-master/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="row clearfix">
        <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>ACCIONES</h2>
                    </div>
                    <div class="body text-left">
                        <h3>CARGAR GENERICOS A product_abstract</h3> 
                        <a href="/importador/genericos/">
                            <button type="button" class="btn btn-success waves-effect">
                                <span>IR</span>
                                <i class="material-icons">send</i>
                            </button>
                        </a>
                        <p class="m-t-5 m-b-30">
                            Se debe tener el archivo /assets/Genericos.csv
                        </p>
                        
                        <hr>
                        <h3>UPDATE & ADD ARTICULOS.CSV A product</h3>
                        <a href="/importador/actualizar/">
                            <button type="button" class="btn btn-success waves-effect">
                                <span>IR</span>
                                <i class="material-icons">send</i>
                            </button>
                        </a>
                        <p class="m-t-5 m-b-30">
                            Se debe tener el archivo /assets/ARTICULO.TXT. <br>
                            - Se tiene que borrar la primera línea de cabecera y ejecutar desde consola. <br>
                            - Se tiene que abrir con un excel y reemplazar en estantería el caracter ¥ por el caracter Ñ
                            <b>PATH~> php index.php importador actualizar</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<!-- Jquery Core Js -->
<script src="/assets/AdminBSBMaterialDesign-master/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="/assets/AdminBSBMaterialDesign-master/plugins/bootstrap/js/bootstrap.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="/assets/AdminBSBMaterialDesign-master/plugins/node-waves/waves.js"></script>

</html>
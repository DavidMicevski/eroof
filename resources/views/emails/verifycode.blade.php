<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css" rel="stylesheet" media="all">
        body {
            background: #d8d8d8;
            padding: 10px;
        }
        .logo {
            padding-top: 30px;
            padding-left: 10px;
            max-width: 230px;
            width: 50%;
            margin: auto;
        }

        .content {
            background: #efefef;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 30px;
            border-radius: 20px;
            text-align: center;
        }

        .content div {
            line-height: 1.3;
        }
        .block {
            margin-top: 25px;
        }

        .facebook-icon {
            width: 35px;
            height: 30px;
            margin: auto;
            padding-top: 5px;
            border-radius: 5px;
            margin-top: 30px;
        }

        .facebook-icon svg {
            width: 15px;
            color: #efefef;
        }

        h1 {
            margin-top: 5px;
        }
    </style>
</head>

<?php

$style = [

];
?>

<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

<body>
    <div class="content">
        <div class="logo">
            <img src="https://buscasa360storage0010513.s3-us-west-2.amazonaws.com/buscasa360_logo.png" style="width:90%;"/>
        </div>
        <div class="block">
            <span>
                Hola {{$introLines['code']}},
            </span>
        </div>
        <div class="block">
            <span>
                Estás a un paso de crear tu cuenta de Buscasa360.
            </span>
        </div>
        <div class="block">
            <span>
                Confirmar su cuenta ingresando este código:
            </span>
        </div>
        <div class="block">
            <span>
                {{$introLines['code']}}
            </span>
        </div>
        <div class="block">
            <span>
                Si tiene preguntas sobre las funciones o necesita ayuda, contáctenos en support@buscasa360.com
            </span>
        </div>
        <div class="facebook-icon">
            <a href="https://www.facebook.com/appbuscasa" target="_blank">
                <img src="https://buscasa360storage0010513.s3-us-west-2.amazonaws.com/facebook.png" style="width:100%;"/>
            </a>
        </div>

        <div class="block">
            Buscasa &copy; 2020, Todos los derechos reservados.<br>
            Está recibiendo este correo electrónico como cliente de Buscasa360.
        </div>
        <div class="block">
            Puede darse de baja de esta lista.
        </div>
    </div>
</body>
</html>

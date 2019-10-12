<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Agrimeint</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/normalize.css">
    </head>

    <body>
        <!-- site-header -->
        <header class="site-header">
            <div class="contenedor">
                <!-- barra -->
                <div class="barra-index">
                    <a href="./index.php">
                        <h1 class="no-margin">Agrimeint</h1>
                    </a>

                    <?php if(!utils::isIdentity()) : ?>
                    <nav class="navegacion">
                        <a href="<?=base_url?>?controller=usuario&action=registro">Registro</a>
                        <a href="<?=base_url?>?controller=publicacion&action=verTodas">Publicaciones</a>
                        <a href="<?=base_url?>?controller=usuario&action=registro">Login</a>
                        <a href="nosotros.php">Nosotros</a>
                    </nav>
                    <?php endif; ?>

                    <?php if(utils::isIdentity()) : ?>
                    <nav class="navegacion">
                        <a href="<?=base_url?>?controller=usuario&action=miCuenta">mi cuenta</a>
                        <a href="<?=base_url?>?controller=publicacion&action=verTodas">Publicaciones</a>
                        <a href="<?=base_url?>?controller=publicacion&action=misPublicaciones">mis publicaciones</a>
                        <a href="<?=base_url?>?controller=usuario&action=logout">salir</a>
                    </nav>
                    <?php endif; ?>
                </div>

                <div class="texto-header">
                    <h2 class="no-margin">De la mano amiga</h2>
                    <p>somos una iniciativa que busca ayudar a los agricultores mexicanos</p>
                    <a href="nosotros.php" class="boton boton-amarillo">Conoce más</a>
                </div>
            </div>
        </header> 
        <!-- fin site-header -->
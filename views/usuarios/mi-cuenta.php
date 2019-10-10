<?php if (utils::isIdentity()) : ?>

    <!-- mis-datos -->
    <div class="mis-datos contenedor">
        <h3 class="centrar-texto">Mis datos</h3>
        <form action="<?= base_url ?>?controller=usuario&action=actualizar" method="POST">
            <label for="id">ID</label>
            <input type="number" name="id" readonly="readonly" value="<?= $usuario->id_usuario;?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?= $usuario->nombre;?>">
            <?php echo isset($_SESSION['actualizar_errores']['nombre']) ? "<div class='mensaje error'>".$_SESSION['actualizar_errores']['nombre']."</div>" :""; ?>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" value="<?=$usuario->apellidos;?>">
            <?php echo isset($_SESSION['actualizar_errores']['apellidos']) ? "<div class='mensaje error'>".$_SESSION['actualizar_errores']['apellidos']."</div>" :""; ?>
            
            <label for="email">Email:</label>
            <input type="email" name="email" readonly="readonly" value="<?=$usuario->email;?>">
           
            <label for="telefono">Telefono:</label>
            <input type="telefono" name="telefono" value="<?=$usuario->telefono;?>">
            <?php echo isset($_SESSION['actualizar_errores']['telefono']) ? "<div class='mensaje error'>".$_SESSION['actualizar_errores']['telefono']."</div>" :""; ?>
            
            <label for="fecha">Fecha de registro:</label>
            <input type="text" name="fecha" readonly="readonly" value="<?=$usuario->fecha_registro;?>">

            <input type="submit" name="Crear cuenta" class="boton boton-amarillo" value="Actualizar">
        </form>

        <?php echo isset($_SESSION['actualizar']) ? $_SESSION['actualizar'] : ""; ?>
        
        <a href="<?=base_url?>?controller=usuario&action=miCuenta" class="boton boton-verde">mis publicaciones</a>
    </div>

    <?=utils::deleteSession("actualizar");?>
    <?=utils::deleteSession("actualizar_errores");?>

<?php else : ?>
    <h2 class="mensaje error">Debes iniciar sesion para acceder</h2>
    <?= header("Refresh:4; url=".base_url); ?>

<?php endif; ?>
<div class="registro-entrar contenedor">
    <!-- entrar -->
    <div class="entrar">
        <h3 class="centrar-texto">Login</h3>
        <form action="<?=base_url?>?controller=usuario&action=login" method="POST">
            <label for="email">Email:</label>    
            <input type="email" name="email" placeholder="Introduce tu correo..." required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" placeholder="Introduce tu contraseña..." required>

            <input type="submit" name="Entrar" class="boton boton-amarillo" value="Entrar">
        </form>
    </div>

    <!-- registro -->
    <div class="registro">
        <h3 class="centrar-texto">Registrate</h3>
        <form action="<?=base_url?>?controller=usuario&action=guardar" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <?php echo isset($_SESSION['registro']['nombre']) ? "<div class='mensaje error'>".$_SESSION['registro']['nombre']."</div>" :""; ?>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" required>
            <?php echo isset($_SESSION['registro']['apellidos']) ? "<div class='mensaje error'>".$_SESSION['registro']['apellidos']."</div>" :""; ?>

            <label for="email">Email:</label>    
            <input type="email" name="email" required>
            <?php echo isset($_SESSION['registro']['email']) ? "<div class='mensaje error'>".$_SESSION['registro']['email']."</div>" :""; ?>

            <label for="telefono">Telefono:</label>
            <input type="telefono" name="telefono" required>
            <?php echo isset($_SESSION['registro']['telefono']) ? "<div class='mensaje error'>".$_SESSION['registro']['telefono']."</div>" :""; ?>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <?php echo isset($_SESSION['registro']['password']) ? "<div class='mensaje error'>".$_SESSION['registro']['password']."</div>" :""; ?>

            <input type="submit" name="Crear cuenta" class="boton boton-amarillo" value="Crear cuenta">
        </form>

        <?php echo isset($_SESSION['registro']) && $_SESSION['registro'] == 'ok' ? "<div class='mensaje'>Cuenta creada con exito, ya puedes ingresar en el login</div>" : ""; ?>
    </div>

    <?= utils::deleteSession('registro'); ?>

</div>


<div class="registro-entrar contenedor">
    <!-- entrar -->
    <div class="entrar">
        <h3 class="centrar-texto">Login</h3>
        <form action="<?=base_url?>?controller=usuario&action=registro" method="POST">
            <label for="email">Email:</label>    
            <input type="email" name="email" placeholder="Introduce tu correo...">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" placeholder="Introduce tu contraseña...">

            <input type="submit" name="Entrar" class="boton boton-amarillo" value="Entrar">
        </form>
    </div>

    <!-- registro -->
    <div class="registro">
        <h3 class="centrar-texto">Registrate</h3>
        <form action="<?=base_url?>?controller=usuario&action=registro" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre">

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos">

            <label for="email">Email:</label>    
            <input type="email" name="email">

            <label for="telefono">Telefono:</label>
            <input type="telefono" name="telefono">

            <label for="password">Contraseña:</label>
            <input type="password" name="password">

            <input type="submit" name="Crear cuenta" class="boton boton-amarillo" value="Crear cuenta">
        </form>
    </div>

    

</div>


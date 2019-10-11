        <!-- site-footer -->
        <footer class="site-footer seccion">
            <!-- contenidor-footer -->
            <div class="contenido-footer contenedor">
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
                    <a href="<?=base_url?>?controller=publicacion&action=misPublicaciones">mis publicaciones</a>
                    <a href="<?=base_url?>?controller=publicacion&action=verTodas">Publicaciones</a>
                    <a href="<?=base_url?>?controller=usuario&action=logout">salir</a>
                </nav>
                <?php endif; ?>
                
                <p class="copyright">Todos los Derechos Reservados 2019 &copy Agrimeint </p>
            </div>
        </footer>
        <!-- fin site-footer -->

    </body>
</html>
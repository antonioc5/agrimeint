<div class="seccion contenedor">
    <h2 class="fw-300 centrar-texto rellenado">¡Publicaciones destacadas!</h2>

    <!-- buscador -->
    <form action="" method="POST" class="buscador">
        <input type="text" placeholder="Busca un producto...">
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>    
    </form>

    <!-- contenedor-publicaciones -->
    <div class="contenedor-publicaciones">
        <?php while($publicacion = $publicaciones->fetch_object()) :?>
            <div class="publicacion">
                <img src="assets/imagenes-subidas/<?=$publicacion->imagen?>" alt="Imagen producto">

                <div class="contenido-publicacion">
                    <h3 class="fw-300"><?=$publicacion->titulo?></h3>
                    <p><i class="fas fa-user"></i> <?=$publicacion->nombre?> <?=$publicacion->apellidos?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?=$publicacion->municipio?>, <?=$publicacion->estado?></p>
                    <p><?= substr($publicacion->descripcion, 0, 180) ?>...</p>
                    <p class="precio"><i class="fas fa-tag"></i>$<?=$publicacion->precio?></p>

                    <a href="<?=base_url?>?controller=publicacion&action=verPublicacion&id=<?=$publicacion->id_publicacion?>" class="boton boton-amarillo d-block">Ver Publicacion</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="ver-todas">
        <a href="<?=base_url?>?controller=publicacion&action=verTodas" class="boton boton-verde">Ver todas las publicaciones</a>
    </div>
</div>
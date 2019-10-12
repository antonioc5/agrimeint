<h3 class="fw-300 centrar-texto rellenado">Todas tus publicaciones</h3>

<?php if ($publicaciones->num_rows != 0) : ?>

    <div class="contenedor-publicaciones contenedor">
        <?php while ($publicacion = $publicaciones->fetch_object()) : ?>
            <div class="publicacion">
                <img src="./assets/imagenes-subidas/<?= $publicacion->imagen; ?>" alt="Imagen producto">

                <div class="contenido-publicacion">
                    <h3 class="fw-300"><?= substr($publicacion->titulo, 0, 30) ?></h3>
                    <p><i class="fas fa-user"></i><?= $publicacion->nombre ?> <?= $publicacion->apellidos ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?= $publicacion->municipio ?>, <?= $publicacion->estado ?></p>
                    <p><?= substr($publicacion->descripcion, 0, 180) ?>...</p>
                    <p class="precio"><i class="fas fa-tag"></i>$<?= $publicacion->precio ?></p>

                    <a href="<?= base_url ?>?controller=publicacion&action=editar&id=<?= $publicacion->id_publicacion ?>" class="boton boton-amarillo d-block">Editar</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

<?php else : ?>
    <h3 class="fw-300 centrar-texto">No tienes ninguna publicacion!</h3>

<?php endif; ?>

<div class="contenedor">
    <a href="<?= base_url ?>?controller=publicacion&action=publicar" class="boton boton-verde">Publica un producto!</a>
</div>

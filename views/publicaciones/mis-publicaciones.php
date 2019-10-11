<h3 class="fw-300 centrar-texto rellenado">Todas tus publicaciones</h3>

<?php if($publicaciones->num_rows != 0) :?>

    <?php while($publicacion = $publicaciones->fetch_object()) :?>
        <div class="contenedor-publicaciones contenedor">
            <div class="publicacion">
                <img src="assets/imagenes-subidas/".<?= $publicacion->imagen; ?> alt="Imagen producto">

                <div class="contenido-publicacion">
                    <h3><?=substr($publicacion->titulo, 0, 30)?></h3>
                    <p><i class="fas fa-user"></i><?=$publicacion->nombre?> <?=$publicacion->apellidos?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?=$publicacion->estado?>, <?=$publicacion->municipio?></p>
                    <p><?=substr($publicacion->descripcion, 0, 180)?>...</p>
                    <p class="precio"><i class="fas fa-tag"></i>$<?=$publicacion->precio?></p>

                    <a href="<?= base_url ?>?controller=publicacion&action=editar&id=<?=$publicacion->id_publicacion?>" class="boton boton-amarillo d-block">Editar</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

<?php else: ?>
<h3 class="fw-300 centrar-texto">No tienes ninguna publicacion!</h3>

<?php endif; ?>
<div class="contenedor">
    <a href="<?=base_url?>?controller=publicacion&action=crear" class="boton boton-verde">Publica un producto!</a>
</div>
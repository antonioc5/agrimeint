
<div class="resumen-publicacion contenedor">
    <h2 class="fw-300 centrar-texto"><?=$publicacion->titulo?></h2>

    <img src="assets/imagenes-subidas/<?=$publicacion->imagen?>" alt="Imagen publicacion">
    
    <p><i class="fas fa-tag"></i><span>$<?=$publicacion->precio?></span></p>

    <p><i class="fas fa-user"></i><span>Vendedor:</span> <?=$publicacion->nombre?> <?=$publicacion->apellidos?></p>

    <p><i class="fas fa-map-marker-alt"></i><span>Ubicacion:</span> <?=$publicacion->municipio?>, <?=$publicacion->estado?></p>

    <p><span>Descripcion:</span><br><?=$publicacion->descripcion?></p>

    <p><i class="fas fa-phone-square"></i><span>Telefono:</span> <b><?=$publicacion->telefono?><b></p>

    <p><i class="fas fa-envelope"></i><span>Email:</span> <b><?=$publicacion->email?><b></p>
</div>
<div class="seccion contenedor">

    <!-- buscador -->
    <form action="" method="POST" class="buscador">
        <input type="text" placeholder="Busca un producto...">
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>    
    </form>

    <!-- contenedor-publicaciones -->
    <div class="contenedor-publicaciones">
        <!-- publicacion -->
        <div class="publicacion">
            <img src="assets/img/sin-imagen.jpg" alt="Imagen producto">

            <!-- contenido-publicacion -->
            <div class="contenido-publicacion">
                <h3>Fresa recien cosechada</h3>
                <p><i class="fas fa-user"></i> Juan antonio</p>
                <p><i class="fas fa-map-marker-alt"></i> Mazatlan, sinaloa</p>
                <p>Fresa de calidad, riego con agua limpia disponible en tamaño y maduracion al gusto del cliente</p>
                <p class="precio"><i class="fas fa-tag"></i>$300</p>

                <a href="<?=base_url?>?controller=publicacion&action=verPublicacion" class="boton boton-amarillo d-block">Ver Publicacion</a>
            </div>
            <!-- fin contenido-publicacion -->
        </div>
        <!-- fin publicacion -->
    </div>
    <!-- fin contenedor-publicaciones -->
</div>
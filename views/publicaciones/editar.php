<h3 class="fw-300 centrar-texto">Edita tu publicacion!</h3>

<div class="publicar contenedor">
    <form action="<?= base_url ?>?controller=publicacion&action=actualizar" method="POST" enctype="multipart/form-data">

        <input type="text" name="id_publicacion" value="<?=$publicacion->id_publicacion?>" style="visibility:hidden">

        <label for="categoria">Seleccione una categoria:</label>
        <?php $objCategoria = new categoria();?>
        <?php $categorias = $objCategoria->getAll();?>
        <select name="categoria">
            <?php while($categoria = $categorias->fetch_object()) :?>
                <option value="<?=$categoria->id_categoria?>" <?=$publicacion->id_categoria == $categoria->id_categoria ? 'selected' : '';?>> <?=$categoria->nombre?> </option>
            <?php endwhile; ?>
        </select>
        <?php echo isset($_SESSION['publicacion_error']['categoria']) ? $_SESSION['publicacion_error']['categoria'] : ""; ?>

        <label for="imagen">Selecciona una imagen:</label>
        <img src="./assets/imagenes-subidas/<?=$publicacion->imagen?>" alt="Imagen publicacion">
        <input type="file" name="imagen">
        <input type="text" name="imagen" value="<?=$publicacion->imagen?>" style="visibility:hidden">
        <?php echo isset($_SESSION['publicacion_error']['imagen']) ? $_SESSION['publicacion_error']['imagen'] : ""; ?>


        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" value="<?=$publicacion->titulo?>">
        <?php echo isset($_SESSION['publicacion_error']['titulo']) ? $_SESSION['publicacion_error']['titulo'] : ""; ?>


        <label for="precio">Precio:</label>
        <input type="number" name="precio" placeholder="precio por kilo, unidad, gramo, etc" value="<?=$publicacion->precio?>" >
        <?php echo isset($_SESSION['publicacion_error']['precio']) ? $_SESSION['publicacion_error']['precio'] : ""; ?>


        <label for="descripcion">Descripcion:</label>
        <textarea name="descripcion" cols="30" rows="10" placeholder="Ingrese una descripcion detallada del producto"><?=$publicacion->descripcion?></textarea>
        <?php echo isset($_SESSION['publicacion_error']['descripcion']) ? $_SESSION['publicacion_error']['descripcion'] : ""; ?>


        <label for="estado">Estado:</label>
        <input type="text" name="estado" placeholder="Ingresa el estado donde se vende este producto" value="<?=$publicacion->estado?>">
        <?php echo isset($_SESSION['publicacion_error']['estado']) ? $_SESSION['publicacion_error']['estado'] : ""; ?>


        <label for="municipio">Municipio:</label>
        <input type="text" name="municipio" placeholder="Ingresa el municipio donde se vende este producto" value="<?=$publicacion->municipio?>">
        <?php echo isset($_SESSION['publicacion_error']['municipio']) ? $_SESSION['publicacion_error']['municipio'] : ""; ?>


        <input type="submit" name="Actualizar" class="boton boton-amarillo" value="Actualizar Publicacion">
    </form>

    <?php echo isset($_SESSION['publicacion']) ? $_SESSION['publicacion'] : ""; ?>

</div>

<?php utils::deleteSession("publicacion"); ?>
<?php utils::deleteSession("publicacion_error"); ?>
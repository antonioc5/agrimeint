<h3 class="fw-300 centrar-texto">Publica un producto!</h3>

<div class="publicar contenedor">
    <form action="<?= base_url ?>?controller=publicacion&action=guardar" method="POST" enctype="multipart/form-data">

        <label for="categoria">Seleccione una categoria:</label>
        <?php $categorias = utils::getAllCategorias();?>
        <select name="categoria">
            <?php while($categoria = $categorias->fetch_object()) :?>
                <option value="<?=$categoria->id_categoria?>"><?=$categoria->nombre?></option>
            <?php endwhile; ?>
        </select>

        <label for="imagen">Selecciona una imagen:</label>
        <input type="file" name="imagen">

        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" placeholder="Ingrese el titulo de la publicacion" required>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" placeholder="precio por kilo, unidad, gramo, etc" required>

        <label for="descripcion">Descripcion:</label>
        <textarea name="descripcion" cols="30" rows="10" placeholder="Ingrese una descripcion detallada del producto"></textarea>

        <label for="estado">Estado:</label>
        <input type="text" name="estado" required placeholder="Ingresa el estado donde se vende este producto">

        <label for="municipio">Municipio:</label>
        <input type="text" name="municipio" required placeholder="Ingresa el municipio donde se vende este producto">

        <input type="submit" name="Publicar" class="boton boton-amarillo" value="Subir Publicacion">
    </form>

    <?php echo isset($_SESSION['registro']) && $_SESSION['registro'] == 'ok' ? "<div class='mensaje'>Cuenta creada con exito, ya puedes ingresar en el login</div>" : ""; ?>
</div>
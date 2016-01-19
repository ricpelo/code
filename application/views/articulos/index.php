<table border="1">
    <thead>
        <th>Código</th>
        <th>Descripción</th>
        <th colspan="2">Acciones</th>
    </thead>
    <tbody>
        <?php foreach ($filas as $fila): ?>
            <tr>
                <td><?= $fila['codigo'] ?></td>
                <td><?= $fila['descripcion'] ?></td>
                <td><?= anchor('/articulos/borrar/' . $fila['id'],
                               form_button('borrar', 'Borrar')) ?></td>
                <td><?= anchor('/articulos/editar/' . $fila['id'],
                               form_button('editar', 'Editar')) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<p>
    <?= anchor('articulos/insertar', form_button('insertar', 'Insertar')) ?>
</p>

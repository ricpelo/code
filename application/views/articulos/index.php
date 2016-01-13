<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Artículos</title>
    </head>
    <body>
        <table border="1">
            <thead>
                <td>Código</td>
                <td>Descripción</td>
                <td>Acciones</td>
            </thead>
            <tbody>
                <?php foreach ($filas as $fila): ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['descripcion'] ?></td>
                        <td><?= anchor('/articulos/borrar/' . $fila['id'],
                                       'Borrar') ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </body>
</html>

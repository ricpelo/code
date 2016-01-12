<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Artículos</title>
    </head>
    <body>
        <table border="1">
            <thead>
                <td>Id</td>
                <td>Código</td>
                <td>Descripción</td>
            </thead>
            <tbody>
                <?php foreach ($filas as $fila): ?>
                    <tr>
                        <td><?= $fila['id'] ?></td>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['descripcion'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </body>
</html>

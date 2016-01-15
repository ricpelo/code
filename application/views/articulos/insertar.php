<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Insertar artículo</title>
    </head>
    <body>
        <?= form_open('articulos/insertar') ?>
            <?= form_label('Código:', 'codigo') ?>
            <?= form_input('codigo', '', 'id="codigo"') ?><br/>
            <?= form_label('Descripción:', 'descripcion') ?>
            <?= form_input('descripcion', '', 'id="descripcion"') ?><br/>
            <?= form_label('Precio:', 'precio') ?>
            <?= form_input('precio', '', 'id="precio"') ?><br/>
            <?= form_label('Existencias:', 'existencias') ?>
            <?= form_input('existencias', '', 'id="existencias"') ?><br/>
            <?= form_submit('insertar', 'Insertar') ?>
        <?= form_close() ?>
    </body>
</html>

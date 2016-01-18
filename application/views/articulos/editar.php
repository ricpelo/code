<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Editar artículo</title>
    </head>
    <body>
        <?= validation_errors() ?>
        <?= form_open("articulos/editar/$id") ?>
            <?= form_label('Código:', 'codigo') ?>
            <?= form_input('codigo', set_value('codigo', $codigo, FALSE), 'id="codigo"') ?><br/>
            <?= form_label('Descripción:', 'descripcion') ?>
            <?= form_input('descripcion', set_value('descripcion', $descripcion, FALSE), 'id="descripcion"') ?><br/>
            <?= form_label('Precio:', 'precio') ?>
            <?= form_input('precio', set_value('precio', $precio, FALSE), 'id="precio"') ?><br/>
            <?= form_label('Existencias:', 'existencias') ?>
            <?= form_input('existencias', set_value('existencias', $existencias, FALSE), 'id="existencias"') ?><br/>
            <?= form_submit('editar', 'Editar') ?>
            <?= anchor('/articulos/index', form_button('cancelar', 'Cancelar')) ?>
        <?= form_close() ?>
    </body>
</html>

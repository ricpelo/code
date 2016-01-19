<?php template_set('title', 'Borrar un artículo') ?>
<h3>¿Seguro que desea borrar el siguiente artículo?</h3>
<p>(<?= $codigo ?>) <?= $descripcion ?></p>
<?= form_open('articulos/borrar') ?>
    <?= form_hidden('id', $id) ?>
    <?= form_submit('borrar', 'Sí') ?>
    <?= anchor('articulos/index', form_button('no', 'No')) ?>
<?= form_close() ?>

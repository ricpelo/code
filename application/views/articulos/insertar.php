<?= validation_errors() ?>
<?= form_open('articulos/insertar') ?>
    <?= form_label('Código:', 'codigo') ?>
    <?= form_input('codigo', set_value('codigo', '', FALSE), 'id="codigo"') ?><br/>
    <?= form_label('Descripción:', 'descripcion') ?>
    <?= form_input('descripcion', set_value('descripcion', '', FALSE), 'id="descripcion"') ?><br/>
    <?= form_label('Precio:', 'precio') ?>
    <?= form_input('precio', set_value('precio', '', FALSE), 'id="precio"') ?><br/>
    <?= form_label('Existencias:', 'existencias') ?>
    <?= form_input('existencias', set_value('existencias', '', FALSE), 'id="existencias"') ?><br/>
    <?= form_submit('insertar', 'Insertar') ?>
    <?= anchor('/articulos/index', form_button('cancelar', 'Cancelar')) ?>
<?= form_close() ?>

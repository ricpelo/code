<?php template_set('title', 'Editar un artículo') ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <?= validation_errors() ?>
      <?= form_open("articulos/editar/$id") ?>
        <div class="form-group">
          <?= form_label('Código:', 'codigo') ?>
          <?= form_input('codigo',
                         set_value('codigo', $codigo, FALSE),
                         'id="codigo" class="form-control"') ?>
        </div>
        <div class="form-group">
          <?= form_label('Descripción:', 'descripcion') ?>
          <?= form_input('descripcion',
                         set_value('descripcion', $descripcion, FALSE),
                         'id="descripcion" class="form-control"') ?>
        </div>
        <div class="form-group">
          <?= form_label('Precio:', 'precio') ?>
          <?= form_input('precio',
                         set_value('precio', $precio, FALSE),
                         'id="precio" class="form-control"') ?>
        </div>
        <div class="form-group">
          <?= form_label('Existencias:', 'existencias') ?>
          <?= form_input('existencias',
                         set_value('existencias', $existencias, FALSE),
                         'id="existencias" class="form-control"') ?>
        </div>
        <?= form_submit('editar', 'Editar', 'class="btn btn-success"') ?>
        <?= anchor('/articulos/index', 'Cancelar',
                   'class="btn btn-danger" role="button"') ?>
      <?= form_close() ?>
    </div>
  </div>
</div>

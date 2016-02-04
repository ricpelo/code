<?php template_set('title', 'Regenerar contraseña') ?>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Regenerar contraseña</h3>
      </div>
      <div class="panel-body">
        <?php if ( ! empty(error_array())): ?>
          <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        <?php endif ?>
        <?= form_open("usuarios/regenerar/$usuario_id/$token") ?>
          <div class="form-group">
            <?= form_label('Contraseña:', 'password') ?>
            <?= form_password('password', '',
                              'id="password" class="form-control"') ?>
          </div>
          <div class="form-group">
            <?= form_label('Confirmar contraseña:', 'password_confirm') ?>
            <?= form_password('password_confirm', '',
                              'id="password_confirm" class="form-control"') ?>
          </div>
          <?= form_submit('regenerar', 'Regenerar contraseña',
                          'class="btn btn-success"') ?>
          <?= anchor('/usuarios/login', 'Volver',
                     'class="btn btn-info" role="button"') ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

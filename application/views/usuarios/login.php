<?php template_set('title', 'Login') ?>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Login</h3>
      </div>
      <div class="panel-body">
        <?php if (count(error_array()) > 0): ?>
          <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        <?php endif ?>
        <?= form_open('usuarios/login') ?>
          <div class="form-group">
            <?= form_label('Nick:', 'nick') ?>
            <?= form_input('nick', set_value('nick', '', FALSE),
                           'id="nick" class="form-control"') ?>
          </div>
          <div class="form-group">
            <?= form_label('Contraseña:', 'password') ?>
            <?= form_password('password', '',
                              'id="password" class="form-control"') ?>
          </div>
          <?= form_submit('login', 'Login', 'class="btn btn-success"') ?>
          <?= anchor('/usuarios/recordar', 'Recordar contraseña',
                     'class="btn btn-info" role="button"') ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

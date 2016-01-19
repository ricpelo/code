<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <table border="1"
             class="table table-striped table-bordered table-hover table-condensed">
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
              <td align="center">
                <?= anchor('/articulos/borrar/' . $fila['id'], 'Borrar',
                           'class="btn btn-danger btn-xs" role="button"') ?>
              </td>
              <td align="center">
                <?= anchor('/articulos/editar/' . $fila['id'], 'Editar',
                           'class="btn btn-warning btn-xs" role="button"') ?>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <p>
        <?= anchor('articulos/insertar', 'Insertar',
                   'class="btn btn-success" role="button"') ?>
      </p>
    </div>
  </div>
</div>

<form action="" method="post" enctype="multipart/form-data">

  <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php')); ?>

  <?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php')); ?>
  <?php endif; ?>

  <?php if (isset($update)) : ?>
    <div role="alert" class="alert alert-success alert-dismissible fade show">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <ul>
        <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Updated'); ?> - <?php echo $update['updated'] ?></li>
        <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Imported'); ?> - <?php echo $update['imported'] ?></li>
        <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Removed'); ?> - <?php echo $update['removed'] ?></li>
      </ul>
    </div>
  <?php endif; ?>

  <?php if (isset($update)) : ?>
    <script>
      setTimeout(function() {
        window.parent.location.reload();
      }, 1500);
    </script>
  <?php endif; ?>

 <div class="form-group">
  <label class="form-label fw-bold">CSV</label>
  <input type="file" name="files" class="form-control form-control-sm" />
</div>

  <div class="card mb-3">
    <div class="card-header bg-light fw-bold">
      📋 Paso 1: Formato del archivo CSV
    </div>
    <div class="card-body">
      <p>Se omitirá la primera fila (encabezados). El orden de columnas debe ser:</p>
      <div class="table-responsive">
        <table class="table table-sm table-bordered text-center align-middle mb-0" style="white-space: nowrap;">
          <thead class="table-light">
            <tr>
              <th>1</th>
              <th>2</th>
              <th>3</th>
              <th>4</th>
              <th>5</th>
              <th>6</th>
              <th>7</th>
              <th>8</th>
              <th>9</th>
              <th>10</th>
              <th>11</th>
              <th>12</th>
              <th>13</th>
              <th>14</th>
              <th>15</th>
              <th>16</th>
              <th>17</th>
              <th>18</th>
              <th>19</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>phone</td>
              <td>phone_recipient</td>
              <td>name</td>
              <td>lastname</td>
              <td>title</td>
              <td>company</td>
              <td>email</td>
              <td>date</td>
              <td>status</td>
              <td>attr_str_1</td>
              <td>attr_str_2</td>
              <td>attr_str_3</td>
              <td>attr_str_4</td>
              <td>attr_str_5</td>
              <td>attr_str_6</td>
              <td>file_1</td>
              <td>file_2</td>
              <td>file_3</td>
              <td>file_4</td>
            </tr>
          </tbody>
        </table>
      </div>

      <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/import') ?>?sample=1"
        class="btn btn-outline-primary btn-sm mt-2">
        <span class="material-icons align-middle">file_download</span>
        Descargar ejemplo
      </a>
    </div>
  </div>



  <div>
    <strong>Valores permitidos para la columna <code>status</code>:</strong>
    <ul class="mb-0">
      <li><span class="badge bg-secondary">unknown</span></li>
      <li><span class="badge bg-secondary">unsubscribed</span></li>
      <li><span class="badge bg-secondary">failed</span></li>
      <li><span class="badge bg-secondary">active</span></li>
    </ul>
  </div>

  <br>

  <div class="form-group">
    <label><input type="checkbox" name="remove_old" value="on" <?php if (isset($remove_old) && $remove_old == true) : ?>checked="checked" <?php endif; ?>> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Remove old records'); ?></label>
    <br /><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'If you do not check we will try to update existing records without removing all records.'); ?></small>
  </div>

  <hr>

  <div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'This recipient is a member of these mailing lists'); ?></label>
    <div class="row" style="max-height: 500px; overflow: auto">
      <?php
      $params = array(
        'input_name'     => 'ml[]',
        'display_name'   => 'name',
        'css_class'      => 'form-control',
        'multiple'       => true,
        'wrap_prepend'   => '<div class="col-4">',
        'wrap_append'    => '</div>',
        'selected_id'    => $item->ml_ids_front,
        'list_function'  => '\LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactList::getList',
        'list_function_params'  => array('sort' => 'name ASC, id ASC', 'limit' => false)
      );
      echo erLhcoreClassRenderHelper::renderCheckbox($params);
      ?>
    </div>
  </div>


  <input type="submit" class="btn btn-sm btn-secondary" name="UploadFileAction" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Import'); ?>" />
</form>
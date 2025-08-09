<style>
  h1 {
    font-size: 2rem;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
  }

  .btn-primary {
    background-color: #007bff;
    color: #fff;
    padding: 4px 8px;
    /* Adjust padding for a smaller button */
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 20px;
    transition: background-color 0.3s;
    font-size: 0.8rem;
    /* Adjust font size for a more compact button */
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .btn-primary .material-icons {
    font-size: 1rem;
    /* Adjust icon size for better proportion */
  }

  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 1rem;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
  }

  th,
  td {
    padding: 16px 20px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  th {
    background-color: #f2f2f2;
    font-weight: bold;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tr:hover {
    background-color: #f1f1f1;
  }

  .action-column {
    display: flex;
    gap: 5px;
    align-items: center;
  }

  .action-column form {
    margin: 0;
  }



  .btn-danger {
    background-color: #dc3545;
    color: #fff;
  }

  .btn-danger:hover {
    background-color: #c82333;
  }

  .btn-warning {
    background-color: #ffc107;
    color: #212529;
  }

  .btn-warning:hover {
    background-color: #e0a800;
  }
</style>



<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Kanban status'); ?></h1>
<?php if ($create_status == true) : ?>
  <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_new'); ?>" class="btn btn-primary"><span class="material-icons">description</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create'); ?></a>
<?php endif; ?>
<br>
<table>
  <thead>
    <tr>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'ID'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Color'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Position'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Acciones'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($status as $row) : ?>
      <tr>
        <td><?php echo $row->id; ?></td>
        <td><?php echo $row->nombre; ?></td>
        <td><?php echo $row->color; ?></td>
        <td><?php echo $row->posicion; ?></td>
        <td>
          <?php if ($delete_status == true) : ?>
            <form method="post" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_delete') ?>" onsubmit="return confirm('Esta acción es irreversible, ¿desea eliminar la plantilla? ');">
              <input type="hidden" name="status_id" value="<?php echo htmlspecialchars_decode($row->id); ?>">
              <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delete'); ?></button>
            </form>
          <?php endif; ?>
          <?php if ($edit_status == true) : ?>
            <form method="update" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_edit') ?>">
              <input type="hidden" name="status_id" value="<?php echo htmlspecialchars_decode($row->id); ?>">
              <button type="submit" class="btn btn-warning"><span class="material-icons">equalizer</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Edit'); ?></button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
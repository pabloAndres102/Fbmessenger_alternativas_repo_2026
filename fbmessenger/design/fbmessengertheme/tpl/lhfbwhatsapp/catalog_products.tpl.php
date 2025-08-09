<style>
  .catalog-status {
    padding: 10px;
    margin: 20px auto;
    border-radius: 8px;
    text-align: center;
    font-size: 1.2rem;
    width: 50%;
    max-width: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  .catalog-status-active {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }

  .catalog-status-inactive {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }

  .catalog-status .material-icons {
    font-size: 1.5rem;
  }

  h1 {
    font-size: 2rem;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
  }

  .btn-primary {
    background: linear-gradient(135deg, #ff5f6d, #ffc371);
    color: #fff;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #ffc371, #ff5f6d);
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .btn-primary .material-icons {
    font-size: 1.2rem;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 1rem;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
  }

  th,
  td {
    padding: 16px 20px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
    /* Ensure vertical alignment is middle */
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

  .btn-danger,
  .btn-warning {
    padding: 10px 15px;
    border-radius: 25px;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .btn-danger {
    background-color: #dc3545;
  }

  .btn-danger:hover {
    background-color: #c82333;
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .btn-warning {
    background-color: #ffc107;
    color: #212529;
  }

  .btn-warning:hover {
    background-color: #e0a800;
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .btn-primary .material-icons,
  .btn-danger .material-icons,
  .btn-warning .material-icons {
    font-size: 1rem;
  }

  .product-image {
    max-width: 100px;
    border-radius: 8px;
    transition: transform 0.3s ease;
  }

  .product-image:hover {
    transform: scale(1.1);
  }
</style>



<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Catalog'); ?></h1>
<center>
  <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/catalog_products') ?>" method="post" style="display: inline-block; margin-bottom: 9px;">
    <input type="hidden" name="action">
    <button type="submit" class="btn btn-primary">
      <span class="material-icons">inventory</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Activate'); ?>/<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Deactivate'); ?>
    </button>
  </form>

  <?php if (isset($status_catalog)) : ?>
    <div class="catalog-status <?php echo $status_catalog === 'Catalogo activado' ? 'catalog-status-active' : 'catalog-status-inactive'; ?>">
      <span class="material-icons">inventory</span>
      <?php echo $status_catalog; ?>
    </div>
  <?php endif ?>

  <?php

  if (isset($_SESSION['desactivado'])) {
    echo '<div class="alert alert-warning">' . $_SESSION['desactivado'] . '</div>';
    unset($_SESSION['desactivado']);
  }
  if (isset($_SESSION['activado'])) {
    echo '<div class="alert alert-success">' . $_SESSION['activado'] . '</div>';
    unset($_SESSION['activado']);
  }
  if (isset($_SESSION['set'])) {
    echo '<div class="alert alert-warning">' . $_SESSION['set'] . '</div>';
    unset($_SESSION['set']);
  }
  ?>
</center>
<a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/create_product'); ?>" class="btn btn-primary">
  <span class="material-icons">description</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create'); ?>
</a>
<br>
<table>
  <thead>
    <tr>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'ID'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Code'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Image'); ?></th>
      <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Actions'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $row) : ?>
      <tr>
        <td><?php echo $row->id; ?></td>
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->code; ?></td>
        <td>
          <?php if (!empty($row->image)) : ?>
            <img src="<?php echo '/livehelperchat/lhc_web/' . htmlspecialchars($row->image); ?>"
              alt="<?php echo htmlspecialchars($row->name); ?>"
              class="product-image"
              style="max-width:100px; max-height:100px;">
          <?php else : ?>
            No Image
          <?php endif; ?>
        </td>
        <td>
          <form method="post" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/create_product') ?>" onsubmit="return confirm('Esta acción es irreversible, ¿desea eliminar el producto? ');">
            <input type="hidden" name="product_id_delete" value="<?php echo htmlspecialchars($row->id); ?>">
            <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delete'); ?></button>
          </form>
          <form method="update" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/edit_product') ?>">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row->id); ?>">
            <button type="submit" class="btn btn-warning"><span class="material-icons">equalizer</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Edit'); ?></button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
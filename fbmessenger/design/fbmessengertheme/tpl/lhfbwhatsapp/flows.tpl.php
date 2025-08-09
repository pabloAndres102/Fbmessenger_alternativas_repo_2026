<!-- <h1><?php print_r($flows) ?></h1> -->


<a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/createflow'); ?>" class="btn btn-primary"><span class="material-icons">add_circle_outline</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create'); ?></a>
<br><br>

<table class="table table-sm" ng-non-bindable>
    <thead>
        <tr>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Status'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Category'); ?></th>
            <th>Validation Errors</th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'ID'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($flows['data'] as $flow) : ?>
            <tr>
                <td><?php echo $flow['name']; ?></td>
                <td><?php echo $flow['status']; ?></td>
                <td><?php echo implode(', ', $flow['categories']); ?></td>
                <td><?php echo implode(', ', $flow['validation_errors']); ?></td>
                <td><?php echo $flow['id']; ?></td>
                <td>
                <td>
                    <form method="post" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/deleteflow') ?>" onsubmit="return confirm('Esta acción es irreversible, ¿desea eliminar el flujo? ');">
                        <input type="hidden" name="flow_id" value="<?php echo htmlspecialchars_decode($flow['id']); ?>">
                        <button type="submit" class="btn btn-danger"><span class="material-icons">
                                delete_forever
                            </span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delete'); ?></button>
                    </form>
                </td>
                <td>
                    <form method="update" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/updateflow') ?>">
                        <input type="hidden" name="flow_id" value="<?php echo htmlspecialchars_decode($flow['id']); ?>">
                        <button type="submit" class="btn btn-warning"><span class="material-icons">
                                system_security_update_good
                            </span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Update'); ?></button>
                    </form>
                </td>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
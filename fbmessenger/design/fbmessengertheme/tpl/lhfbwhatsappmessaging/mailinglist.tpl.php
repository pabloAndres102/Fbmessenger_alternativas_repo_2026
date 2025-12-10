<style>
    /* === Estilos visuales consistentes con el formulario de Enviar SMS === */

    h2.fs-4 {
        font-weight: 600;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
        font-size: 0.95rem;
    }

    .table thead {
        font-weight: 600;
    }


    .card {
        border-radius: 12px;
    }

    .badge {
        font-weight: 500;
        font-size: 0.85rem;
    }

    .btn-outline-primary {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        background-color: #3b82f6;
        box-shadow: 0 2px 6px rgba(59,130,246,0.3);
    }

    .material-icons {
        vertical-align: middle;
    }

    a.text-decoration-none:hover {
        text-decoration: underline;
    }
</style>
<h2 class="fs-4 mb-3 d-flex align-items-center gap-2">
    📇 Listado de Contactos
</h2>

<a class="btn btn-outline-primary mb-3 d-flex align-items-center gap-2" 
   href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/newmailinglist')?>">
    <span class="material-icons" style="font-size:18px;">add</span>
    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Create contact list');?>
</a>

<?php include(erLhcoreClassDesign::designtpl('lhfbwhatsappmessaging/parts/search_panel_mailinglist.tpl.php')); ?>

<?php if (isset($items)) : ?>
<div class="card p-4 shadow-sm" style="border-radius: 12px; ">
    <table class="table table-hover align-middle" width="100%" ng-non-bindable>
        <thead class="table">
        <tr>
            <th>📛 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Name');?></th>
            <th>👥 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Members');?></th>
            <th>👤 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','User');?></th>
            <th>📅 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Created at');?></th>
            <th>🔐 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Type');?></th>
            <th width="1%"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td>
                    <?php if ($item->can_edit) : ?>
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editmailinglist')?>/<?php echo $item->id?>" class="text-decoration-none text-primary fw-semibold d-flex align-items-center gap-1">
                            <span class="material-icons" style="font-size:18px;">edit</span>
                            <?php echo htmlspecialchars($item->name)?>
                        </a>
                    <?php else : ?>
                        <span class="text-muted d-flex align-items-center gap-1">
                            <span class="material-icons" style="font-size:18px;">edit_off</span>
                            <?php echo htmlspecialchars($item->name)?>
                        </span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/mailingrecipient')?>/(ml)/<?php echo $item->id?>" 
                       class="text-decoration-none text-secondary d-flex align-items-center gap-1">
                        <span class="material-icons" style="font-size:18px;">list</span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','List of members');?> 
                        (<?php echo $item->total_contacts?>)
                    </a>
                </td>
                <td><?php echo htmlspecialchars((string)$item->user); ?></td>
                <td><?php echo htmlspecialchars((string)$item->created_at_front); ?></td>
                <td>
                    <?php if ($item->private == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactList::LIST_PUBLIC) : ?>
                        <span class="badge bg-success d-flex align-items-center gap-1 p-2 rounded-3">
                            <span class="material-icons" style="font-size:18px;">public</span>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Public');?>
                        </span>
                    <?php else : ?>
                        <span class="badge bg-secondary d-flex align-items-center gap-1 p-2 rounded-3">
                            <span class="material-icons" style="font-size:18px;">vpn_lock</span>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Private');?>
                        </span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($item->can_delete) : ?>
                        <a class="text-danger csfr-required" 
                           onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/messages','The contact list and its contacts will be deleted. Are you sure?');?>')" 
                           href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/deletemailinglist')?>/<?php echo $item->id?>">
                            <i class="material-icons" style="font-size:20px;">delete</i>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/secure_links.tpl.php')); ?>

    <?php if (isset($pages)) : ?>
        <div class="mt-3">
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
        </div>
    <?php endif;?>
</div>
<?php endif; ?>



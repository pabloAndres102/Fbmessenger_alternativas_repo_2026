<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhchat', 'setsubject')) : ?>
    <tr>

        <td colspan="2">
   
            <h6 class="fw-bold"><i class="material-icons">description</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/subject', 'Subject') ?>
                <button type="button" class="btn btn-xs btn-link text-muted pb-1 ps-1" onclick="return lhc.revealModal({'url':'<?php echo erLhcoreClassDesign::baseurl('chat/subject') ?>/<?php echo $chat->id ?>'})"><i class="material-icons me-0">&#xE145;</i></button>
            </h6>
            <?php $subjectsChat = erLhAbstractModelSubjectChat::getList(array('filter' => array('chat_id' => $chat->id)));
            foreach ($subjectsChat as $subject) : ?><button class="btn btn-xs btn-outline-info"><?php echo htmlspecialchars($subject) ?></button>&nbsp;<?php endforeach; ?>

                <?php foreach ($chat->aicons as $aicon) : ?>
                    <span class="material-icons" title="<?php print isset($aicon['t']) ? htmlspecialchars($aicon['t']) : htmlspecialchars($aicon['i']) ?>" <?php if (isset($aicon['c']) && $aicon['c'] != '') : ?>style="color:<?php echo htmlspecialchars($aicon['c']) ?>" <?php endif; ?>><?php echo htmlspecialchars(is_array($aicon) && isset($aicon['i']) ? $aicon['i'] : $aicon) ?></span>
                <?php endforeach; ?>
                <br><br>
                <h6 class="fw-bold"><span class="material-icons">view_kanban</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Embudo') ?>
                    <button type="button" class="btn btn-xs btn-link text-muted pb-1 ps-1" onclick="return lhc.revealModal({
                                                                'url': '<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/kanban_status2'); ?>?id=<?php echo urlencode($chat->id); ?>'
                                                                })"><i class="material-icons me-0">&#xE145;</i></button>
                </h6>
                <br>
                <?php if ($chat->kanban_id > 0) : ?>
                    <?php $status_kanban = erLhcoreClassModelKanban::fetch($chat->kanban_id); ?>
                    <span style="background-color: <?php echo htmlspecialchars($status_kanban->color); ?>; padding: 5px; border-radius: 3px; color: white;">
                        <?php echo htmlspecialchars($status_kanban->nombre); ?>
                    </span>
                <?php endif; ?>
                <br>
        </td>
		
    </tr>
<?php endif; ?>

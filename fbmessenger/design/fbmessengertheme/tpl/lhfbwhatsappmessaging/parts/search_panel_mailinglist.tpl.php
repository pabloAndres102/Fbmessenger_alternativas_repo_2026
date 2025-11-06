<form ng-non-bindable 
      action="<?php echo $input->form_action?>" 
      method="get" 
      name="SearchFormRight" 
      class="card p-3 shadow-sm border-0" 
      style="max-width:100%; font-size:13px;" 
      autocomplete="off">

    <input type="hidden" name="doSearch" value="1">

    <div class="container-fluid">
        <!-- Primera fila -->
        <div class="row g-2 align-items-end mb-1">
            <div class="col-md-3 col-6">
                <label class="form-label mb-1 fw-semibold">Nombre</label>
                <input type="text" class="form-control form-control-sm" name="name"
                       value="<?php echo htmlspecialchars((string)$input->name)?>" />
            </div>

            <div class="col-md-3 col-6">
                <label class="form-label mb-1 fw-semibold">Propietario</label>
                <?php echo erLhcoreClassRenderHelper::renderMultiDropdown(array(
                    'input_name'     => 'user_ids[]',
                    'optional_field' => 'Selecciona propietario',
                    'selected_id'    => $input->user_ids,
                    'css_class'      => 'form-control form-control-sm',
                    'display_name'   => 'name_official',
                    'ajax'           => 'users',
                    'list_function_params' => array_merge(erLhcoreClassGroupUser::getConditionalUserFilter(),array('sort' => '`name` ASC', 'limit' => 50)),
                    'list_function'  => 'erLhcoreClassModelUser::getUserList',
                )); ?>
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="row g-2 align-items-end">
            <!-- Fecha desde -->
            <div class="col-auto">
                <label class="form-label mb-1 fw-semibold">Fecha desde</label>
                <input type="text" class="form-control form-control-sm" name="timefrom" id="id_timefrom"
                       placeholder="Ej: 2025-10-28"
                       value="<?php echo htmlspecialchars((string)$input->timefrom)?>" />
            </div>

            <!-- Hora desde -->
            <div class="col-auto">
                <label class="form-label mb-1 fw-semibold d-block">
                    Horas y minutos desde <small class="text-muted">[<?php echo date('H:i:s')?>]</small>
                </label>
                <div class="d-flex gap-1">
                    <select name="timefrom_hours" class="form-select form-select-sm">
                        <option value="">hh</option>
                        <?php for ($i=0;$i<=23;$i++): ?>
                            <option value="<?php echo $i?>" <?php if (isset($input->timefrom_hours) && $input->timefrom_hours===$i) : ?>selected<?php endif;?>><?php echo str_pad($i,2,'0',STR_PAD_LEFT)?></option>
                        <?php endfor;?>
                    </select>
                    <select name="timefrom_minutes" class="form-select form-select-sm">
                        <option value="">mm</option>
                        <?php for ($i=0;$i<=59;$i++): ?>
                            <option value="<?php echo $i?>" <?php if (isset($input->timefrom_minutes) && $input->timefrom_minutes===$i) : ?>selected<?php endif;?>><?php echo str_pad($i,2,'0',STR_PAD_LEFT)?></option>
                        <?php endfor;?>
                    </select>
                    <select name="timefrom_seconds" class="form-select form-select-sm">
                        <option value="">ss</option>
                        <?php for ($i=0;$i<=59;$i++): ?>
                            <option value="<?php echo $i?>" <?php if (isset($input->timefrom_seconds) && $input->timefrom_seconds===$i) : ?>selected<?php endif;?>><?php echo str_pad($i,2,'0',STR_PAD_LEFT)?></option>
                        <?php endfor;?>
                    </select>
                </div>
            </div>

            <!-- Fecha hasta -->
            <div class="col-auto">
                <label class="form-label mb-1 fw-semibold">Fecha hasta</label>
                <input type="text" class="form-control form-control-sm" name="timeto" id="id_timeto"
                       placeholder="Ej: 2025-11-04"
                       value="<?php echo htmlspecialchars((string)$input->timeto)?>" />
            </div>

            <!-- Hora hasta -->
            <div class="col-auto">
                <label class="form-label mb-1 fw-semibold d-block">
                    Horas y minutos hasta <small class="text-muted">[<?php echo date('H:i:s')?>]</small>
                </label>
                <div class="d-flex gap-1">
                    <select name="timeto_hours" class="form-select form-select-sm">
                        <option value="">hh</option>
                        <?php for ($i=0;$i<=23;$i++): ?>
                            <option value="<?php echo $i?>" <?php if (isset($input->timeto_hours) && $input->timeto_hours===$i) : ?>selected<?php endif;?>><?php echo str_pad($i,2,'0',STR_PAD_LEFT)?></option>
                        <?php endfor;?>
                    </select>
                    <select name="timeto_minutes" class="form-select form-select-sm">
                        <option value="">mm</option>
                        <?php for ($i=0;$i<=59;$i++): ?>
                            <option value="<?php echo $i?>" <?php if (isset($input->timeto_minutes) && $input->timeto_minutes===$i) : ?>selected<?php endif;?>><?php echo str_pad($i,2,'0',STR_PAD_LEFT)?></option>
                        <?php endfor;?>
                    </select>
                    <select name="timeto_seconds" class="form-select form-select-sm">
                        <option value="">ss</option>
                        <?php for ($i=0;$i<=59;$i++): ?>
                            <option value="<?php echo $i?>" <?php if (isset($input->timeto_seconds) && $input->timeto_seconds===$i) : ?>selected<?php endif;?>><?php echo str_pad($i,2,'0',STR_PAD_LEFT)?></option>
                        <?php endfor;?>
                    </select>
                </div>
            </div>

            <!-- Botón -->
            <div class="col-auto">
                <button type="submit" name="doSearch" class="btn btn-primary btn-sm mt-3">
                    Buscar
                </button>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#id_timefrom,#id_timeto').fdatepicker({ format: 'yyyy-mm-dd' });
        });
    </script>
</form>

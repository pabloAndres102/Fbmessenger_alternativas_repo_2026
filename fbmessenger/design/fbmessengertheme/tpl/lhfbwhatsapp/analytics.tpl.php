<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        /* Estilo para etiquetas de los inputs */
    label {
        font-weight: bold;
    }

    /* Estilo para los inputs */
    input[type="date"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 5px;
    }

    /* Estilo para el botón */
    input[type="submit"] {
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    </style>
<div style="width: 300px; margin-right: 20px; float: left; 
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 6px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px; background-color: #ffffff; padding: 20px;">
<form method="post" action="" onsubmit="return validateForm();">
    <label for="start"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Start date'); ?>&nbsp;&nbsp;&nbsp;</label>
    <input type="date" name="start" id="start" required>
    <br><br>
    <label for="end"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'End date'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <input type="date" name="end" id="end" required>
    <br><br>
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sender Phone'); ?></label>
    <select name="phone_number" id="phone_number" class="form-control form-control-sm" title="display_phone_number | verified_name | code_verification_status | quality_rating">
        <?php foreach ($phones as $phone) : ?>
            <option value="<?php echo $phone['display_phone_number'] ?>">
                <?php echo $phone['display_phone_number'], ' | ', $phone['verified_name'], ' | ', $phone['code_verification_status'], ' | ', $phone['quality_rating'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Granularity'); ?></label>
    <select name="granularity" id="granularity" class="form-control form-control-sm">
        <?php
        $granularities = ['DAILY','MONTHLY'];
        foreach ($granularities as $granularity) : ?>
            <option value="<?php echo $granularity ?>">
                <?php if($granularity == 'DAILY'){
                    echo 'DIARIO';
                } else{
                    echo 'MENSUAL';
                }
                
                ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <input type="submit" value="Return">
</form>
</div>

<?php

if (isset($data)) {
    // Obtén los datos y ordénalos por fecha
    $data_points = $data['conversation_analytics']['data'][0]['data_points'];
    usort($data_points, function ($a, $b) {
        return $a['start'] - $b['start'];
    });
 
?>
    <table>
        <thead>
            <tr>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Start'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'End'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Conversation'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Conversation type'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Conversation category'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Direction of conversation'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Cost'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_points as $data_point) : ?>
                <tr>
                    <td><?php echo date('Y-m-d', $data_point['start']); ?></td>
                    <td><?php echo date('Y-m-d', $data_point['end']); ?></td>
                    <td><?php echo $data_point['conversation']; ?></td>
                    <td><?php echo $data_point['conversation_type']; ?></td>
                    <td><?php $category = htmlspecialchars($data_point['conversation_category']); 
                     // Mostrar categorías en mayúsculas y en español
                     if ($category == 'MARKETING') {
                         echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'MARKETING');
                     } elseif ($category == 'UTILITY') {
                         echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'UTILITY');
                     } elseif ($category == 'AUTHENTICATION') {
                         echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'AUTHENTICATION');
                     } elseif ($category == 'SERVICE') {
                        echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'SERVICE');
                    }elseif ($category == 'UNKNOWN') {
                        echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'UNKNOWN');
                    }else{
                        echo $category;
                    }


                    
                    ?></td>
                    <td><?php $initiated = htmlspecialchars($data_point['conversation_direction']);
                            // Mostrar categorías en mayúsculas y en español
                            if ($initiated == 'BUSINESS_INITIATED') {
                                echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'BUSINESS_INITIATED');
                            }elseif ($initiated == 'USER_INITIATED') {
                                echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'USER_INITIATED');
                            }elseif ($initiated == 'UNKNOWN') {
                                echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'UNKNOWN');
                            } else {
                                echo $initiated; // Mostrar categoría original si no coincide con las categorías hardcoded
                            }
                        ?>
                        
                    </td>
                    <td><?php echo $data_point['cost']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}
?>

<script>
    function validateForm() {
        var startDate = new Date(document.getElementById('start').value);
        var endDate = new Date(document.getElementById('end').value);

        if (endDate < startDate) {
            alert("La fecha de fin no puede ser anterior a la fecha de inicio.");
            return false; // Evita el envío del formulario
        }

        return true; // Permite el envío del formulario si las fechas son válidas
    }
</script>


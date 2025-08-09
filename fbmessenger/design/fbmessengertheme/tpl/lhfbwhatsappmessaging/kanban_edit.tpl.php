<style>
  .tarjeta {
    border: 1px solid #ddd;
    border-radius: 12px; /* Esquinas redondeadas */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Sombra más suave */
    padding: 20px;
    text-align: center;
    width: 400px;
    margin: 20px auto; /* Centrado horizontal y con margen vertical */
    background-color: #fff; /* Fondo blanco */
    transition: transform 0.3s ease; /* Transición suave en la transformación */
  }

  .tarjeta:hover {
    transform: translateY(-5px); /* Efecto de elevación al pasar el cursor */
  }

  .tarjeta input[type="text"],
  .tarjeta input[type="submit"],
  .tarjeta input[type="number"],
  .tarjeta select,
  .tarjeta input[type="color"] {
    width: calc(100% - 22px); /* Ancho ajustado para un padding consistente */
    padding: 10px;
    margin: 10px 0; /* Margen aumentado para un mejor espaciado */
    border: 1px solid #ccc;
    border-radius: 8px; /* Esquinas redondeadas */
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra interna */
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Transición suave para el enfoque */
  }

  .tarjeta input[type="text"]:focus,
  .tarjeta input[type="number"]:focus,
  .tarjeta select:focus,
  .tarjeta input[type="color"]:focus {
    border-color: #007bff; /* Color del borde al enfocar */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Sombra exterior al enfocar */
  }

  .tarjeta label {
    text-align: left;
    display: block;
    margin-bottom: 5px;
    font-weight: bold; /* Etiquetas en negrita */
    color: #333; /* Color de texto más oscuro */
  }

  .tarjeta .btn {
    width: 100%; /* Botón de ancho completo */
    padding: 12px; /* Padding mayor para el botón */
    border: none;
    border-radius: 8px; /* Esquinas redondeadas */
    cursor: pointer;
    font-size: 1rem; /* Tamaño de fuente más grande */
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    background-color: #ffc107; /* Color del botón de advertencia */
    color: #212529; /* Color de texto oscuro */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Transición suave para el hover */
  }

  .tarjeta .btn:hover {
    background-color: #e0a800; /* Amarillo más oscuro al pasar el cursor */
    transform: translateY(-2px); /* Efecto de elevación leve al pasar el cursor */
  }

  .tarjeta .btn .material-icons {
    font-size: 1.2rem; /* Ajuste del tamaño del ícono */
  }
</style>

<div class="tarjeta">
    <form method="POST" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_edit') ?>">
        <label for="name_status"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></label>
        <input type="text" id="name_status" name="name_status" value="<?php echo htmlspecialchars($status->nombre); ?>" required><br>

        <label for="position">Posición</label>
        <input type="number" id="position" name="position" value="<?php echo htmlspecialchars($status->posicion); ?>" required><br>

        <label for="color">Color</label>
        <input type="hidden" id="status_edit" name="status_edit" value="<?php echo htmlspecialchars($_GET['status_id']); ?>"><br>
        <input type="color" id="color" name="color" value="<?php echo htmlspecialchars($status->color); ?>"><br>

        <button type="submit" class="btn btn-warning">
            <span class="material-icons">edit</span>
            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Edit'); ?>
        </button>
    </form>
</div>

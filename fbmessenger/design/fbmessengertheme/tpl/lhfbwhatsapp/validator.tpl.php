<style>
    .validator-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        padding: 40px 20px;
    }

    .validator-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
        padding: 30px 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .validator-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .validator-icon {
        font-size: 60px;
        margin-bottom: 15px;
    }

    .validator-title {
        font-size: 1.3em;
        color: #333;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .validator-desc {
        color: #777;
        font-size: 0.95em;
        margin-bottom: 15px;
    }

    .btn-validator {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 6px;
        color: white;
        font-weight: bold;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-wp {
        background-color: #25D366;
    }

    .btn-wp:hover {
        background-color: #1ebe5d;
    }

    .btn-email {
        background-color: #007bff;
    }

    .btn-email:hover {
        background-color: #0066d1;
    }

    .page-header {
        text-align: center;
        margin-top: 20px;
    }

    .page-header h2 {
        color: #444;
    }

    .page-header p {
        color: #666;
    }

    @media (max-width: 700px) {
        .validator-container {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<div class="page-header">
    <h2>🔍 Centro de Validación</h2>
    <p>Selecciona el tipo de validador que deseas usar:</p>
</div>

<div class="validator-container">

    <!-- WhatsApp Validator -->
    <div class="validator-card" onclick="location.href='<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/validate_number'); ?>'">
        <div class="validator-icon">📱</div>
        <div class="validator-title">Validador de WhatsApp</div>
        <div class="validator-desc">Verifica si un número tiene cuenta activa en WhatsApp.</div>
        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/validate_number'); ?>" class="btn-validator btn-wp">Ir al Validador</a>
    </div>

    <!-- Email Validator -->
    <div class="validator-card" onclick="location.href='<?php echo erLhcoreClassDesign::baseurl('validator/email'); ?>'">
        <div class="validator-icon">✉️</div>
        <div class="validator-title">Validador de Email</div>
        <div class="validator-desc">Comprueba si una dirección de correo electrónico es válida.</div>
        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/validate_email'); ?>" class="btn-validator btn-email">Ir al Validador</a>
    </div>

</div>

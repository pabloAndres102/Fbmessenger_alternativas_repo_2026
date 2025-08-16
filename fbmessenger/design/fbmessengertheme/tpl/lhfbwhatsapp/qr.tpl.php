<style>
.page-title {
    text-align: center;
    font-size: 2rem;
    margin-top: 30px;
    color: #333;
    font-weight: bold;
}

.page-description {
    text-align: center;
    max-width: 700px;
    margin: 10px auto 40px;
    font-size: 1.1rem;
    color: #555;
}

.qr-list {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: center;
    margin-top: 20px;
}

.qr-item {
    background: #fff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    text-align: center;
    max-width: 340px;
    transition: transform 0.3s ease;
}

.qr-item:hover {
    transform: scale(1.04);
}

.qr-item img {
    width: 260px;
    border-radius: 12px;
    margin-bottom: 15px;
    transition: transform 0.3s ease;
}

.qr-item img:hover {
    transform: scale(1.07);
}

.qr-item .name {
    font-weight: bold;
    font-size: 1.4rem;
    margin-bottom: 6px;
    color: #222;
}

.qr-item .phone {
    color: #555;
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.qr-description {
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 18px;
    padding: 0 5px;
}

.qr-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.qr-buttons a, .qr-buttons button {
    padding: 12px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-whatsapp {
    background-color: #25D366;
}

.btn-whatsapp:hover {
    background-color: #1ebe5b;
    transform: translateY(-2px);
}

.btn-copy {
    background-color: #007bff;
}

.btn-copy:hover {
    background-color: #0069d9;
    transform: translateY(-2px);
}
</style>

<h1 class="page-title">Códigos QR de tus Números de WhatsApp</h1>
<p class="page-description">
    Escanea el código QR con tu dispositivo móvil para iniciar una conversación directamente en WhatsApp, 
    o utiliza los botones para abrir el chat o copiar el enlace y compartirlo fácilmente.
</p>

<div class="qr-list">
    <?php foreach ($qrDataList as $item): ?>
        <div class="qr-item">
            <img src="<?php echo $item['qr_image']; ?>" alt="QR de <?php echo htmlspecialchars($item['verified_name']); ?>">
            <div class="name"><?php echo htmlspecialchars($item['verified_name']); ?></div>
            <div class="phone"><?php echo htmlspecialchars($item['display_phone_number']); ?></div>
            <p class="qr-description">
                Este código QR te permitirá comunicarte rápidamente con <strong><?php echo htmlspecialchars($item['verified_name']); ?></strong>
                a través de WhatsApp. ¡Escanéalo o usa las opciones de abajo!
            </p>
            <div class="qr-buttons">
                <a href="<?php echo htmlspecialchars($item['whatsapp_url']); ?>" target="_blank" class="btn-whatsapp">
                    📲 Abrir en WhatsApp
                </a>
                <button class="btn-copy" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($item['whatsapp_url']); ?>')">
                    📋 Copiar enlace
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

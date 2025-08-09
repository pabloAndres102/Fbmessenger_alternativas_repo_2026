<style>
   
    .container {
        background: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        box-sizing: border-box;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .container:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 25px;
        text-align: left;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #666;
        font-size: 14px;
    }

    .form-group input[type="text"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f9f9f9;
    }

    .form-group input[type="file"] {
        padding: 10px;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="file"]:focus {
        border-color: #ff5f6d;
        box-shadow: 0 0 10px rgba(255, 95, 109, 0.5);
        outline: none;
    }

    .form-group button {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #ff5f6d, #ffc371);
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .form-group button:hover {
        background: linear-gradient(135deg, #ffc371, #ff5f6d);
        transform: scale(1.05);
    }

    .form-group img {
        max-width: 100px;
        border-radius: 8px;
        margin-top: 10px;
        transition: transform 0.3s ease;
    }

    .form-group img:hover {
        transform: scale(1.1);
    }
</style>

<br><br>
<div class="container">
    <h1>Edit Product</h1>
    <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/edit_product'); ?>?product_id=<?php echo $product->id; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Product name'); ?>:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product->name); ?>" required>
        </div>
        <div class="form-group">
            <label for="code"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Product code'); ?>:</label>
            <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($product->code); ?>" required>
        </div>
        <div class="form-group">
            <label for="image"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Product image'); ?>:</label>
            <input type="file" id="image" name="image">
            <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Current image'); ?>: <img src="/livehelperchat/lhc_web/<?php echo $product->image; ?>" alt="Product Image"  width="300px"></p>
        </div>
        <div class="form-group">
            <button type="submit"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Update product'); ?></button>
        </div>
    </form>
</div>


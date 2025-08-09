<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/create_product.tpl.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $code = $_POST['code'];
    
    // Handle the file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Check if the directory exists, if not, create it
        $uploadFileDir = 'uploads_product/' . date('Y') . 'y/' . date('m') . '/' . date('d') . '/au/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        // Move the file to the destination path
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            // Convert backslashes to slashes for the image path
            $image = str_replace('\\', '/', $dest_path);
        } else {
            echo 'There was an error moving the uploaded file.';
            exit;
        }
    } else {
        $image = ''; // Set a default image path or handle accordingly
    }

    // Create a new product instance
    $product = new erLhcoreClassModelCatalog();
    $product->name = $name;
    $product->code = $code;
    $product->image = $image;

    // Save the product to the database
    try {
        $product->saveThis();
        erLhcoreClassModule::redirect('fbwhatsapp/catalog_products');
    } catch (Exception $e) {
        $tpl->set('error',$e->getMessage());
    }
}



if(isset($_POST['product_id_delete'])){
    $ObjectData = erLhcoreClassModelCatalog::fetch($_POST['product_id_delete']);
    $ObjectData->removeThis();
    erLhcoreClassModule::redirect('fbwhatsapp/catalog_products');
}
// solucion eliminacion de columna  




$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/catalog_products'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Catalog')
    ),
    array(  
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create')
    )
);

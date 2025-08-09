<?php

$response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('fbwhatsapp.create', array());
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/create.tpl.php');

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
  array(
    'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
    'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Facebook chat')
  ),
  array(
    'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/templates'),
    'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Templates')
  ),
  array(
    'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create')
  )
);



$components = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $buttons = [];
  for ($i = 1; $i <= 10; $i++) {
    $buttonText = isset($_POST["button$i"]) ? $_POST["button$i"] : null;
    if (!empty($buttonText)) {
        $buttons[] = [
            "type" => "QUICK_REPLY",
            "text" => $buttonText
        ];
    }
}
$urlButtons = [];
  for ($i = 1; $i <= 2; $i++) {
    $buttonWebText = isset($_POST["buttonWebText$i"]) ? $_POST["buttonWebText$i"] : null;
    $buttonWebUrl = isset($_POST["buttonWebUrl$i"]) ? $_POST["buttonWebUrl$i"] : null;
    if (!empty($buttonWebText) && !empty($buttonWebUrl)) {
      $urlButtons[] = [
        "type" => "URL",
        "text" => $buttonWebText,
        "url" => $buttonWebUrl
      ];
    }
  }
  if (!empty($urlButtons)) {
    $buttons = array_merge($buttons, $urlButtons);
  }

  $buttonCallbackPhone = $_POST['buttoCallbackCountry'] . $_POST['buttonCallbackPhone'];
  $buttonCallbackText = $_POST['buttonCallbackText'];
  if (!empty($buttonCallbackPhone)) {
      $buttons[] = [
          "type" => "PHONE_NUMBER",
          "text" => $buttonCallbackText,
          "phone_number" => $buttonCallbackPhone
      ];
  }


  $token = $data['whatsapp_access_token'];
  $app_id = $data['app_id'];
  $whatsapp_business_account_id = $data['whatsapp_business_account_id'];
  $templateName = strtolower($_POST['templateName']);
  $templateCat = strtolower($_POST['templateCat']);
  $language = $_POST['language'];
  $text = $_POST['text'];
  $headertype = isset($_POST['header']) ? $_POST['header'] : "";
 
  $footer = $_POST['footer'];
  $button1 = $_POST['button1'];
  $button2 = $_POST['button2'];
  $button3 = $_POST['button3'];
  $textHeader = isset($_POST['campoDeTexto']) ? $_POST['campoDeTexto'] : "";
  $inputCuerpo1 = $_POST['variableCuerpo'];
  $inputCuerpo2 = $_POST['variableCuerpo2'];
  $inputCuerpo3 = $_POST['variableCuerpo3'];
  $inputCuerpo4 = $_POST['variableCuerpo4'];
  $inputCuerpo5 = $_POST['variableCuerpo5'];
  $variableHeader = isset($_POST['inputNuevo']) ? $_POST['inputNuevo'] : "";


  $flow_text = $_POST['flow_text'];
  $flow_id = $_POST['flow_id'];
  $flow_action = $_POST['flow_action'];
  $navigate_screen = $_POST['navigate_screen'];

  $buttonCatalog = $_POST['buttonCatalog'];
  $buttonMPM = $_POST['buttonMPM'];
  
  if(isset($_POST['buttonMPM'])){
    $headertype = 'TEXT';
  }
  

  $offert = $_POST['offert'];
  $buttonOffertURL = $_POST['buttonOffertURL'];
  $buttonNameOffertURL = $_POST['buttonNameOffertURL'];



  $buttonWebText = $_POST['buttonWebText'];
  $buttonWebUrl = $_POST['buttonWebUrl'];

  $archivo_temporal = $_FILES['archivo']['tmp_name'];
  $nombre_archivo = $_FILES["archivo"]["name"];
  $tipo_archivo = $_FILES["archivo"]["type"];
  $tamaño_archivo = $_FILES["archivo"]["size"];

  $nombrepaquete =  $_POST['Nombrepaquete'];
  $hashpaquete =  $_POST['Hashpaquete'];
  $buttonAutocompletar =  $_POST['buttonAutocompletar'];
  $caducidad = $_POST['caducidad'];
  $otp_type = $_POST['otp_type'];

  if (!empty($archivo_temporal)) {
    $archivo_bytes = file_get_contents($archivo_temporal);
  }

  # Create Session

  $ch = curl_init();
  $nombre_archivo = str_replace(' ', '', $nombre_archivo);

  curl_setopt_array($ch, array(
    CURLOPT_URL => 'https://graph.facebook.com/v17.0/' . $app_id . '/uploads?file_length=' . $tamaño_archivo . '&file_type=' . $tipo_archivo . '&file_name=' . $nombre_archivo . '', # Revisar en caso de que requiera la extension el nombre
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $token
    ),
  ));

  $responseid = curl_exec($ch);
  $response_data = json_decode($responseid, true);
  $session_id = $response_data['id'] ?? "";

  curl_close($ch);

  # UPLOAD

  $ch2 = curl_init();
  $post_data = isset($archivo_bytes) ? $archivo_bytes : $textHeader;

  curl_setopt_array($ch2, array(
    CURLOPT_URL => 'https://graph.facebook.com/v17.0/' . $session_id . '',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $post_data,
    CURLOPT_HTTPHEADER => array(
      'file_offset: 0',
      'Content-Type: application/json',
      'Authorization: OAuth ' . $token
    ),
  ));

  $response = curl_exec($ch2);
  $response_data2 = json_decode($response, true);

  $uploadedFileId = $response_data2['h'] ?? "";

  curl_close($ch2);

  #Create template
  $button = [];

  // if (!empty($button1)) {
  //   $button[] =  [
  //     "type" => "QUICK_REPLY",
  //     "text" => $button1
  //   ];
  // };

  // if (!empty($button2)) {
  //   $button[] =  [
  //     "type" => "QUICK_REPLY",
  //     "text" => $button2
  //   ];
  // };

  // if (!empty($button3)) {
  //   $button[] =  [
  //     "type" => "QUICK_REPLY",
  //     "text" => $button3
  //   ];
  // };
  if (!empty($buttons)) {
    $components[] = [
        "type" => "BUTTONS",
        "buttons" => $buttons
    ];
}


  if (!empty($buttonCatalog)) {
    $button[] =  [
      "type" => "CATALOG",
      "text" => "View catalog"
    ];
  };

  if (!empty($offert)) {

    $components[] = [
      "type" => "limited_time_offer",
      "limited_time_offer" => [
        "text" => "Oferta limitada!",
        "has_expiration" => 1
      ]
    ];


    $button[] =  [
      "type" => "copy_code",
      "example"=> "CARIBE25"
    ];

    $button[] = [
      "type" => "url",
      "text" => $buttonNameOffertURL,
      "url" => $buttonOffertURL,
    ];
  }

  if (!empty($buttonMPM)) {
    $button[] =  [
      "type" => "MPM",
      "text" => "View items"
    ];
  };


  if (!empty($buttonWebText)) {
    $button[] =  [
      "type" => "URL",
      "text" => $buttonWebText,
      "url" => $buttonWebUrl
    ];
  };

  if (!empty($flow_id)) {
    $button[] =  [
      "type" => "FLOW",
      "text" => $flow_text,
      "flow_id" => $flow_id,
      "flow_action" => $flow_action,
      "navigate_screen" => $navigate_screen
    ];
  };

  $url = 'https://graph.facebook.com/v19.0/' . $whatsapp_business_account_id . '/message_templates';


  $bodytext = [
    "type" => "BODY",
    "text" => $text,
  ];

  if (!empty($inputCuerpo1) || !empty($inputCuerpo2) || !empty($inputCuerpo3) || !empty($inputCuerpo4) || !empty($inputCuerpo5)) {
    $exampleData = [$inputCuerpo1, $inputCuerpo2, $inputCuerpo3, $inputCuerpo4, $inputCuerpo5];

    $bodytext["example"] = [
      "body_text" => [$exampleData]
    ];
  }
  $footerParams = [
    "type" => "FOOTER",
    "text" => $footer
  ];

  $buttonParams =       [
    "type" => "BUTTONS",
    "buttons" => $button
  ];

  if (!empty($textHeader)) {
    $header = [
      "type" => "HEADER",
      "format" => $headertype,
      "text" => $textHeader,
    ];

    if (!empty($variableHeader)) {
      $header["example"] = ["header_text" => [$variableHeader]];
    }
  } else {
    $header = [
      "type" => "HEADER",
      "format" => $headertype,
      "example" => ["header_handle" => [$uploadedFileId]],
    ];
  }




  if (!empty($headertype)) {
    $components[] = $header;
  }

  if (!empty($text)) {
    $components[] = $bodytext;
  };

  if (!empty($footer)) {
    $components[] = $footerParams;
  };

  if (!empty($button)) {
    $components[] = $buttonParams;
  };



  // if (!empty($textHeader)) {
  //   $header = [
  //     "type" => "HEADER",
  //     "format" => $headertype,
  //     "text" => $textHeader,
  //   ];

  //   if (!empty($variableHeader)) {
  //     $header["example"] = ["header_text" => [$variableHeader]];
  //   }

  //   $components[] = $header; // Agregar el componente de tipo header solo si existe.
  // }


  $componentsAuthentication = [];

  $bodyAuthentication = [
    "type" => "BODY",
    "add_security_recommendation" => true #Agregar recomendación de seguridad
  ];

  $footerAuthentication = [
    "type" => "FOOTER",
    "code_expiration_minutes" => $caducidad #Agrega la fecha de caducidad para el código
  ];

  $buttonsAuthentication = [
    "type" => "BUTTONS",
    "buttons" => [
      [
        "type" => "OTP",
        "otp_type" => $otp_type,
        "text" => "", #Copiar código
        "autofill_text" => $buttonAutocompletar, #Autocompletar button
        "package_name" => $nombrepaquete,  #nombre del paquete
        "signature_hash" => $hashpaquete
      ] # Hash de firma de la app
    ]
  ];

  $componentsAuthentication[] = $bodyAuthentication;
  $componentsAuthentication[] = $footerAuthentication;
  $componentsAuthentication[] = $buttonsAuthentication;




  if (!empty($otp_type)) {
    $data = array(
      'allow_category_change' => true,
      'name' => $templateName,
      'category' => $templateCat,
      'language' => $language,
      'components' => $componentsAuthentication
    );
  } else {
    $data = array(
      'allow_category_change' => true,
      'name' => $templateName,
      'category' => $templateCat,
      'language' => $language,
      'components' => $components,
      'cta_url_link_tracking_opted_out' => true
    );
  }

  $headers = array();

  $headers[] = 'Authorization: Bearer ' . $token;
  $headers[] = 'Content-Type:application/json';
  $headers[] = 'Authorization: OAuth ' . $token;

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // print_r($url);
  // print_r('<br>');
  // print_r($data);

  $result = curl_exec($ch);

  $jsonresponse = json_decode($result, true);
  // print_r('<br>');
  // print_r($jsonresponse);
  curl_close($ch);

  if (isset($jsonresponse['error'])) {
    $_SESSION['api_error'] = $jsonresponse;
  } else {
    $_SESSION['api_response'] = $jsonresponse;
  }

  header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsapp/templates'));
}

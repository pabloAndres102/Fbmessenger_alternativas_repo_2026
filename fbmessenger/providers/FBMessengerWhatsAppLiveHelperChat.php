<?php

namespace LiveHelperChatExtension\fbmessenger\providers {

    class FBMessengerWhatsAppLiveHelperChat
    {

        public static function getInstance()
        {

            if (self::$instance !== null) {
                return self::$instance;
            }

            self::$instance = new self();

            return self::$instance;
        }

        public function __construct()
        {
            $mbOptions = \erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
            $data = (array)$mbOptions->data;

            if (!isset($data['whatsapp_access_token']) || empty($data['whatsapp_access_token'])) {
                throw new \Exception('Access Key is not set!', 100);
            }

            if (!isset($data['whatsapp_business_account_id']) || empty($data['whatsapp_business_account_id'])) {
                throw new \Exception('WhatsApp Business Account ID', 100);
            }

            $this->access_key = $data['whatsapp_access_token'];
            $this->whatsapp_business_account_id = $data['whatsapp_business_account_id'];
            $this->endpoint = 'https://graph.facebook.com/';
        }

        public function setAccessToken($accessToken)
        {
            $this->access_key = $accessToken;
        }

        public function setBusinessAccountID($businessAccountID)
        {
            $this->whatsapp_business_account_id = $businessAccountID;
        }

        public function getPhones()
        {
            // https://developers.facebook.com/docs/graph-api/reference/whats-app-business-account/phone_numbers/
            // curl -i -X GET "https://graph.facebook.com/LATEST-VERSION/WHATSAPP-BUSINESS-ACCOUNT-ID/phone_numbers?access_token=USER-ACCESS-TOKEN"
            $templates = $this->getRestAPI([
                'baseurl'   => $this->endpoint,
                'bearer'    => $this->access_key,
                'method'    => "v20.0/{$this->whatsapp_business_account_id}/phone_numbers",
            ]);

            if (isset($templates['data']) && is_array($templates['data'])) {
                return $templates['data'];
            } else {
                throw new \Exception('Could not fetch phone numbers - ' . print_r($templates, true), 100);
            }
        }

        public function getTemplates()
        {
            // https://developers.facebook.com/docs/graph-api/reference/whats-app-business-account/message_templates/
            // curl -i -X GET "https://graph.facebook.com/LATEST-VERSION/WHATSAPP-BUSINESS-ACCOUNT-ID/message_templates?access_token=USER-ACCESS-TOKEN"
            // curl -i -X GET "https://graph.facebook.com/v20.0/105209658989864/message_templates?access_token=EAARB6lT6poQBAPgBHm06sO7QfAZAPjflwCRuLRCKHnT9I9g9ZCeDqQ5bLktX647qH2JwWmMWD1kijbReD5ZASZAdJZCFgIyN5NJ1lkzhjwsibYDSwN5a6YhZCUgMgZCbl52am5Q8pXLatXmTp4yxL1kdhDC3DTai1MU7Ujmo1suscwjwoSPgR71"

            $templates = $this->getRestAPI([
                'baseurl'   => $this->endpoint,
                'bearer'    => $this->access_key,
                'method'    => "v20.0/{$this->whatsapp_business_account_id}/message_templates",
                'args'      => [
                    'limit' => 1000,
                ],
            ]);

            if (isset($templates['data']) && is_array($templates['data'])) {
                return $templates['data'];
            } else {
                throw new \Exception('Could not fetch templates - ' . print_r($templates, true), 100);
            }
        }

        public function getConversationMetrics($start, $end, $granularity, $phoneNumber)
        {
            $start = strtotime($start);
            $end = strtotime($end);
            $phoneNumber = str_replace([' ', '+'], '', $phoneNumber);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $this->whatsapp_business_account_id . '?fields=conversation_analytics.start(' . $start . ').end(' . $end . ').granularity(' . $granularity . ').phone_numbers([' . $phoneNumber . ']).conversation_directions([]).dimensions([%22CONVERSATION_CATEGORY%22%2C%22CONVERSATION_TYPE%22%2C%22COUNTRY%22%2C%22PHONE%22%2C%22CONVERSATION_DIRECTION%22])%0A',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->access_key
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $json_response = json_decode($response, true);
            return $json_response;
        }

        public function getTemplateMetrics($template_id)
        {
            $end = time();
            $start = $end - (89 * 24 * 60 * 60);
            $template_id = json_encode($template_id);

            $curl = curl_init();
            $url = 'https://graph.facebook.com/v20.0/' . $this->whatsapp_business_account_id . '/template_analytics?start=' . $start . '&end=' . $end . '&granularity=DAILY&metric_types=[%22SENT%22%2C%22DELIVERED%22%2C%22READ%22%2C%22CLICKED%22]&template_ids=[' . $template_id . ']&limit=1000';

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->access_key
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $jsonresponse = json_decode($response, true);
            return $jsonresponse;
        }




        public function getTemplate($name, $language)
        {
            // https://developers.facebook.com/docs/graph-api/reference/whats-app-business-hsm/
            // curl -i -X GET "https://graph.facebook.com/LATEST-VERSION/WHATS-APP-MESSAGE-TEMPLATE-ID?access_token=USER-ACCESS-TOKEN"
            return $this->getRestAPI([
                'baseurl' => $this->endpoint,
                'bearer' =>  $this->access_key,
                'method' => "v20.0/{$name}",
            ]);
        }
        public function getTemplateById($templateId)
        {
            // https://developers.facebook.com/docs/graph-api/reference/whats-app-business-hsm/
            // curl -i -X GET "https://graph.facebook.com/v20.0/WHATS-APP-MESSAGE-TEMPLATE-ID?access_token=USER-ACCESS-TOKEN"
            return $this->getRestAPI([
                'baseurl' => $this->endpoint,
                'bearer' =>  $this->access_key,
                'method' => "v20.0/{$templateId}",
            ]);
        }




        public function sendTemplate($item, $templates = [], $phones = [], $paramsExecution = [])
        {
            // $logFile = fopen("log.txt", "w");
            $protocol = 'https://';
            $http = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
            $host = $protocol . $http;

            $argumentsTemplate = [];

            $templatePresent = null;
            foreach ($templates as $template) {
                if ($template['name'] == $item->template && $template['language'] == $item->language) {
                    $templatePresent = $template;
                    $item->template_id = $template['id'];
                }
            }

            foreach ($phones as $phone) {
                if ($item->phone_sender_id == $phone['id']) {
                    $item->phone_sender = $phone['display_phone_number'];
                }
            }

            // Extract phone sender number and store as phone_sender attribute
            $bodyArguments = [];
            $parametersHeader = [];
            $messageVariables = $item->message_variables_array;

            // https://developers.facebook.com/docs/whatsapp/on-premises/reference/messages#template-object
            $bodyText = '';
            foreach ($templatePresent['components'] as $component) {
                if ($component['type'] == 'BODY') {
                    $bodyText = $component['text'];
                } elseif ($component['type'] == 'BUTTONS') {
                    foreach ($component['buttons'] as $indexButton => $button) {
                        if ($button['type'] == 'QUICK_REPLY') {
                            $bodyArguments[] = [
                                "type" => "button",
                                "sub_type" => "quick_reply",
                                "index" => (int)$indexButton,
                                "parameters" => [
                                    [
                                        "type" => "payload",
                                        "payload" => $item->template . '-quick_reply_' . $indexButton,
                                    ]
                                ]
                            ];
                        }
                        if ($button['type'] == 'CATALOG') {
                            $bodyArguments[] = [
                                "type" => "button",
                                "sub_type" => "CATALOG",
                                "index" => (int)$indexButton,
                            ];
                        }
                        if ($button['type'] == 'MPM') {

                            $array_id = [];

                            foreach ($item->message_variables_array as $key => $value) {
                                if (!is_numeric($key)) {
                                    // La clave no es numérica, entonces la omitimos
                                    continue;
                                }

                                // La clave es numérica, agregamos el valor al array
                                $array_id[] = ['product_retailer_id' => $value];
                            }
                            // print_r($array_id);


                            // fwrite($logFile, "ARRAY DE RETAILERS: " . print_r($array_id, true) . "\n");

                            $parameters = [
                                [
                                    "type" => "action",
                                    "action" => [
                                        "sections" => [
                                            [
                                                "title" => "Productos",
                                                "product_items" => $array_id
                                            ]
                                        ]
                                    ]
                                ]
                            ];
                            $bodyArguments[] = [
                                "type" => "button",
                                "sub_type" => "mpm",
                                "index" => (int)$indexButton,
                                "parameters" => $parameters
                            ];
                        }
                    }
                }

                if ($component['type'] == 'LIMITED_TIME_OFFER') {

                    // fwrite($logFile, "Message variables: " . print_r($item->message_variables, true) . "\n");
                    // fwrite($logFile, "MESSAGE VARIABLES ARRAY: " . print_r($item->message_variables_array, true) . "\n");


                    $parameters = [
                        [
                            "type" => "coupon_code",
                            "coupon_code" => $item->message_variables_array[0]
                        ]
                    ];

                    $parametersOffer = [
                        "type" => "limited_time_offer",
                        "limited_time_offer" => [
                            "expiration_time_ms" => $item->message_variables_array[1]
                        ]
                    ];


                    $bodyArguments[] = [
                        "type" => $component['type'],
                        "parameters" => [$parametersOffer]
                    ];

                    $bodyArguments[] = [
                        "type" => "button",
                        "sub_type" => "copy_code",
                        "index" => (int)$indexButton,
                        "parameters" => $parameters
                    ];
                } elseif ($component['type'] == 'CAROUSEL') {
                    // fwrite($logFile, "MESSAGE VARIABLES ARRAY: " . print_r($item->message_variables_array, true) . "\n");
                    $numCards = count($component['cards']);
                    $carousel_cards = [];
                    for ($i = 0; $i < $numCards; $i++) {
                        $card_index = $i;
                        $carousel_card = [
                            "card_index" => $card_index,
                            "components" => []
                        ];

                        foreach ($component['cards'][$i]['components'] as $cardComponents) {
                            $componentToAdd = [];
                            if ($cardComponents['type'] == 'HEADER') {

                                if ($cardComponents['format'] == 'IMAGE') {
                                    $header_component = [
                                        "type" => "HEADER",
                                        "parameters" => [
                                            [
                                                "type" => "IMAGE",
                                                "image" => [
                                                    "id" =>  $item->message_variables_array[$card_index]
                                                ]
                                            ]
                                        ]
                                    ];
                                }
                                if ($cardComponents['format'] == 'VIDEO') {
                                    $header_component = [
                                        "type" => "HEADER",
                                        "parameters" => [
                                            [
                                                "type" => "VIDEO",
                                                "video" => [
                                                    "id" =>  $item->message_variables_array[$card_index]
                                                ]
                                            ]
                                        ]
                                    ];
                                }

                                $componentToAdd = $header_component;
                            } elseif ($cardComponents['type'] == 'BUTTON') {
                                $button_components = [
                                    [
                                        "type" => "BUTTON",
                                        "sub_type" => "QUICK_REPLY",
                                        "index" => 0,
                                        "parameters" => [
                                            [
                                                "type" => "PAYLOAD",
                                                "payload" => "Boton respuesta tarjeta: 1"
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "BUTTON",
                                        "sub_type" => "URL",
                                        "index" => 1,
                                        "parameters" => [
                                            [
                                                "type" => "payload",
                                                "payload" => "https:\/\/www.google.com\/webhp?hl=es-419&sa=X&ved=0ahUKEwju5c3q_ZCFAxVcSzABHdgqAl4QPAgJ"
                                            ]
                                        ]
                                    ]
                                ];
                                $componentToAdd = $button_components;
                            }
                            if (!empty($componentToAdd)) {
                                $carousel_card['components'][] = $componentToAdd;
                                $card_index += count($componentToAdd);
                            }
                        }
                        $carousel_cards[] = $carousel_card;
                    }
                    $final_cards = [
                        "type" => 'CAROUSEL',
                        "cards" => $carousel_cards
                    ];
                    $bodyArguments[] = $final_cards;
                } elseif ($component['type'] == 'HEADER' && $component['format'] == 'VIDEO') {

                    // $videoLink = isset($messageVariables['field_header_video_1']) && $messageVariables['field_header_video_1'] != '' ? $messageVariables['field_header_video_1'] : (isset($component['example']['header_url'][0]) ? $component['example']['header_url'][0] : 'https://omni.enviosok.com/design/defaulttheme/images/general/logo.png');

                    $parametersHeader[] = [
                        "type" => "video",
                        "video" => [
                            "id" => end($item->message_variables_array)
                        ]
                    ];
                } elseif ($component['type'] == 'HEADER' && $component['format'] == 'DOCUMENT') {


                    // $documentLink = isset($messageVariables['field_header_doc_1']) && $messageVariables['field_header_doc_1'] != '' ? $messageVariables['field_header_doc_1'] : (isset($component['example']['header_handle'][0]) ? $component['example']['header_handle'][0] : 'https://omni.enviosok.com/design/defaulttheme/images/general/logo.png');

                    $itemSend = [
                        "type" => "document",
                        "document" => [
                            "id" => end($item->message_variables_array)
                        ]
                    ];

                    // Si tienes el nombre del archivo, puedes adjuntarlo aquí
                    if (isset($item->message_variables_array['nombre_archivo1'][0]) && $item->message_variables_array['nombre_archivo1'][0]) {
                        $itemSend['document']['filename'] = $item->message_variables_array['nombre_archivo1'];
                    }

                    $parametersHeader[] = $itemSend;
                } elseif ($component['type'] == 'HEADER' && $component['format'] == 'IMAGE') {
                    // $imageLink = isset($messageVariables['field_header_img_1']) && $messageVariables['field_header_img_1'] != '' ? $messageVariables['field_header_img_1'] : (isset($component['example']['header_url'][0]) ? $component['example']['header_url'][0] : 'https://omni.enviosok.com/design/defaulttheme/images/general/logo.png');
                    // if (strpos($imageLink, $host) !== 0) {
                    //     $imageLink = rtrim($host, '/') . '/' . ltrim($imageLink, '/');
                    // }

                    // if ($templatePresent['components'][2]['type'] == 'LIMITED_TIME_OFFER') {



                    $parametersHeader[] = [
                        "type" => "image",
                        "image" => [
                            "id" => end($item->message_variables_array)
                        ]
                    ];
                    // } else {
                    // $parametersHeader[] = [
                    //     "type" => "image",
                    //     "image" => [
                    //         "id" => $imageLink
                    //     ]
                    // ];
                    // }
                }
            }




            $item->message = $bodyText;

            for ($i = 0; $i < 6; $i++) {
                if (isset($messageVariables['field_' . $i]) && $messageVariables['field_' . $i] != '') {
                    $item->message = str_replace('{{' . $i . '}}', $messageVariables['field_' . $i], $item->message);
                    $argumentsTemplate[] = ['type' => 'text', 'text' => $messageVariables['field_' . $i]];
                }
            }

            for ($i = 0; $i < 6; $i++) {
                if (isset($messageVariables['field_header_' . $i]) && $messageVariables['field_header_' . $i] != '') {
                    $parametersHeader[] = ['type' => 'text', 'text' => $messageVariables['field_header_' . $i]];
                }
            }

            if (!empty($parametersHeader)) {
                $bodyArguments[] = [
                    "type" => "header",
                    "parameters" => $parametersHeader
                ];
            }

            if (!empty($argumentsTemplate)) {
                $bodyArguments[] = [
                    'type' => 'body',
                    'parameters' => $argumentsTemplate,
                ];
            }

            $requestParams = [
                'baseurl' => $this->endpoint,
                'method' => "v20.0/{$item->phone_sender_id}/messages",
                'bearer' => $this->access_key,
                'body_json' => json_encode([
                    'messaging_product' => 'whatsapp',
                    'to' => ($item->phone_whatsapp != '' ? $item->phone_whatsapp : $item->phone),
                    'type' => 'template',
                    'template' => [
                        'name' => $item->template,
                        'language' => [
                            'policy' => 'deterministic',
                            'code' => $item->language
                        ],
                        'components' => $bodyArguments
                    ],
                ])
            ];

            $response = null;


            // print_r('<br>');
            // print_r($requestParams);
            try {

                $response = $this->getRestAPI($requestParams);
                // print_r('<br>');
                // print_r($response);
                // fwrite($logFile, "Request Params: " . print_r($requestParams, true) . "\n");
                // fwrite($logFile, "Response: " . print_r($response, true) . "\n");
                // fwrite($logFile, "item: " . print_r($item, true) . "\n");
                // Responder
                if (isset($response['messages'][0]['id'])) {
                    $item->fb_msg_id = $response['messages'][0]['id'];
                } else {
                    throw new \Exception('Message ID was not returned.');
                }

                $item->send_status_raw = json_encode($response);

                if (!isset($paramsExecution['do_not_save']) || $paramsExecution['do_not_save'] == false) {
                    $item->saveThis();
                }

                return $item;
            } catch (\Exception $e) {
                $item->send_status_raw = json_encode($response) . $e->getTraceAsString() . $e->getMessage();
                $item->status = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_FAILED;
                if (!isset($paramsExecution['do_not_save']) || $paramsExecution['do_not_save'] == false) {
                    $item->saveThis();
                }
                return $item;
                // fclose($logFile);
            }
        }

        public function getRestAPI($params)
        {
            $try = isset($params['try']) ? $params['try'] : 3;

            for ($i = 0; $i < $try; $i++) {

                $ch = curl_init();
                $url = rtrim($params['baseurl'], '/') . '/' . $params['method'] . (isset($params['args']) ? '?' . http_build_query($params['args']) : '');

                if (!isset(self::$lastCallDebug['request_url'])) {
                    self::$lastCallDebug['request_url'] = array();
                }

                if (!isset(self::$lastCallDebug['request_url_response'])) {
                    self::$lastCallDebug['request_url_response'] = array();
                }

                self::$lastCallDebug['request_url'][] = $url;

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, self::$apiTimeout);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

                if (isset($params['method_type']) && $params['method_type'] == 'delete') {
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                }

                $headers = array(
                    'Accept: application/json',
                    'Authorization: AccessKey ' . $this->access_key
                );

                if (isset($params['body_json']) && !empty($params['body_json'])) {
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params['body_json']);
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Expect:';
                }

                if (isset($params['bearer']) && !empty($params['bearer'])) {
                    $headers[] = 'Authorization: Bearer ' . $params['bearer'];
                }

                if (isset($params['headers']) && !empty($params['headers'])) {
                    $headers = array_merge($headers, $params['headers']);
                }

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

                $startTime = date('H:i:s');
                $additionalError = ' ';

                if (isset($params['test_mode']) && $params['test_mode'] == true) {
                    $content = $params['test_content'];
                    $httpcode = 200;
                } else {
                    $content = curl_exec($ch);

                    if (curl_errno($ch)) {
                        $additionalError = ' [ERR: ' . curl_error($ch) . '] ';
                    }

                    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                }

                $endTime = date('H:i:s');

                if (isset($params['log_response']) && $params['log_response'] == true) {
                    self::$lastCallDebug['request_url_response'][] = '[T' . self::$apiTimeout . '] [' . $httpcode . ']' . $additionalError . '[' . $startTime . ' ... ' . $endTime . '] - ' . ((isset($params['body_json']) && !empty($params['body_json'])) ? $params['body_json'] : '') . ':' . $content;
                }

                if ($httpcode == 204) {
                    return array();
                }

                if ($httpcode == 404) {
                    throw new \Exception('Resource could not be found!');
                }

                if (isset($params['return_200']) && $params['return_200'] == true && $httpcode == 200) {
                    return $content;
                }

                if ($httpcode == 401) {
                    throw new \Exception('No permission to access resource!');
                }

                if ($content !== false) {
                    if (isset($params['raw_response']) && $params['raw_response'] == true) {
                        return $content;
                    }

                    $response = json_decode($content, true);
                    if ($response === null) {
                        if ($i == 2) {
                            throw new \Exception('Invalid response was returned. Expected JSON');
                        }
                    } else {
                        if ($httpcode != 500) {
                            return $response;
                        }
                    }
                } else {
                    if ($i == 2) {
                        throw new \Exception('Invalid response was returned');
                    }
                }

                if ($httpcode == 500 && $i >= 2) {
                    throw new \Exception('Invalid response was returned');
                }

                usleep(300);
            }
        }

        private $endpoint = null;
        private $access_key = null;
        private $whatsapp_business_account_id = null;

        private static $instance = null;
        public static $lastCallDebug = array();
        public static $apiTimeout = 40;
    }
}

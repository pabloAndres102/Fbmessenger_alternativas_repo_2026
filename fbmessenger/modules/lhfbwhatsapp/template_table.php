<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/template_table.tpl.php');
$instance = \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
$item = new \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage();

$parametros = [ $Params['user_parameters']['texto'],
                $Params['user_parameters']['texto2'],
                $Params['user_parameters']['texto3'],
                $Params['user_parameters']['texto4'],
                $Params['user_parameters']['texto5']];



                

$item->message_variables = $parametros;
$messageVariables = $item->message_variables;

if(isset($_GET['header'])){
    $textHeader = $_GET['header'];
}
if(isset($_GET['img'])){
    $mediaIMG = $_GET['img'];
}
if(isset($_GET['video'])){
    $mediaVIDEO = $_GET['video'];
}






if (isset($Params['user_parameters']['template'])) {
    $templates = $instance->getTemplates();
    foreach ($templates as $template) {
        if ($Params['user_parameters']['template'] == $template['name']) {
            $templatePresent = $template;
            $bodyTextHeader = '';
            $bodyText = '';
            foreach ($templatePresent as $tp) {
                foreach ($tp as $text) {
                    if ($text['type'] === 'BODY') {
                        $bodyText = $text['text'];
                        foreach ($messageVariables as $key => $value) {
                            $bodyText = str_replace('{{' . ($key + 1) . '}}', $value, $bodyText);
                            
                        }
                        break; 
                    }
                    if ($text['type'] == 'HEADER'){
                        $bodyTextHeader = $text['text'];
                        $bodyTextHeader = str_replace('{{1}}', $textHeader, $bodyTextHeader);
                        $tpl->set('prueba', $bodyTextHeader);
                        
                    }
                }
            }
        foreach($templatePresent['components'] as $component){
            if($component['type'] === 'BUTTONS'){
                $buttons = $component['buttons'];

                $tpl->setArray([
                    'buttons' => $buttons,
                ]);
            }
            if($component['type'] === 'HEADER'){
                if($component['format'] === 'IMAGE')
                $component['example']['header_handle'][0] = $mediaIMG;
                else{
                    $component['example']['header_handle'][0] = ''; 
                }
                $tpl->set('mediaIMG', $component['example']['header_handle'][0]);
            }   if($component['format'] === 'VIDEO'){
                $component['example']['header_handle'][0] = $mediaVIDEO;
                $tpl->set('mediaVIDEO', $component['example']['header_handle'][0]);
            }
        }












        $tpl->set('templateName', $template['name']);
        }

    


    }
}


$tpl->set('bodyText', $bodyText);





echo $tpl->fetch();
exit;

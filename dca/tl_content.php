<?php

// CSS für Anzeige im Backend einbinden
if (TL_MODE == 'BE')
    $GLOBALS['TL_CSS'][] = 'system/modules/headline-image/assets/css/backend.css|screen';

// Selektorbox einbinden
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'addHeadLineImage';

$fieldNamesAfter= array();
foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key=>$palette){ //alle Bereiche (Paletten) durchgehen
    if(!is_array($palette) && is_string($palette)) {
        if (strpos($palette, ",headline")) { //wenn irgendwo ein headlinefeld vorkommt -> bildfelder rein
            $GLOBALS['TL_DCA']['tl_content']['palettes'][$key] = str_replace('headline', 'headline,addHeadLineImage', $GLOBALS['TL_DCA']['tl_content']['palettes'][$key]);
            array_push($fieldNamesAfter,getFieldKeyAfterHeadlineAdd($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],"addHeadLineImage"));
        }
        if (strpos($palette, ",mooHeadline")) { //wenn irgendwo ein headlinefeld vorkommt -> bildfelder rein
            $GLOBALS['TL_DCA']['tl_content']['palettes'][$key] = str_replace('mooHeadline', 'mooHeadline,addHeadLineImage', $GLOBALS['TL_DCA']['tl_content']['palettes'][$key]);
            array_push($fieldNamesAfter,getFieldKeyAfterHeadlineAdd($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],"addHeadLineImage"));
        }

    }
    foreach($fieldNamesAfter as $name) {
        if ($name != null) {
            if (isset($GLOBALS['TL_DCA']['tl_content']['fields'][$name]))
                if (isset($GLOBALS['TL_DCA']['tl_content']['fields'][$name]['eval']['tl_class'])) {
                    if (strpos($GLOBALS['TL_DCA']['tl_content']['fields'][$name]['eval']['tl_class'], "clr") == 0)
                         $GLOBALS['TL_DCA']['tl_content']['fields'][$name]['eval']['tl_class'] .= " clr";
                }else
                    $GLOBALS['TL_DCA']['tl_content']['fields'][$name]['eval']['tl_class'] = "clr";
        }
    }
}

//Pfadauswahlbox button
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['addHeadLineImage'] = 'headlineImageFilepath';

$GLOBALS['TL_DCA']['tl_content']['fields']['addHeadLineImage'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_content']['addHeadLineImage'],
    'exclude'			=> true,
    'inputType'			=> 'checkbox',
    'eval'				=> array('submitOnChange'=>true, 'tl_class' => 'clr w50'),
    'sql'				=> "char(1) NOT NULL default ''"
);
//$GLOBALS['TL_DCA']['tl_content']['fields']['addHeadLineImage']


$GLOBALS['TL_DCA']['tl_content']['fields']['headlineImageFilepath'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_content']['headlineImageFilepath'],
    'exclude'	=> true,
    'inputType'	=> 'fileTree',
    'explanation'	=> 'headlineImageFilepath',
    'eval'	=> array('filesOnly'=>true, 'fieldType'=>'radio', 'extensions' =>'ico,jpg,jpeg,png,gif', 'mandatory'=>true, 'tl_class'=>'w50 h_image'),
    'sql'	=> "binary(16) NULL"
);

//Funktion die aus dem Palletten-String den Namen des nachfolgenden Feldes extrahier
// wenn es auf der selben Pallette liegt.
function getFieldKeyAfterHeadlineAdd($paletteStr,$fieldStr){

    $strPos1=strpos($paletteStr,$fieldStr.",");
    if($strPos1!=0){
        $palletCut=substr($paletteStr,$strPos1+strlen($fieldStr)+1,strlen($paletteStr));
        $res=explode(",",$palletCut,2);
        if(count($res)!=0){
            if(strpos($res[0],";")==1)
                $res=str_split(";",$palletCut,1);
            return $res[0];
        }else
            return "";
    }
    return "";

}


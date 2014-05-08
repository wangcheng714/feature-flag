<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.feature.php
 * Type:     block
 * Name:     feature
 * Purpose:
 * -------------------------------------------------------------
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "DoorKeeper.class.php");

function smarty_block_feature($params, $content, Smarty_Internal_Template $template, &$repeat){
    if(!$repeat){
        if (isset($content)) {
            $feature_name = $params['name'];
            $else_tag = "}else{";
            $true_false = explode($else_tag, $content, 2);
            $trueContent = (isset($true_false[0]) ? $true_false[0] : null);
            $falseContent = (isset($true_false[1]) ? $true_false[1] : null);
            //todo : call DoorKeeper.getFeature()
            $featureResult = DoorKeeper::getFeature($feature_name, $template);
            if($featureResult == "true"){
                return $trueContent;
            }else{
                return $falseContent;
            }
            return null;
        }
    }
}
?>
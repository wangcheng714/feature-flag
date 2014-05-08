<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     compiler.featureelse.php
 * Type:     compiler
 * Name:     featureelse
 * Purpose:  Output featureelse tag with smarty delimiter
 * -------------------------------------------------------------
 */
function smarty_compiler_featureelse($params, Smarty $smarty)
{
    return "<?php\necho '" . $smarty->left_delimiter . "featureelse" . $smarty->right_delimiter . "';\n?>";
}
?>
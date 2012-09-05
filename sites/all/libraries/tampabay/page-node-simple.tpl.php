<?php
// JPJ Bypass main page
// Put this at the top of page.tpl.page in your theme
// 
//    if ($_GET["format"] == "simple") {
//        include ('sites/all/libraries/tampabay/page-node-simple.tpl.php');
//        return;
//    }
//
//    


    print render ($page['content']);
            
?>

<?php
//** Replace nav menu class
function arnold_walker_nav_menu_edit($walker, $menu_id){   
    return 'UX_Walker_Nav_Menu_Edit';
} 
add_filter('wp_edit_nav_menu_walker', 'arnold_walker_nav_menu_edit', 15, 2);   

//require nav-menu export
require_once get_template_directory() . '/functions/theme/nav-menu/nav-menu-anchor.php';

//require nav-menu export
require_once get_template_directory() . '/functions/theme/nav-menu/ux-class/nav-menu.php';

?>
<?php
    if(is_active_sidebar('recent-post-sidebar')){
        dynamic_sidebar('recent-post-sidebar');
    }else{
        echo "<p>".__('This is sidebar. You have to add some widgets', 'chiennguyen')."</p>";
    }
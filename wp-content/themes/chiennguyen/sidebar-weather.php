<?php
    if(is_active_sidebar('weather-sidebar')){
        dynamic_sidebar('weather-sidebar');
    }else{
        echo "<p>".__('This is sidebar. You have to add some widgets', 'chiennguyen')."</p>";
    }
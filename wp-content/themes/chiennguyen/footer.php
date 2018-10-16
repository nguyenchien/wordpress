<div id="footer">
    <div class="wrapper">
        <?php
            if(is_active_sidebar('info_footer')){
                dynamic_sidebar('info_footer');
            }else{
                echo "<p>".__('This is sidebar. You have to add some widgets', 'chiennguyen')."</p>";
            }
        ?>
    </div>
</div>
</div><!-- end #container -->
<?php wp_footer(); ?>
</body>
</html>
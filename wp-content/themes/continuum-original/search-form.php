<div class="search_main">
    <form method="get" class="searchform" action="<?php bloginfo('url'); ?>" >
        <input type="text" class="field s" name="s" value="<?php _e('Enter search keywords', 'woothemes') ?>" onfocus="if (this.value == '<?php _e('Enter search keywords', 'woothemes') ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter search keywords', 'woothemes') ?>';}" />
        <input type="image" src="<?php bloginfo('template_directory'); ?>/images/search-btn.png" class="submit" name="submit" />
    </form>    
<div class="clear"></div></div>
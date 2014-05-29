<div class="ipSitemap">
    <?php
    foreach ($menus as $menu){
//        echo '<h4>'.esc($menu['title']).'</h4>';
        echo ipRenderWidget('Heading', array('title' => $menu['title'], 'level' => 3));
        echo ipRenderWidget('Text', array('text' => $menu['html']));
    }
    ?>
</div>
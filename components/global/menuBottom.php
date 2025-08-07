<?php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<div class="bottom">
    <div class="container">
        <div>
            <a href="<?php echo $base_url; ?>/home" title="Home">
                <i class="<?php echo ($current_page == 'home') ? 'ph-fill ph-house' : 'ph ph-house'; ?>"></i>
            </a>
        </div>

        <div>
            <a href="<?php echo $base_url; ?>/feed" title="Feed">
                <i class="<?php echo ($current_page == 'feed') ? 'ph-fill ph-newspaper' : 'ph ph-newspaper'; ?>"></i>
            </a>
        </div>

        <div>
            <a href="<?php echo $base_url; ?>/radar" title="Radar">
                <i class="<?php echo ($current_page == 'radar') ? 'ph-fill ph-map-pin' : 'ph ph-map-pin'; ?>"></i>
            </a>
        </div>

        <div>
            <a href="<?php echo $base_url; ?>/chat" title="Chat">
                <i class="<?php echo ($current_page == 'chat') ? 'ph-fill ph-chat' : 'ph ph-chat'; ?>"></i>
            </a>
        </div>
    </div>
</div>

<?php
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<div class="bottom">
    <div class="container">
        <div>
            <a href="<?php echo $base_url; ?>/home">
                <img src="<?php echo $base_url; ?>/images/icons/<?php echo ($current_page == 'home') ? 'active' : 'black'; ?>/iconHome.svg" class="icon1">
            </a>
        </div>

        <div>
            <a href="<?php echo $base_url; ?>/feed">
                <img src="<?php echo $base_url; ?>/images/icons/<?php echo ($current_page == 'feed') ? 'active' : 'black'; ?>/iconFeed.svg" class="icon2">
            </a>
        </div>

        <div>
            <a href="<?php echo $base_url; ?>/radar">
                <img src="<?php echo $base_url; ?>/images/icons/<?php echo ($current_page == 'radar') ? 'active' : 'black'; ?>/iconRadar.svg" class="icon3">
            </a>
        </div>

        <div>
            <a href="<?php echo $base_url; ?>/chat">
                <img src="<?php echo $base_url; ?>/images/icons/<?php echo ($current_page == 'chat') ? 'active' : 'black'; ?>/iconChat.svg" class="icon4">
            </a>
        </div>
    </div>
</div>

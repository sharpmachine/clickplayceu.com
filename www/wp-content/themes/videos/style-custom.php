body {
background: #<?php echo get_option(THEME_PREFIX . "background_color"); ?> url(<?php echo get_option(THEME_PREFIX . "background_img"); ?>) <?php echo get_option(THEME_PREFIX . "background_vert"); ?> <?php echo get_option(THEME_PREFIX . "background_horiz"); ?> <?php echo get_option(THEME_PREFIX . "background_repeat"); ?> <?php if (get_option(THEME_PREFIX . "background_fixed")) { ?>fixed<?php } ?>;
color: #<?php echo get_option(THEME_PREFIX . "content_text_color"); ?>;
}

blockquote {
color: #<?php echo get_option(THEME_PREFIX . "content_text_color"); ?>;
border-left: 1px solid #<?php echo get_option(THEME_PREFIX . "content_text_color"); ?>;
}

a:link, a:visited {
color: #<?php echo get_option(THEME_PREFIX . "content_link_color"); ?>;
}

a:hover {
color: #<?php echo get_option(THEME_PREFIX . "content_link_hover_color"); ?>;
}

h1, h2, h3, h4, h5, h6 {
color: #<?php echo get_option(THEME_PREFIX . "heading_text_color"); ?>;
}

h1 a:link, h1 a:visited, h2 a:link, h2 a:visited, h3 a:link, h3 a:visited {
color: #<?php echo get_option(THEME_PREFIX . "heading_link_color"); ?>;
}

h2 a:hover, h3 a:hover, h4 a:hover {
color: #<?php echo get_option(THEME_PREFIX . "heading_link_hover_color"); ?>;
}

.menu, .menu li ul, .menu li li li ul, #channels-wrapper, #video-top, #video, #video-single, #video-bottom, #breadcrumbs, .post-image, #pagination, .wp-caption, #comments-meta, .avatar, #leave-reply, .widget {
background: #<?php echo get_option(THEME_PREFIX . "content_bg"); ?>;
}

.multiple, .details, .details li, ol.commentlist li, ol.commentlist li.alt, #footer-inside, .divider-margin, .divider-top, .divider {
border-color: #<?php echo get_option(THEME_PREFIX . "content_bg"); ?>;
}

<?php
/**
 * FAQ entry
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<article class="faq-entry clr">
	<h3 class="faq-title"><a href="#"><span class="fa fa-question-circle"></span><?php the_title(); ?></a></h3>
	<div class="faq-entry-answer clr"><?php the_content(); ?></div>
</article>
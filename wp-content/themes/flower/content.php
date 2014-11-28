<?php
/**
 * @package flower
 */
?>
<ul class="list-news">
	<li>
		<div class="infor-news-box">
			<div class="images"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php echo content(25); ?>
		</div>
		<div class="more-view">
			<a href="<?php the_permalink(); ?>">Xem tiếp</a>
		</div>
	</li>
</ul>


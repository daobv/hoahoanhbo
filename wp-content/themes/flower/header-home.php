<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package flower
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> class="home">
<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<div class="header-top">
			<div class="container">
				<?php dynamic_sidebar( 'banner-header' ); ?>
			</div>
		</div>
		<div class="header-center">
			<div class="container clearfix">
				<ul class="menu clearfix">
					<?php
	      				wp_nav_menu( array(
							'theme_location' => 'header_left_menu',
							'container'      => false,
							'items_wrap'     => '%3$s'
						) );
					?>
				</ul>
				<div class="mod-social">
					<ul class="menu">
						<li>
							<script src="https://apis.google.com/js/platform.js" async defer></script>
							<g:plusone></g:plusone>
						</li>
						<li>
							<!-- facebook like -->
							<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo esc_url (home_url()); ?>&amp;layout=button_count&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp" style="overflow:hidden;width:100%;height:22px;" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
						</li>
					</ul>
				</div>
				<ul class="menu menu-right">
					<?php
	      				wp_nav_menu( array(
							'theme_location' => 'header_right_menu',
							'container'      => false,
							'items_wrap'     => '%3$s'
						) );
					?>
				</ul>
			</div>
		</div>

		<div class="page-content">
			<div class="wapp-header">
				<div class="header">
					<div class="container clearfix">
						<div id="logo">
							<a href="<?php echo esc_url( home_url( '/' ) );?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home" >
							<img src="<?php echo get_template_directory_uri(); ?>/images/logo.gif" class="img-responsive" />
							</a>
						</div>
						<div class="mod-search">
							<form class="clearfix">
								<label>Sản phẩm</label>
								<span class="vi"></span>
								<input class="s-text" type="text" value="Nhập từ khóa tìm kiếm" />
								<input class="s-submit" type="submit" value="Tìm kiếm" />
							</form>
						</div>
						<div class="mod-hotline">						
							<?php dynamic_sidebar( 'hotline' ); ?>
						</div>
					</div>
				</div><!-- end header -->
			</div><!--wapp-header-->
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">

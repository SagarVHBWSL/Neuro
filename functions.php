<?php
/**
 * Title: Function
 *
 * Description: Defines theme specific functions including actions and filters.
 *
 * Please do not edit this file. This file is part of the CyberChimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category CyberChimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v3.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// Load text domain.
function cyberchimps_text_domain() {
	load_theme_textdomain( 'neuro', get_template_directory() . '/inc/languages' );
}
add_action( 'after_setup_theme', 'cyberchimps_text_domain' );

// Load Core
require_once( get_template_directory() . '/cyberchimps/init.php' );

// Set the content width based on the theme's design and stylesheet.
if( !isset( $content_width ) ) {
	$content_width = 640;
} /* pixels */

// Define site info
function cyberchimps_add_site_info() {
	?>
	<p>&copy; Company Name</p>
<?php
}

add_action( 'cyberchimps_site_info', 'cyberchimps_add_site_info' );

if( !function_exists( 'cyberchimps_comment' ) ) :

// Template for comments and pingbacks.
// Used as a callback by wp_list_comments() for displaying the comments.
	function cyberchimps_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="post pingback">
				<p><?php _e( 'Pingback:', 'neuro' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'neuro' ), ' ' ); ?></p>
				<?php
				break;
			default :
				?>
					<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment hreview">
						<footer>
							<div class="comment-author reviewer vcard">
								<?php echo get_avatar( $comment, 40 ); ?>
								<?php printf( '%s <span class="says">' . __( 'says:', 'neuro' ) . '</span>', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
							</div>
							<!-- .comment-author .vcard -->
							<?php if( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'neuro' ); ?></em>
								<br/>
							<?php endif; ?>

							<div class="comment-meta commentmetadata">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="dtreviewed">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>">
										<?php
										/* translators: 1: date, 2: time */
										printf( __( '%1$s at %2$s', 'neuro' ), get_comment_date(), get_comment_time() ); ?>
									</time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'neuro' ), ' ' );
								?>
							</div>
							<!-- .comment-meta .commentmetadata -->
						</footer>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div>
						<!-- .reply -->
					</article><!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
endif; // ends check for cyberchimps_comment()

// set up next and previous post links for lite themes only
function cyberchimps_next_previous_posts() {
	if( get_next_posts_link() || get_previous_posts_link() ): ?>
		<div class="more-content">
			<div class="row-fluid">
				<div class="span6 previous-post">
					<?php previous_posts_link(); ?>
				</div>
				<div class="span6 next-post">
					<?php next_posts_link(); ?>
				</div>
			</div>
		</div>
	<?php
	endif;
}

add_action( 'cyberchimps_after_content', 'cyberchimps_next_previous_posts' );

// core options customization Names and URL's
//Pro or Free
function cyberchimps_theme_check() {
	$level = 'free';

	return $level;
}

//Theme Name
function cyberchimps_options_theme_name() {
	$text = 'Neuro';

	return $text;
}

//Theme Pro Name
function cyberchimps_upgrade_bar_pro_title() {
	$text = 'Neuro Pro 3';

	return $text;
}

//Upgrade link
function cyberchimps_upgrade_bar_pro_link() {
	$url = 'http://cyberchimps.com/store/neuro-pro/';

	return $url;
}

//Doc's URL
function cyberchimps_options_documentation_url() {
	$url = 'http://cyberchimps.com/guides/c-free/';

	return $url;
}

// Support Forum URL
function cyberchimps_options_support_forum() {
	$url = 'http://cyberchimps.com/forum/free/neuro-free/';

	return $url;
}

add_filter( 'cyberchimps_current_theme_name', 'cyberchimps_options_theme_name', 1 );
add_filter( 'cyberchimps_upgrade_pro_title', 'cyberchimps_upgrade_bar_pro_title' );
add_filter( 'cyberchimps_upgrade_link', 'cyberchimps_upgrade_bar_pro_link' );
add_filter( 'cyberchimps_documentation', 'cyberchimps_options_documentation_url' );
add_filter( 'cyberchimps_support_forum', 'cyberchimps_options_support_forum' );

// Help Section
function cyberchimps_options_help_header() {
	$text = 'neuro';

	return $text;
}

function cyberchimps_options_help_sub_header() {
	$text = __( 'CyberChimps Professional Responsive WordPress Theme', 'neuro' );

	return $text;
}

add_filter( 'cyberchimps_help_heading', 'cyberchimps_options_help_header' );
add_filter( 'cyberchimps_help_sub_heading', 'cyberchimps_options_help_sub_header' );

// Branding images and defaults

// Banner default
function cyberchimps_banner_default() {
	$url = '/images/branding/banner.jpg';

	return $url;
}

add_filter( 'cyberchimps_banner_img', 'cyberchimps_banner_default' );

//theme specific skin options in array. Must always include option default
function cyberchimps_skin_color_options( $options ) {
	// Get path of image
	$imagepath = get_template_directory_uri() . '/inc/css/skins/images/';

	$options = array(
		'default' => $imagepath . 'default.png'
	);

	return $options;
}

add_filter( 'cyberchimps_skin_color', 'cyberchimps_skin_color_options' );

// theme specific background images
function cyberchimps_background_image( $options ) {
	$imagepath = get_template_directory_uri() . '/cyberchimps/lib/images/';
	$options   = array(
		'none'  => $imagepath . 'backgrounds/thumbs/none.png',
		'noise' => $imagepath . 'backgrounds/thumbs/noise.png',
		'blue'  => $imagepath . 'backgrounds/thumbs/blue.png',
		'dark'  => $imagepath . 'backgrounds/thumbs/dark.png',
		'space' => $imagepath . 'backgrounds/thumbs/space.png'
	);

	return $options;
}

add_filter( 'cyberchimps_background_image', 'cyberchimps_background_image' );

// theme specific typography options
function cyberchimps_typography_sizes( $sizes ) {
	$sizes = array( '8', '9', '10', '12', '14', '16', '20' );

	return $sizes;
}

function cyberchimps_typography_faces( $faces ) {
	$faces = array(
		'Arial, Helvetica, sans-serif'                     => 'Arial',
		'Arial Black, Gadget, sans-serif'                  => 'Arial Black',
		'Comic Sans MS, cursive'                           => 'Comic Sans MS',
		'Courier New, monospace'                           => 'Courier New',
		'Georgia, serif'                                   => 'Georgia',
		'Impact, Charcoal, sans-serif'                     => 'Impact',
		'Lucida Console, Monaco, monospace'                => 'Lucida Console',
		'Lucida Sans Unicode, Lucida Grande, sans-serif'   => 'Lucida Sans Unicode',
		'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype',
		'Tahoma, Geneva, sans-serif'                       => 'Tahoma',
		'Times New Roman, Times, serif'                    => 'Times New Roman',
		'Trebuchet MS, sans-serif'                         => 'Trebuchet MS',
		'Verdana, Geneva, sans-serif'                      => 'Verdana',
		'Symbol'                                           => 'Symbol',
		'Webdings'                                         => 'Webdings',
		'Wingdings, Zapf Dingbats'                         => 'Wingdings',
		'MS Sans Serif, Geneva, sans-serif'                => 'MS Sans Serif',
		'MS Serif, New York, serif'                        => 'MS Serif',
	);

	return $faces;
}

function cyberchimps_typography_styles( $styles ) {
	$styles = array( 'normal' => 'Normal', 'bold' => 'Bold' );

	return $styles;
}

add_filter( 'cyberchimps_typography_sizes', 'cyberchimps_typography_sizes' );
add_filter( 'cyberchimps_typography_faces', 'cyberchimps_typography_faces' );
add_filter( 'cyberchimps_typography_styles', 'cyberchimps_typography_styles' );

/**
 * Logo toggle
 *
 * @return boolean
 */
function cyberchimps_logo_toggle() {
	//turn toggle on by default
	$toggle = 1;

	return $toggle;
}

add_filter( 'cyberchimps_logo_toggle', 'cyberchimps_logo_toggle', 10 );

/**
 * Default logo in header
 *
 * @return url
 */
function cyberchimps_default_logo() {
	$url = get_template_directory_uri() . '/images/logo.png';

	return $url;
}

add_filter( 'cyberchimps_default_logo', 'cyberchimps_default_logo', 10 );

/**
 * Default Slider 1
 *
 * @return url
 */
function cyberchimps_slide_pro_img1() {
	$url = '/images/branding/slide1.jpg';

	return $url;
}

add_action( 'cyberchimps_slider_lite_img1', 'cyberchimps_slide_pro_img1', 10 );

/**
 * Default Slider 2
 *
 * @return url
 */
function cyberchimps_slide_pro_img2() {
	$url = '/images/branding/defaultslide.jpg';

	return $url;
}

add_action( 'cyberchimps_slider_lite_img2', 'cyberchimps_slide_pro_img2', 10 );

/**
 * Default Slider 3
 *
 * @return url
 */
function cyberchimps_slide_pro_img3() {
	$url = '/images/branding/defaultslide.jpg';

	return $url;
}

add_action( 'cyberchimps_slider_lite_img3', 'cyberchimps_slide_pro_img3', 10 );

/**
 * Add font to default fonts
 *
 * @param array $fonts
 *
 * @return array
 */
function cyberchimps_typography_faces_include( $fonts ) {
	$new_font = array(
		'"Open Sans", Helvetica, Arial, "Lucida Grande", sans-serif' => 'Open Sans'
	);

	$fonts = array_merge( $new_font, $fonts );

	return $fonts;
}

add_filter( 'cyberchimps_typography_faces', 'cyberchimps_typography_faces_include', 10, 1 );

/**
 * Sets default font settings
 *
 * @param array null $font
 *
 * @return array
 */
function cyberchimps_typography_defaults( $font ) {
	$font['face'] = '"Open Sans", Helvetica, Arial, "Lucida Grande", sans-serif';

	return $font;
}

add_filter( 'cyberchimps_typography_defaults', 'cyberchimps_typography_defaults', 10, 1 );

/**
 * Overwrites the core body style functions to place background image in the #sub_body div
 *
 * @return array
 */
function cyberchimps_css_styles() {
	$body_styles      = cyberchimps_body_styles();
	$link_styles      = cyberchimps_link_styles();
	$container_styles = cyberchimps_layout_styles();?>

	<style type="text/css" media="all">
		<?php if ( !empty( $body_styles ) ) : ?>
		body {
		<?php foreach( $body_styles as $key => $body_style ): ?> <?php echo $key; ?> : <?php echo $body_style; ?>;
		<?php endforeach; ?>
		}

		<?php if( isset( $body_styles['background-image'] ) ): ;?>
		#sub_body {
			background: <?php echo $body_styles['background-image']; ?>;
		}

		<?php endif; ?>
		<?php endif; ?>
		<?php if ( !empty( $link_styles ) ) : ?>
		<?php foreach( $link_styles as $key2 => $link_style ): ?>
		<?php echo $key2; ?>
		{
			color:
		<?php echo $link_style; ?>
		;
		}
		<?php endforeach; ?>
		<?php endif; ?>
		<?php if ( !empty( $container_styles ) ) : ?>
		.container {
		<?php foreach( $container_styles as $key3 => $container_style ): ?> <?php echo $key3; ?> : <?php echo $container_style; ?> px;
		<?php endforeach; ?>
		}

		<?php endif; ?>
	</style>
	<?php
	return;
}
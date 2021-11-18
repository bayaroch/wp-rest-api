<?php
@ini_set( 'upload_max_size' , '10M' );
@ini_set( 'post_max_size', '10M');
@ini_set( 'max_execution_time', '300' );
/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
	add_image_size('large', 1200, '', true); // Large Thumbnail
    add_image_size('medium', 800, 800, true); // Large Thumbnail
    add_image_size('thumbnail', 493, 258, true); // Large Thumbnailss
    add_image_size('author', 200, 200, true); // Large Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/




function og_excerpt($text, $excerpt){
    
    if ($excerpt) return $excerpt;

    $text = strip_shortcodes( $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $text = strip_tags($text);
    $excerpt_length = apply_filters('excerpt_length', 100);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split("/[\n
     ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
    } else {
            $text = implode(' ', $words);
    }

    return apply_filters('wp_trim_excerpt', $text, $excerpt);
}




// HTML5 Blank navigation
function side_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'side-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

function admin_style() {
    wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}
add_action('login_enqueue_scripts', 'admin_style');



function header_nav()
{
    wp_nav_menu(
    array(
        'theme_location'  => 'header-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}

function footer_nav()
{
    wp_nav_menu(
    array(
        'theme_location'  => 'footer-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}


function brand_nav()
{
    wp_nav_menu(
    array(
        'theme_location'  => 'brand-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'cat-list',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}






// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'side-menu' => __('Side Menu', 'html5blank'), // Sidebar Navigation
        'footer-menu' => __('Footer Menu', 'html5blank'), // Extra Navigation if needed (duplicate as many as you need!)
        'brand-menu' => __('Brand Menu', 'html5blank'),
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}



// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}



// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}


// Add new_customer_notice field to rest
function register_new_customer_notice_api_field(){
	register_rest_field('post', 'new_customer_notice',
	array(
	'get_callback' => 'get_new_customer_notice_api_field',
	'schema' => null,
	));
   }
   add_action('rest_api_init', 'register_new_customer_notice_api_field');
   
   // Add the call back for the REST API
   function get_new_customer_notice_api_field($post){
	return get_field('new_customer_notice', $post['id']);
   }


/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_video'); // Add our HTML5 Blank Custom Post Type

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery Post endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function _post_type_rewrite() {
    global $wp_rewrite;
 
    // Set the query arguments used by WordPress
    $queryarg = 'post_type=video&p=';
 
    // Concatenate %cpt_id% to $queryarg (eg.. &p=123)
    $wp_rewrite->add_rewrite_tag( '%cpt_id%', '([^/]+)', $queryarg );
 
    // Add the permalink structure
    $wp_rewrite->add_permastruct( 'video', '/video/%cpt_id%/', false );
}
add_action( 'init', '_post_type_rewrite' );

function _post_type_permalink( $post_link, $id = 0, $leavename ) {
    global $wp_rewrite;
    $post = get_post( $id );
    if ( is_wp_error( $post ) )
        return $post;
        $newlink = $wp_rewrite->get_extra_permastruct( 'video' );
 
        // Replace %cpt_id% in permalink structure with actual post ID
        $newlink = str_replace( '%cpt_id%', $post->ID, $newlink );
        $newlink = home_url( user_trailingslashit( $newlink ) );
    return $newlink;
}
add_filter('post_type_link', '_post_type_permalink', 1, 3);



function create_post_type_video()
{
    register_post_type('video', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Video post', 'html5blank'), // Rename these to suit
            'singular_name' => __('Video Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New Video Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit Video post', 'html5blank'),
            'new_item' => __('New Video Post', 'html5blank'),
            'view' => __('View Video Post', 'html5blank'),
            'view_item' => __('View Video Post', 'html5blank'),
            'search_items' => __('Search Video Post', 'html5blank'),
            'not_found' => __('No Video post not found', 'html5blank'),
            'not_found_in_trash' => __('No Video post found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'rewrite' => array( 'slug' => 'video' ),
    ));
}

add_action( 'init', 'create_area_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_area_taxonomies() {

  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name'                       => _x( 'Post Brand', 'brand', 'html5blank' ),
    'singular_name'              => _x( 'Post Brand', 'brand', 'html5blank' ),
    'search_items'               => __( 'Search Post Brands', 'html5blank' ),
    'popular_items'              => __( 'Popular Post Brands', 'html5blank' ),
    'all_items'                  => __( 'All Post Brands', 'html5blank' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit Post Brands', 'html5blank' ),
    'update_item'                => __( 'Update Post Brands', 'html5blank' ),
    'add_new_item'               => __( 'Add New Post Brands', 'html5blank' ),
    'new_item_name'              => __( 'New Post Brands', 'html5blank' ),
    'separate_items_with_commas' => __( 'Separate Area with commas', 'html5blank' ),
    'add_or_remove_items'        => __( 'Add or remove Post Brands', 'html5blank' ),
    'choose_from_most_used'      => __( 'Choose from the most used Post Brands', 'html5blank' ),
    'not_found'                  => __( 'No Post Brands found.', 'html5blank' ),
    'menu_name'                  => __( 'Post Brands', 'html5blank' ),
  );

  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'b' ),
     'exclude_from_search' => false,
  );

  register_taxonomy( 'brand', 'post', $args );


   // Add new taxonomy, NOT hierarchical (like tags)
  $typelabels = array(
    'name'                       => _x( 'Post type', 'Post type', 'html5blank' ),
    'singular_name'              => _x( 'Post type', 'Post type', 'html5blank' ),
    'search_items'               => __( 'Search Post type', 'html5blank' ),
    'popular_items'              => __( 'Popular Post type', 'html5blank' ),
    'all_items'                  => __( 'All Post type', 'html5blank' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit Post type', 'html5blank' ),
    'update_item'                => __( 'Update Post type', 'html5blank' ),
    'add_new_item'               => __( 'Add New Post type', 'html5blank' ),
    'new_item_name'              => __( 'New Post type Name', 'html5blank' ),
    'separate_items_with_commas' => __( 'Separate Post type with commas', 'html5blank' ),
    'add_or_remove_items'        => __( 'Add or remove Post type', 'html5blank' ),
    'choose_from_most_used'      => __( 'Choose from the most used Post type', 'html5blank' ),
    'not_found'                  => __( 'No Post type found.', 'html5blank' ),
    'menu_name'                  => __( 'Post type', 'html5blank' ),
  );

  $typeargs = array(
    'hierarchical'          => true,
    'labels'                => $typelabels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 't' ),
     'exclude_from_search' => false,
  );

  register_taxonomy( 'type', 'post', $typeargs );

}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

?>
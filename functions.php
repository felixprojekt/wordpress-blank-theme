<?php
if (function_exists('add_theme_support')) {
    // Add Menu Support
    add_theme_support('menus');

    add_theme_support('post-thumbnails');
    add_image_size('photo', 1440, '', true);
    add_image_size('large', 750, '', true);
    add_image_size('medium', 500, '', true); 
    add_image_size('small', 250, '', true); 

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('theme', get_template_directory().'/languages');
}

function theme_nav()
{
    wp_nav_menu(
        [
            'theme_location' => 'header-menu',
            'menu' => '',
            'container' => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul>%3$s</ul>',
            'depth' => 0,
            'walker' => '',
        ]
    );
}

function theme_custom_script($handle, $path, $deps = [], $in_footer = true) {
    $uri = get_theme_file_uri($path);
    $version = filemtime(get_theme_file_path($path));
    wp_enqueue_script($handle, $uri, $deps, $version, $in_footer);
}

function theme_custom_style($handle, $path, $deps = [], $media = "all") {
    $uri = get_theme_file_uri($path);
    $version = filemtime(get_theme_file_path($path));
    wp_enqueue_style($handle, $uri, $deps, $version, $media);
}

function theme_styles()
{
    theme_custom_style('theme', '/style.css');
    theme_custom_style('main', '/css/main.css');

    if ('wp-login.php' != $GLOBALS['pagenow'] && !is_admin()) {
        theme_custom_script('themescripts', '/js/scripts.js', ['jquery'], true);
    }

    // Example of conditional script
    // if (is_page('pagenamehere')) {
    //     theme_custom_script('scriptname', '/js/scriptname.js', ['jquery'], true);
    // }
}

function register_html5_menu()
{
    register_nav_menus([ // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'theme'), // Main Navigation
    ]);
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
    return is_array($var) ? [] : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

if (function_exists('register_sidebar')) {
    register_sidebar([
        'name' => __('Widget Area 1', 'theme'),
        'description' => __('Description for this widget-area...', 'theme'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ]);

    register_sidebar([
        'name' => __('Widget Area 2', 'theme'),
        'description' => __('Description for this widget-area...', 'theme'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ]);
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links([
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
    ]);
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;

    return '... <a class="view-article" href="'.get_permalink($post->ID).'">'.__('View Article', 'theme').'</a>';
}

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
function remove_thumbnail_dimensions($html)
{
    return preg_replace('/(width|height)=\"\d*\"\s/', '', $html);
}

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/
add_action('wp_enqueue_scripts', 'theme_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'theme_create_post_types'); // Add our HTML5 Blank Custom Post Type
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

function theme_create_post_types()
{
    register_taxonomy('category_for_post_type_name_here', ['category_for_post_type_name_here'], [
        'labels' => [
            'name' => _x('CustomPost Categories', 'taxonomy general name', 'theme'),
            'singular_name' => _x('CustomPost Category', 'taxonomy singular name', 'theme'),
            'search_items' => __('Search', 'theme'),
            'all_items' => __('All', 'theme'),
            'parent_item' => __('Parent', 'theme'),
            'parent_item_colon' => __('Parent:', 'theme'),
            'edit_item' => __('Edit', 'theme'),
            'update_item' => __('Update', 'theme'),
            'add_new_item' => __('Add New', 'theme'),
            'new_item_name' => __('New Name', 'theme'),
            'menu_name' => __('CustomPost Categories', 'theme'),
        ],
        'hierarchical' => true, //true for checkboxes, false for tag list
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'custom_post_category'],
    ]);
    
    register_post_type('custom_post_type_name_here', // Register Custom Post Type
        [
            'labels' => [
                'name' => __('CustomPosts', 'theme'),
                'singular_name' => __('CustomPost', 'theme'),
                'add_new' => __('Add New', 'theme'),
                'add_new_item' => __('Add New Post', 'theme'),
                'edit' => __('Edit', 'theme'),
                'edit_item' => __('Edit Post', 'theme'),
                'new_item' => __('New Post', 'theme'),
                'view' => __('View', 'theme'),
                'view_item' => __('View Post', 'theme'),
                'view_items' => __('View Posts', 'theme'),
                'search_items' => __('Search Posts', 'theme'),
                'not_found' => __('No posts found', 'theme'),
                'not_found_in_trash' => __('No posts found in Trash', 'theme'),
            ],
            'public' => true,
            'can_export' => true, // Allows export in Tools > Export
            'show_in_rest' => false, // Set this to true if you want to use Gutenberg with this CPT
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'menu_icon' => 'dashicons-welcome-write-blog',
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'revisions',
                // 'page-attributes', // Allows menu_order and other page-like attributes
            ],
            'taxonomies' => [
                'category_for_post_type_name_here'
            ]
        ]);
    
    
}

//Edit post link to open in new tab
add_filter('edit_post_link', function ($link, $post_id, $text) {
    // Add the target attribute
    if (false === strpos($link, 'target=')) {
        $link = str_replace('<a ', '<a target="_blank" ', $link);
    }

    return $link;
}, 10, 3);


function wbt_admin_css()
{
    echo '<style>
  .wp-block {
        max-width: 1300px;
    }
  </style>';
}

add_action('admin_head', 'wbt_admin_css');

function theme_editor_styles()
{
    add_theme_support('editor-styles');

    //Path to editor CSS
    //add_editor_style(get_template_directory_uri().'/css/editor.css');
}

add_action('after_setup_theme', 'theme_editor_styles');

/**
 * Create Logo Setting and Upload Control.
 *
 * @param mixed $wp_customize
 */
function brand_logo_in_customizer($wp_customize)
{
    $wp_customize->add_setting('header_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'header_logo',
        [
            'label' => 'Nahrát logo',
            'section' => 'title_tagline',
            'settings' => 'header_logo',
        ]
    ));
}
add_action('customize_register', 'brand_logo_in_customizer');

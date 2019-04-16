<?php

/**
 * Proper way to enqueue scripts and styles
 */

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );	
}

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_script',10 );
function enqueue_parent_theme_script() {
	wp_enqueue_script('custom-script',	get_bloginfo( 'stylesheet_directory' ). '/js/main.js', array( 'jquery' ),'1.0',true	);
}

function remove_main_scripts()
{
    wp_dequeue_script( 'main' );
}
add_action( 'wp_enqueue_scripts', 'remove_main_scripts', 11 );

//REMOVE #link of Readmore
function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

//DISPLAY future post
function onetarek_prevent_future_type( $post_data ) {
	if ( $post_data['post_status'] == 'future' && $post_data['post_type'] == 'post' )#Here I am checking post_type='post' , you may use different post type and if you want it for all post type then remove "&& $post_data['post_type'] == 'post'"
	{
		$post_data['post_status'] = 'publish';
	}
	return $post_data;
}
add_filter('wp_insert_post_data', 'onetarek_prevent_future_type');
remove_action('future_post', '_future_post_hook');

if(!function_exists('codeless_logo'))
{

    function codeless_logo($default = "")
    {
        global $cl_redata, $polylang;
        $output = '';
        if(!empty($cl_redata['logo']['url']) || !empty($cl_redata['logo_light']['url']) )
        {
			$logo = get_bloginfo('name');
            if(!empty($cl_redata['logo']['url']))
              $logo = "<img class='dark' src=".esc_url($cl_redata['logo']['url'])." alt='$logo' />";
            if(!empty($cl_redata['logo_light']['url']))
              $logo_light = "<img class='light' src=".esc_url($cl_redata['logo_light']['url'])." alt='' />";
            
            
            if ( $polylang->curlang->slug == 'en' ) {
                $logo = "<a href='".esc_url(home_url('/'))."home/'>".$logo.$logo_light."</a>";
            } else {
                $logo = "<a href='".esc_url(home_url('/'))."'>".$logo.$logo_light."</a>";
            }
            
        }
        else
        { 
            $logo = get_bloginfo('name');
            if($default != '') $logo = "<img src=".esc_url($default)." alt='' title='$logo'/>";
            $logo = "<a href='".esc_url(home_url('/'))."'>".$logo."</a>";
        }
    
        return $logo;
    }
}

// Remove update notification
function remove_core_updates(){
    global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
//add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');

/*
// Add term page
function taxonomy_add_new_meta_field() {
    // this will add the custom meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[order_portfolio]"><?php echo __('Order'); ?></label>
        <input type="number" name="term_meta[order_portfolio]" id="term_meta[order_portfolio]" value="">
    </div>
<?php
}
add_action( 'portfolio_entries_add_form_fields', 'taxonomy_add_new_meta_field', 10, 2 );


// Edit term page
function taxonomy_edit_new_meta_field($term) {
 
    // put the term ID into a variable
    $t_id = $term->term_id;
 
    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$t_id" ); ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[order_portfolio]"><?php echo __('Order'); ?></label></th>
        <td>
            <input type="text" name="term_meta[order_portfolio]" id="term_meta[order_portfolio]" value="<?php echo esc_attr( $term_meta['order_portfolio'] ) ? esc_attr( $term_meta['order_portfolio'] ) : ''; ?>">
        </td>
    </tr>
<?php
}
add_action( 'portfolio_entries_edit_form_fields', 'taxonomy_edit_new_meta_field', 10, 2 );

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}  
add_action( 'edited_portfolio_entries', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_portfolio_entries', 'save_taxonomy_custom_meta', 10, 2 );

*/
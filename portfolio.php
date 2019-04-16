<?php
/*
Template Name: Portfolio Page
*/
global $cl_redata, $polylang;;

global $cl_current_view;
$cl_current_view = 'portfolio';

$id = codeless_get_post_id(); 
$replaced = redux_post_meta('cl_redata',(int) $id);

if(!empty($replaced))
    foreach($replaced as $key => $value){
        $cl_redata[$key] = $value;
    }

get_header();
get_template_part('includes/view/page_header');

?>

<section id="content" class="content_portfolio <?php echo esc_attr($cl_redata['portfolio_layout']) ?> layout-<?php echo esc_attr($cl_redata['layout']) ?>">
    
    <?php if($cl_redata['portfolio_content'] == 'top'): ?>
        <?php get_template_part( 'includes/view/loop', 'page' ); ?>
    <?php endif; ?>

    <?php if($cl_redata['portfolio_layout'] == 'in_container'): ?>
    <div class="container">
    <?php endif; ?>
        <div class="row-fluid filter-row">
			<?php if(!empty($cl_redata['portfolio_categories'])): ?>
                <?php if($cl_redata['portfolio_layout'] == 'fullwidth'): ?>
                <div class="container">
                <?php endif; ?>
            		<!-- Portfolio Filter -->
            		<nav id="portfolio-filter" class="span12">
                		<ul class="">
							<?php if (get_the_ID() == 715 || get_the_ID() == 2005) { //APPLY ONLY PRODUCT PAGE ?>
							
								<?php 

                                if ( $polylang->curlang->slug == 'en' ) {
                                    sort( $cl_redata['portfolio_categories'] ); // sort by id
                                }

                                foreach( $cl_redata['portfolio_categories'] as $cat ): 
                                ?>
                                <?php $cat = get_term($cat, 'portfolio_entries');

                                
								/*
								if ($cat->slug == "_thermopompes") { //Change Thermopomes to Single link ?>

									<li class="" <?php if( ($cat->slug) =="formes-de-piscine"){ echo("id='set-default'"); }?>  data-filter=".<?php echo esc_attr($cat->slug) ?>"><a href="<?php get_site_url()?>/codeless_portfolio/1757/"><?php echo esc_html($cat->name) ?></a></li>

                                <?php } else if ( $cat->slug == "_water-heat-pumps" ) { ?>

                                    <li class="" <?php if( ($cat->slug) =="formes-de-piscine"){ echo("id='set-default'"); }?>  data-filter=".<?php echo esc_attr($cat->slug) ?>"><a href="<?php get_site_url()?>/en/codeless_portfolio/r2350ti-2/"><?php echo esc_html($cat->name) ?></a></li>

								<?php } else { */?>

									<li class="other filter" <?php if( $cat->slug =="formes-de-piscine" || $cat->slug =="pool-shapes" ) { echo("id='set-default'"); } ?>  data-filter=".<?php echo esc_attr($cat->slug) ?>"><a href="#" class="filter" data-filter=".<?php echo esc_attr($cat->slug) ?>"><?php echo esc_html($cat->name) ?></a></li>

								<?php //} ?>
								
								<?php endforeach; ?>
								
							<?php }else{ ?>
								<li class="filter active all" data-filter="all">
                                    <a href="#" class="filter active" data-filter="all">
                                        <?php echo __('See all') ?>
                                    </a>
                                </li>
								<?php foreach($cl_redata['portfolio_categories'] as $cat): ?>
									<?php $cat = get_term($cat, 'portfolio_entries'); ?>
									<li class="other filter"  data-filter=".<?php echo esc_attr($cat->slug) ?>"><a href="#" class="filter" data-filter=".<?php echo esc_attr($cat->slug) ?>"><?php echo esc_html($cat->name) ?></a></li>
                    
								<?php endforeach; ?>
							<?php } ?>                			
                		</ul>
            		</nav>
                <?php if($cl_redata['portfolio_layout'] == 'fullwidth'): ?>
                </div>
                <?php endif; ?>
    	    <?php endif; ?>
        </div>
    

	    <?php 
	    	
            $grid = 'three-cols';
		    switch($cl_redata['portfolio_columns']){
		        case '3':
		            $grid = 'three-cols';
		            break;
		        case '2':
		            $grid = 'two-cols';
		            break;
		        case '4':
		            $grid = 'four-cols';
		            break;
                case '5':
                    $grid = 'five-cols';
                    break;
		        case '1':
		            $grid = 'one-cols';
		            break;
		    }

    	?>
        <div class="row-fluid">
            <?php if($cl_redata['layout'] == 'sidebar_left') get_sidebar(); ?>

            <?php if($cl_redata['layout'] != 'fullwidth'): ?>
            <div class="span9">
            <?php endif; ?>

                <section id="portfolio-preview-items" class="<?php echo esc_attr($grid) ?> <?php echo esc_attr($cl_redata['portfolio_space']) ?> span<?php echo esc_attr($spancontent) ?>" data-cols="<?php echo esc_attr($cl_redata['portfolio_columns']) ?>">
                <?php
                        
                        if($cl_redata['portfolio_mode'] == 'grid')
                            get_template_part('includes/view/portfolio/loop', 'grid');

                        else if($cl_redata['portfolio_mode'] == 'masonry')
                            get_template_part('includes/view/portfolio/loop', 'masonry');
                        
                        wp_reset_query();
                        
                ?>
                </section>
                
            <?php if($cl_redata['layout'] != 'fullwidth'): ?>
            </div>
            <?php endif; ?>

            <?php if($cl_redata['layout'] == 'sidebar_right') get_sidebar(); ?>
		</div>
    <?php if($cl_redata['portfolio_layout'] == 'in_container'): ?>
	</div>
    <?php endif; ?>
    <?php if($cl_redata['portfolio_content'] == 'bottom'): ?>
        <?php get_template_part( 'includes/view/loop', 'page' ); ?>
    <?php endif; ?>
</section>
<?php get_footer(); ?>
<?php
//2420
// echo __FILE__;
// echo get_the_ID();
// $content_post = get_post(2420);
// $content = $content_post->post_content;
/* 
Template Name: Service Page
*/
get_header(); ?>
<?php
$args = array(
    'post_type' => 'service',
    'orderby' => 'ID',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$result = new WP_Query($args);
?>
<div class="title-bar-header" style="color:#181818; padding-top:58px; padding-bottom:50px;">
    <div class="container">
        <div class="page-breadcrumbs text-center">
            <nav class="breadcrumbs">
                <span><a class="home" href="http://localhost/inerior2" contextmenu="fcltHTML5Menu1"><span>
                            Home</span></a>
                </span><span class="sep">/</span>
                <span>
                    <span>Service</span>
                </span>
            </nav>
            <h4 style="font-size:30px; color:#181818; ">service </h4>
        </div>
    </div>
</div>
<?php if (have_posts()): ?>
    <div class="container main-content">
        <div class="service-container kitgreen-service-holder grid2 ">
            <div class="row">
                <?php while ($result->have_posts()):  $result->the_post();     ?>
                    <div class="tb-products-grid  col-md-4 col-sm-6 col-xs-12 col-xs-66 ">
                        <article
                            class="post-2380 product type-product status-publish has-post-thumbnail product_cat-uncategorized first instock shipping-taxable product-type-simple">
                            <div class="product-thumb">
                                <a href="<?php echo  get_the_permalink(); ?>"><img width="1920" height="1366"
                                        src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ))[0]; ?>"
                                        class="attachment-shop_catalog size-shop_catalog" alt="ART EXTRAGAVANZA"
                                        decoding="async" fetchpriority="high"></a>
                              
                            </div>
                            <div class="product-content">
                                <div class="item-bottom">
                                <?php                                      
                                $limit =20;
                                $content =  get_the_content() ?? get_the_excerpt();
                                $content = explode(' ', $content , $limit);
                                if (count($content)>=$limit) {
                                    array_pop($content);
                                    $content = implode(" ",$content).'...';
                                } else {
                                    $content = implode(" ",$content);
                                } 
                                $content = preg_replace('/\[.+\]/','', $content);
                                $content = apply_filters('the_content', $content); 
                                echo $content = str_replace(']]>', ']]&gt;', $content);                              
                                ?>
                                </div>
                                <div class="item-top">
                                    <h6 class="product-title"> <a href="<?php echo  get_the_permalink(); ?>" contextmenu="fcltHTML5Menu1"><?php echo get_the_title();; ?></a></h6>
                                </div>              
                            </div>
                        </article>
                    </div>
                <?php endwhile; // end of the loop.  ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="before-footer">
<?php //echo do_shortcode('' . $blog_shortcoe . ''); ?>
</div>
<?php get_footer(); ?>
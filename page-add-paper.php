<?php
    /* Template Name: Add Paper */
?>
<?php get_header(); ?>

<section class="section-header">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <div class="container">
        <?php if(function_exists('bcn_display'))
        {
            bcn_display();
        }?>
    </div>
</div>

<section role="main" class="primary-content add-paper">
    <div class="container">
        <?php
            if (!paper_limit_met(bp_loggedin_user_id())) {
                gravity_form( 1, false, false, false, '', false );
            } else {
                echo '<p class="info">Note: You have already added two papers for this calendar year.  To add another, you must remove one of your ' . date('Y') . ' submissions.</p>';
            }
        ?>
    </div>
</section>

<?php get_footer( 'no-sidebar' ); // will include footer-no-sidebar.php; ?>

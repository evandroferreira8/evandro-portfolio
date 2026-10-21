<?php get_header(); ?><main id="conteudo" style="min-height:60vh;padding:130px max(6vw,22px) 70px;background:#ecebe6;color:#1a1d1b">
<?php while(have_posts()):the_post(); ?><article style="max-width:900px"><h1><?php the_title(); ?></h1><?php the_content(); ?></article><?php endwhile; ?>
<p><a href="<?php echo esc_url(home_url('/')); ?>">← Voltar ao portfólio</a></p></main><?php get_footer(); ?>
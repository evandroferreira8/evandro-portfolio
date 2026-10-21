<?php get_header(); ?><main id="conteudo" style="min-height:60vh;padding:130px max(6vw,22px) 70px;background:#ecebe6;color:#1a1d1b">
<h1>Publicações</h1>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
<article style="padding:25px 0;border-bottom:1px solid #c6c6bd;max-width:850px"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></article>
<?php endwhile; the_posts_pagination(); else: ?><p>Nenhuma publicação cadastrada.</p><?php endif; ?>
<p><a href="<?php echo esc_url(home_url('/')); ?>">← Voltar ao portfólio</a></p></main><?php get_footer(); ?>
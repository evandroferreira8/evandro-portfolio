<?php
/** Tema de laboratório, sem modificar o portfólio público. */
if(!defined('ABSPATH')){exit;}
add_action('after_setup_theme',function(){
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5',array('search-form','gallery','caption','style','script'));
});
add_action('wp_enqueue_scripts',function(){
  wp_enqueue_style('ef-fonts','https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Manrope:wght@400;500;600;700&family=Newsreader:opsz,wght@6..72,400;6..72,500&family=Playfair+Display:ital,wght@0,500;1,500&display=swap',array(),null);
  wp_enqueue_style('ef-portfolio',get_template_directory_uri().'/assets/css/portfolio.css',array('ef-fonts'),'1.0.0');
  wp_enqueue_script('ef-portfolio',get_template_directory_uri().'/assets/js/script.js',array(),'1.0.0',true);
});
add_action('init',function(){
  register_post_type('ef_foto',array(
    'labels'=>array('name'=>'Fotos do portfólio','singular_name'=>'Foto','add_new_item'=>'Adicionar fotografia','edit_item'=>'Editar fotografia','menu_name'=>'Fotos'),
    'public'=>true,'publicly_queryable'=>false,'show_ui'=>true,'show_in_rest'=>true,
    'menu_icon'=>'dashicons-format-gallery',
    'supports'=>array('title','excerpt','thumbnail'),'has_archive'=>false,'rewrite'=>false
  ));
});
add_action('customize_register',function($wp_customize){
  $wp_customize->add_section('ef_portfolio_content',array(
    'title'=>'Conteúdo do portfólio (teste)',
    'description'=>'Edite os textos e confira o resultado na página inicial. Para acrescentar imagens, use o menu Fotos.',
    'priority'=>30
  ));
  $fields=array(
    'ef_intro'=>array('Apresentação da capa',"Histórias em texto, imagem e movimento.\nUm espaço para percursos, olhares e projetos."),
    'ef_bio_one'=>array('Sobre — primeiro parágrafo','Sou jornalista formado pela Universidade Federal do Rio Grande do Norte. Minha trajetória passa por reportagem, audiovisual, comunicação institucional, ciência e produção digital.'),
    'ef_bio_two'=>array('Sobre — segundo parágrafo','Este site não foi pensado como uma vitrine tradicional. É um espaço para reunir percursos, imagens, histórias e projetos que dizem algo sobre o modo como observo e comunico o mundo.'),
    'ef_stories_intro'=>array('Histórias — introdução','Aqui, os trabalhos deixam de ser apenas referência visual: os links levam diretamente às publicações disponíveis na web.'),
    'ef_contact_intro'=>array('Contato — introdução','Para conversar, colaborar ou acompanhar meu trabalho, estes são os caminhos que já estão públicos:')
  );
  foreach($fields as $id=>$values){
    $wp_customize->add_setting($id,array('default'=>$values[1],'sanitize_callback'=>'sanitize_textarea_field','transport'=>'refresh'));
    $wp_customize->add_control($id,array('label'=>$values[0],'section'=>'ef_portfolio_content','type'=>'textarea'));
  }
});
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

/* Laboratório: remover a barra administrativa desformatada no site. */
add_filter('show_admin_bar','__return_false');
function ef_fields(){
 return array(
  'ef_intro'=>array('Texto da capa',"Histórias em texto, imagem e movimento.\nUm espaço para percursos, olhares e projetos."),
  'ef_bio_one'=>array('Sobre — 1º parágrafo','Sou jornalista formado pela Universidade Federal do Rio Grande do Norte. Minha trajetória passa por reportagem, audiovisual, comunicação institucional, ciência e produção digital.'),
  'ef_bio_two'=>array('Sobre — 2º parágrafo','Este site não foi pensado como uma vitrine tradicional. É um espaço para reunir percursos, imagens, histórias e projetos que dizem algo sobre o modo como observo e comunico o mundo.'),
  'ef_stories_intro'=>array('Apresentação das matérias','Aqui, os trabalhos deixam de ser apenas referência visual: os links levam diretamente às publicações disponíveis na web.'),
  'ef_contact_intro'=>array('Texto do contato','Para conversar, colaborar ou acompanhar meu trabalho, estes são os caminhos que já estão públicos:')
 );
}
add_action('admin_menu',function(){
 add_menu_page('Editar portfólio','Editar portfólio','edit_theme_options','ef-portfolio-editor','ef_portfolio_editor_page','dashicons-edit',3);
});
add_action('admin_post_ef_save_content',function(){
 if(!current_user_can('edit_theme_options'))wp_die('Sem permissão.');
 check_admin_referer('ef_save_content');
 $data=isset($_POST['ef_textos'])&&is_array($_POST['ef_textos']) ? wp_unslash($_POST['ef_textos']):array();
 foreach(ef_fields() as $key=>$meta){
  if(isset($data[$key])&&is_string($data[$key]))set_theme_mod($key,sanitize_textarea_field($data[$key]));
 }
 wp_safe_redirect(admin_url('admin.php?page=ef-portfolio-editor&saved=1'));exit;
});
function ef_portfolio_editor_page(){
 if(!current_user_can('edit_theme_options'))return;
 ?>
 <div class="wrap ef-simple-editor">
 <style>
 .ef-simple-editor{max-width:1050px;padding:24px 10px 75px}
 .ef-simple-editor h1{font-size:36px;font-weight:750;line-height:1.2;color:#111412}
 .ef-simple-editor p{font-size:16px;line-height:1.6}
 .ef-simple-editor .ef-actions{display:flex;flex-wrap:wrap;gap:10px;margin:22px 0}
 .ef-simple-editor .ef-actions a{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:10px 17px;border-radius:8px;background:#234e58;color:white;text-decoration:none;font-size:15px;font-weight:700}
 .ef-simple-editor .ef-actions a:hover,.ef-simple-editor .ef-actions a:focus-visible{background:#326873;color:#fff}
 .ef-simple-editor form{background:#fff;border:1px solid #d6dcd6;border-radius:13px;padding:30px;box-shadow:0 10px 35px rgba(0,0,0,.04)}
 .ef-simple-editor form h2{font-size:24px;margin:0 0 25px}
 .ef-simple-editor label{display:block;font-size:16px;font-weight:750;margin:0 0 8px}
 .ef-simple-editor textarea{width:100%;box-sizing:border-box;display:block;border:1px solid #879789;border-radius:7px;padding:12px;min-height:104px;font-size:16px;line-height:1.55;resize:vertical}
 .ef-simple-editor .ef-field{margin-bottom:26px}
 .ef-simple-editor .button-primary{font-size:16px;min-height:48px;padding:10px 24px;border-radius:6px;background:#234e58;border-color:#234e58}
 .ef-simple-editor .button-primary:hover{background:#326873}
 @media(max-width:782px){.ef-simple-editor h1{font-size:28px}.ef-simple-editor form{padding:18px}}
 </style>
 <h1>Editar o portfólio</h1>
 <p>Altere os textos abaixo, clique em <strong>Salvar alterações</strong> e depois em <strong>Ver o portfólio</strong>. Tudo fica somente neste teste.</p>
 <?php if(isset($_GET['saved'])&&$_GET['saved']==='1'):?><div class="notice notice-success"><p>Alterações salvas neste laboratório.</p></div><?php endif;?>
 <div class="ef-actions">
  <a href="<?php echo esc_url(home_url('/')); ?>">↗ Ver o portfólio</a>
  <a href="<?php echo esc_url(admin_url('post-new.php?post_type=ef_foto')); ?>">+ Adicionar fotografia</a>
 </div>
 <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
  <h2>Textos editáveis</h2>
  <input type="hidden" name="action" value="ef_save_content"><?php wp_nonce_field('ef_save_content');?>
  <?php foreach(ef_fields() as $key=>$meta):?>
  <div class="ef-field">
   <label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($meta[0]); ?></label>
   <textarea rows="3" id="<?php echo esc_attr($key); ?>" name="ef_textos[<?php echo esc_attr($key); ?>]"><?php echo esc_textarea(get_theme_mod($key,$meta[1])); ?></textarea>
  </div>
  <?php endforeach;?>
  <button class="button button-primary" type="submit">Salvar alterações</button>
 </form>
 <p>Este teste não altera o site publicado. Para guardar alterações do Playground, utilize a opção de exportação antes de descartá-lo.</p>
 </div>
 <?php
}

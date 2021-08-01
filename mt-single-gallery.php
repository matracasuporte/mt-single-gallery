<?php
/*
Plugin name: Mt Single Gallery
Plugin uri: 
Description: Plugin de Gallery para o Flickr
Version: 1.0
Author: Matraca Suporte
Author uri: 
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' )) {
	exit;
}

define( 'MT_SINGLE_GALLERY_URL', plugin_dir_url( __FILE__ ));

add_action( 'wp_enqueue_scripts', 'mt_single_gallery_load' );
function mt_single_gallery_load(){
  
  // CSS
  wp_enqueue_style( 'mt_single_gallery', MT_SINGLE_GALLERY_URL . '/css/mt-single-gallery.min.css');	
}

add_shortcode('MT_SINGLE_GALLERY', 'mt_single_gallery_function');
function mt_single_gallery_function($attr) {

  $args = shortcode_atts( array(     
		'quantidade' => 3,
	), $attr ); 


  $template = '';

  $template .= '<div class="mt-single-gallery">';
  
  $template .= '<div class="gallery-grid">';
  for($i = 0; $i < 10; $i++) {
    $template .= '<a href="http://google.com" class="item" style=" background-image: url(' . MT_SINGLE_GALLERY_URL . 'img/bg.jpg); background-repeat: no-repeat; background-size: cover;">';
    $template .= '<div class="content"></div>';
    $template .= '<div class="footer">' . $i . ' Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae, tenetur. </div>';
    $template .= '</a>';
  }
  $template .= '</div>';

  $template .= '<div class="gallery-pagination">';
  $template .= '<button class="disabled">Anterior</button>';
  $template .= '<div>Página <strong>1</strong> de <strong>2</strong></div>';
  $template .= '<button>Próximo</button>';
  $template .= '<input type="hidden" id="mtGalleryQuantity" value="' . $args['quantidade'] . '">';
  $template .= '</div>';

  $template .= '</div>';

  // wp_reset_query();

  return $template;
}

add_action( 'wp_footer', 'mt_single_gallery_javascript');
function mt_single_gallery_javascript() { ?>
<script type="text/javascript">
(function($){ 
  var itemGallery = $('.mt-single-gallery .gallery-grid .item');
  var buttonNavigation = $('.gallery-pagination button');
  var strongNavigation = $('.gallery-pagination div');
  var mtGalleryQuantity = $('.gallery-pagination #mtGalleryQuantity');

  var itemPerPage = Number(mtGalleryQuantity.val());
  var itemBegin = 0;
  var itemEnd = itemPerPage;
  var quantityPage = Math.ceil(itemGallery.length / itemPerPage);
  var page = 1;

  //strongNavigation.hide();

  function showGalleryItem(begin, end) {
    itemGallery.hide();
    for (var i = begin; i < end; i++) {
      itemGallery.eq(i).show();
    }
    if (page === 1) {
      buttonNavigation.eq(0).addClass('disabled');
      buttonNavigation.eq(1).removeClass('disabled');
    }

    if (page > 1) {
      buttonNavigation.removeClass('disabled');
    }

    if (page === quantityPage) {
      buttonNavigation.eq(1).addClass('disabled');
    }
    strongNavigation.find('strong').eq(0).text(page);
    strongNavigation.find('strong').eq(1).text(quantityPage);
  }

  showGalleryItem(itemBegin, itemEnd, null, page);

  buttonNavigation.eq(0).click(function () {
    if (page > 1) {
      itemBegin -= itemPerPage;
      itemEnd -= itemPerPage;
      page -= 1;
      showGalleryItem(itemBegin, itemEnd);
    }
  });

  buttonNavigation.eq(1).click(function () {
    if (page < quantityPage) {
      itemBegin += itemPerPage;
      itemEnd += itemPerPage;
      page += 1;
      showGalleryItem(itemBegin, itemEnd);
    }
  });
})(jQuery);
</script>
<?php }
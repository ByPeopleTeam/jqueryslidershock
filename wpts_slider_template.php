<?php
if ( ! function_exists('ts_make_slider_scr') ){
	function ts_make_slider_scr() {

		wp_register_script( 'modernizr', plugin_dir_url(__FILE__).'/js/modernizr.js' );
		wp_register_script( 'jquery.refineslide', plugin_dir_url(__FILE__).'/js/jquery.refineslide.js' );
		wp_register_script( 'boostrap', plugin_dir_url(__FILE__).'/js/boostrap.js' );
		wp_register_script( 'wpts_slider_multiple', plugin_dir_url(__FILE__).'/js/wpts_slider_multiple.js' );
	}
}
if ( ! function_exists('ts_script_execute') ){	
	function ts_script_execute(){
		global $script_ts;
		echo $script_ts;
	}
}
function ts_make_slider_html($q_posts,$opt){
	extract($opt);
	static $sht;
	global $post,$script_ts;
	++$sht;
	$content='';
	$size=explode('-',$size);
	$id_sld=$id_sld_in=$id_inner_carrousel='myCarousel_'.$sht;
	$id_sld_in.='_inner';
	$id_inner_carrousel.='_fx';
	$id_scr='ts_scrol_'.$sht;
	if ($sht===1){
	?>
	<?php
		wp_enqueue_style('bootstrap-carousel',plugin_dir_url(__FILE__).'css/bootstrap-carousel.css');
		wp_enqueue_style('slider-borders',plugin_dir_url(__FILE__).'css/slider-borders.css');
		wp_enqueue_style('refineslide',plugin_dir_url(__FILE__).'css/refineslide.css');

		wp_enqueue_script('jquery');
		wp_enqueue_script( 'modernizr', plugin_dir_url(__FILE__).'/js/modernizr.js' );
		wp_enqueue_script( 'jquery.refineslide', plugin_dir_url(__FILE__).'/js/jquery.refineslide.js' );
		wp_enqueue_script( 'boostrap', plugin_dir_url(__FILE__).'/js/boostrap.js' );
		wp_enqueue_script( 'wpts_slider_multiple', plugin_dir_url(__FILE__).'/js/wpts_slider_multiple.js' );
	?>
	<!--<link rel='stylesheet' href='<?php echo plugin_dir_url(__FILE__);?>css/bootstrap-carousel.css' />
	<link rel='stylesheet' href='<?php echo plugin_dir_url(__FILE__);?>css/slider-borders.css' />
	<link rel='stylesheet' href='<?php echo plugin_dir_url(__FILE__);?>css/refineslide.css' />-->
<?php
		add_action('wp_print_footer_scripts', 'ts_make_slider_scr', 20);	
	}
	$class_pos='';
	$counter=0;
	switch($size[0]){
		case 'responsive':
			$width_img='100%';
			$height_img=$size[1];
			$offset_th=0;
		//	$thumb_img_w=20;
			$thumb_img_h=bcmul($height_img,0.20,0);
			$padding_ct=bcmul($height_img,0.03,0);
			if ($thumb_img_h>60){
				unset($thumb_img_h);
			}			
			if ($effect!=='default'){
				$ts_style_th="width:100%;margin:auto;";
			}else{
				$ts_margin_tr="margin:1px;";
			}
		break;
		default:
			$width_img=$size[0];
			$height_img=$size[1];
			$classnr="ts_sld_no_res_".$sht;
			$padding_ct=bcmul($width_img,0.03,0);
			$thumb_img_w=bcmul($width_img,0.20,0);
			$thumb_img_h=bcmul($width_img,0.20,0);
			if ($thumb_img_w>100){
				unset($thumb_img_w);
			}
			if ($thumb_img_h>60){
				unset($thumb_img_h);
			}
		break;
	}
	
	/*thumbs effects with images*/
	ob_start();	
	$img_default=plugin_dir_url(__FILE__).'img/default-image.png';
	$img_th_video=plugin_dir_url(__FILE__).'img/video-image.jpg';
	$background_sld=($background_item[0]==='#' || $background_item==='transparent')?$background_item:'url('.$background_item.')';
	$background_txt=($txt_bk[0]==='#' || $txt_bk==='transparent')?$txt_bk:'url('.$txt_bk.')';
	foreach($q_posts as $post){
		unset($get_img_p,$video_emb);
		switch($type){
			default:
				setup_postdata($post);		
				$id_post=get_the_ID();
				$get_img_p=wp_get_attachment_image_src( get_post_thumbnail_id($id_post),'large' );
				$img=get_the_post_thumbnail($id_post,'large');
				$img = preg_replace( '/(width|height)=\"\d*\"\s/', "", $img );
				$title_sld=get_the_title();
				$excerpt= get_the_excerpt();
				$time=get_the_time('F jS, Y');
				$author_sld=get_the_author();
			break;
		}
	?>
      <div class="item <?php echo($counter==0)?'active':'';  ?>">
				<div class="ts_border">
        <?php 
					if (!empty($get_img_p) ){///imagenes 
						$get_img_size[]=$get_img_p;// asigna la image a thumb
				?>
		      	<img src="<?php echo $get_img_p[0];?>"  width="<?php echo $width_img;	 ?>" height="<?php echo $height_img; ?>"  />
            
        <?php
        	}else{/// solo videos o si no existen
						if (isset($get_ts_video[0]) && !empty($get_ts_video[0])){
							if (ts_using_ie()===true){
								if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $get_ts_video[0], $match)) {
							    $video_id = $match[1];
								}
								?>
                <a href="<?php echo $get_ts_video[0];?>" target="_blank" >
	                <img src="http://img.youtube.com/vi/<?php echo $video_id; ?>/0.jpg" width="<?php echo $width_img;	 ?>" height="<?php echo $height_img; ?>" />
                </a>
                <?php 
							}else{
								echo $video_emb;
							}
							$get_img_size[][0]=(isset($get_img_p) && !empty($get_img_p))?$get_img_p:$img_th_video;// asigna la image a thumb							
						}else{
							if ($type!='twitter'){
							?>
             <img src="<?php echo $img_default;?>" width="<?php echo $width_img;	 ?>" height="<?php echo $height_img; ?>" />
              <?php
							$get_img_size[][0]=$img_default;// asigna la image a thumb							
							}
						}
					} 
				?>
          <div class="carousel-caption">
            <?php 
              if (isset($title) && $title=='yes'){
            ?>
            <h4><?php echo $title_sld;?></h4>
            <?php 
              }//$tilte,$date,$author,$text $title_font (h) txt_font(p)
            ?>
            <?php if(isset($author) && $author==='yes' ){?>
              <span class="ts_credits"><i class="icon-user"></i><?php  echo $author_sld;?></span>
            <?php } if(isset($date) && $date==='yes' ){ ?>
              <span class="ts_credits"><i class="icon-list-alt"></i><?php echo $time;  ?></span>
            <?php } ?>
            <p class="ts_txt">
            <?php 
              if(isset($text) && $text==='yes' ){
                echo $excerpt;
              }
             ?>
            </p>
          </div>
        </div>
      </div>
      <?php
					$counter++;
				}
				$content_carrousel=ob_get_clean();
	$data_arrow=($effect==='default')?'data-slide=':'data-rs=';		 
  ob_start(); 
?>    
	<div id='<?php echo $id_sld; ?>' class='ts-slider-area carousel-container <?php echo $class_pos; echo ' '.$classnr; ?>'>  
	  <div id="<?php echo $id_sld_in; ?>" class="carousel slide">
      <!-- Carousel items -->
      <div id="<?php echo $id_inner_carrousel; ?>" class="carousel-inner rs-slider">      
	      <?php echo $content_carrousel; ?>
      </div>
      <!-- Carousel nav -->
      <a class="carousel-custom" href="#<?php echo $id_sld_in; ?>" <?php echo $data_arrow;?>"prev">&lsaquo;</a>
      <a class="carousel-custom" href="#<?php echo $id_sld_in; ?>" <?php echo $data_arrow;?>"next">&rsaquo;</a>

	  </div>
	</div>
	<div class="ts_sld_clear"></div>  
<style>

<?php 
 if(isset($classnr)){?>
	div.<?php echo $classnr;?>{
		max-width:<?php echo $width_img;?>px	;
		max-height:<?php echo $height_img;?>px;
		width:<?php echo $width_img;?>px;
		height:<?php echo $height_img;?>px !important;
		padding:<?php echo $padding_ct ?>px;
	}
<?php 
 }
	?>
	#<?php echo $id_sld;?> .carousel-inner{
		position:relative !important;
/*		width:100% ;*/
	}
	<?php 
	if ($skin==='transparent'){
		$height_bd=bcmul(bcdiv($height_img,$height_img+2,5),100,2).'%';	
?> 
	div.rs-gridlet{
		margin-left:1px;
		margin-bottom:1px;
		margin-top:1px;
	}
	#<?php echo $id_sld; ?> .ts_border{
		border:1px solid #FFF;
		outline:1px solid #bbb;
		<?php 
		  echo $ts_margin_tr;
		?>
	}	
<?php
	}
?>
	#<?php echo $id_sld; ?> .rs-wrap{
		width:<?php  echo ($size[0]==='responsive')?$width_img:$width_img.'px';?> !important;
	}
	#<?php echo $id_sld; ?> .ts_border{
		overflow:hidden;
		max-height:<?php echo (isset($height_bd))?$height_bd:$height_img.'px'; ?> ;
		height:<?php echo (isset($height_bd))?$height_img-3:$height_img; ?>px;
	}
	#<?php echo $id_sld; ?> div.item,#<?php echo $id_sld; ?> li[class*="rs-slide-"]{
		background:<?php echo $background_sld; ?>;
	}
	#<?php echo $id_sld; ?> div.carousel-caption{
		background:<?php echo $background_txt; ?> !important;
		opacity:0.75;
	}	
	#<?php echo $id_sld; ?> div.carousel-caption{
		display:<?php echo (isset($title) && $title=='yes')||(isset($text) && $text==='yes' )?'block':'none'; ?>
	}
	#<?php echo $id_sld; ?> h4{
		font-family:<?php echo $title_font; ?>;
		font-size:<?php echo $title_size; ?>px;
		color:<?php echo '#'.$title_color; ?>;
		line-height: 1;
	}
	#<?php echo $id_sld; ?> .ts_credits{
		font-family:<?php echo $title_font; ?>;
		color:<?php echo '#'.$title_color; ?>;
	}
	#<?php echo $id_sld; ?> p{
		font-family:<?php echo $txt_font; ?>;
		font-size:<?php echo $txt_size; ?>px;
	}
	@media all and (max-width: 599px) and (min-width: 220px){
		div.ts_scr_left img,div.ts_scr_right img{
			max-width:none;
			height:60px;
			margin:0;
		}
		div.ts_scr_top img,div.ts_scr_bottom img{
			height:60px;
		}
		.item img{
			height:<?php echo $height_img.'px';?>;
			margin:0;
		}
	}		
	@media all and (max-width: 960px) and (min-width: 600px){
		div.ts_scr_top img,div.ts_scr_bottom img{
			height:60px;
		}			
		 div.ts_scr_left img,div.ts_scr_right img{
				max-width:none;
				height:60px;
				margin:0;
		}
		.item img{
			height:<?php echo $height_img.'px';?>;
			margin:0;
		}
	}
	.ts_img_right,.ts_img_left,.ts_scr_left,.ts_scr_right,.ts_th_bottom,.ts_th_top,.ts_th_left,.ts_th_right{
		max-height:<?php echo $height_img.'px';?> ;
		height:<?php echo $height_img.'px';?>;
	}
</style>
<?php 
	$content=ob_get_clean();//end of content
	ob_start();
?>
  <script>
	jQuery(document).ready(function(e) {
		 jQuery('#<?php echo $id_sld; ?>').tsSlider({
			 customizable: true
			, showText: true
			, autoplay:<?php echo $autoplay; ?>
			, imgWidth: <?php echo $img_w; ?>
			, imgHeight: <?php echo $img_h; ?>
			, squared: <?php echo (isset($squared)&&$squared==='yes')?'true':'false'; ?>
			, imgMarginTop: <?php echo $margin_top; ?>
			, imgMarginLeft:<?php echo $margin_left; ?>
			, textSquarePosition: <?php echo $sq_pos; ?>
			, textPosition: '<?php echo $txt_align ?>'
			, imgAlignment: '<?php echo $img_align ?>'
			/*, textBgColor: '<?php echo $txt_bk; ?>'*/
			, textColor: '<?php echo $txt_color; ?>'
			, textFrame:'<?php echo $frm_txt; ?>'
			, skin: 'ts-border-<?php echo $skin; ?>'
			, arrows:'ts-arrow-<?php echo $arrows; ?>'
			, titleBold: '<?php echo (isset($title_bold)&&$title_bold==='yes')?'true':'false'; ?>'
			, titleItalic: '<?php echo (isset($title_italic)&&$title_italic==='yes')?'true':'false'; ?>'
			, textBold: '<?php echo (isset($txt_bold)&&$txt_bold==='yes')?'true':'false'; ?>'
			, textItalic: '<?php echo (isset($txt_italic)&&$txt_italic==='yes')?'true':'false'; ?>'
			, textWidth: <?php echo $ts_txt_w;?>
			, sliderHeight: <?php echo $height_img; ?>
			, effects:'<?php echo ($effect==='default')?'':$effect;?>'
		 });
		 <?php 
		 if ($effect==='default'){
		?>		 
		jQuery('#<?php echo $id_scr;?> a').click(function(q){
			q.preventDefault();
			targetSlide = jQuery(this).attr('data-to')-1;
			jQuery('#<?php echo $id_sld_in; ?>').carousel(targetSlide);
			jQuery(this).addClass('active').siblings().removeClass('active');
		});
		<?php 
		 }
		?>		
  });
	</script>  
  <?php
	$script_ts.=ob_get_clean();
	add_action('wp_print_footer_scripts', 'ts_script_execute', 20);  
	return $content;
}
function ts_using_ie(){
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = false;
    if(preg_match('/MSIE/i',$u_agent)){
        $ub = true;
    }
    return $ub;
} 
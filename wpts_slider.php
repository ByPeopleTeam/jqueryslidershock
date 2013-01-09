<?php
/*
	Plugin Name: Ts slider by Themeshock and Themegenerator (Free Version)
	Plugin URI: http://www.jqueryslidershock.com
	Description: Slider plugin by Themeshock and Themegenerator
	Version: 1.0
	Author: Theme Shock
	Author URI: http://www.themeshock.com
*/
add_action('admin_menu', 'ts_make_slider_menu',9);

function ts_make_slider_menu() {
		define("TS_SLIDER_PERMISSIONS", "administrator");
		$na_plu_can='Slidershock plugin by Themeshock and Themegenerator (Free version)';//name plugin canonical
		add_menu_page(
			__($na_plu_can),
			__($na_plu_can), 
			TS_SLIDER_PERMISSIONS,
			 'slidershock', 
			 'ts_make_slider_config',
			 plugins_url('/img/ts1.png', __FILE__)
		);
		add_submenu_page(
			'slidershock',
			__('Get shortcode'),
			__('Get shortcode'),
			TS_SLIDER_PERMISSIONS,
			'slidershock',
			'ts_make_slider_config'
		);
}

add_action('init', 'ilc_farbtastic_script');
	function ilc_farbtastic_script() {
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );
	}
	function slide_options(){
		global $post;
		$get_ts_video=get_post_meta($post->ID,'ts_video');
?>
	<div id="gallery-options">
    <label>Place youtube video:</label>
    <input type="text" name="ts_video" value="<?php echo (count($get_ts_video))>0?$get_ts_video[0]:'';?>" size="100%" />
  </div>
<?php
	}
	add_action('save_post', 'update_ts_youtube');	
	function update_ts_youtube(){
		global $post;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;		
		update_post_meta($post->ID, 'ts_video', $_POST["ts_video"]);		
	}
	

function ts_make_slider_config(){
?>
<?php
	wp_enqueue_style('ts_config',plugin_dir_url(__FILE__)."css/ts_config.css");
?>
<!--<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/ts_config.css" media="all" type="text/css" />-->
<script>
var ddData_bk = [
<?php 						
	foreach(glob(dirname( __FILE__ ).'/img/sld/*.jpg') as $index => $tx_file){
	$url_file=plugin_dir_url(__FILE__).'img/sld/'.basename($tx_file);?>
	{
		text: "<?php echo basename($tx_file,'.jpg'); ?>",
		value: "<?php echo $url_file; ?>",
		description: "Pattern",
		imageSrc: "<?php echo $url_file; ?>"
	},
<?php 
	}
?>
	{
		text: "Transparent",
		value: "transparent",
		description: "transparent",
		imageSrc: "<?php echo plugin_dir_url(__FILE__).'img/thumb_transparent.jpg'; ?>"
	}
];

var ddData_frm_txt = [
<?php
	$file_skin=glob(dirname( __FILE__ ).'/img/frmtxt/*.jpg');
	natsort($file_skin);	
	foreach($file_skin as $index => $tx_file){
	$url_file=plugin_dir_url(__FILE__).'img/frmtxt/'.basename($tx_file);
	?>
		{
			text: "<?php echo 'text frame '.basename($tx_file,'.jpg'); ?>",
			value: "<?php echo basename($tx_file,'.jpg'); ?>",
			description: "Text frame",
			imageSrc: "<?php echo $url_file; ?>"
		},
<?php 
	}
?>
		{
			text: "Transparent",
			value: "transparent",
			description: "transparent",
			imageSrc: "<?php echo plugin_dir_url(__FILE__).'img/thumb_transparent.jpg'; ?>"
		}
	];	
</script>
<?php
	wp_enqueue_script('ts_config',plugin_dir_url(__FILE__)."js/ts_config.js");
	wp_enqueue_script('ddslick',plugin_dir_url(__FILE__)."js/ddslick.js");
?>

<!--<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__); ?>js/ts_config.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__); ?>js/ddslick.js"></script>-->

<div class="wrap ts_main_config">
  <div id="icon-edit" class="icon32"></div>
  <h2>Slidershock plugin by themeshock</h2> 
	<div class="postbox">
		<h3><span>Generate slider</span></h3>
    <div class="alert alert-block">
		   <p class="sld_notice_premium"> 
       	In order to use the full functionality including external datasources (rss, youtube, flickr, instagram etc), taxonomies, custom post types, 31+ effects, responsiveness, 31+ skins and more you need the <a href="http://www.jqueryslidershock.com/">premium wordpress slidershock</a>
       </p>
       <ul class="ts_sld_ban">
	       <li>
            <h3>
              <span>Several slides sources, even external <span style="color: #F32914">( Premium )</span></span>
            </h3>
            <p>
            		You can create an slider from each of the following sources: Custom Slides, Posts (WordPress), 
                Custom Post Types (WP), Taxonomies (WP), External RSS, YouTube, Flickr, Twitter and Instagram.
            </p>
	        </li>
          <li>
        	<h3>
            <span>Fully responsive, mobile ready &nbsp;</span>
            <span style="color: #F32914; display:">( Premium )</span></h3>
            <p>Since the slider is fully responsive, you won't need to worry about your slider stop working on small screen devices.</p>
	        </li>
					<li>
            <h3>
              <span> Several transition effects &nbsp;&nbsp; <span style="color: #F32914;">( Premium ) </span></span>
            </h3>
            <p>Pick one from 31 available effects or let them be random.</p>
	        </li>
					<li>
            <h3>
              <span>Select a skin for your slider <span style="color: #F32914;">( Premium ) </span></span>
            </h3>
              <p>You choose the skin that fits on your site the best from 39 skins. </p>
	        </li>
          <li class="button_buy">
       	  	<a class="btn btn-large btn-success" href="http://www.jqueryslidershock.com/">Check the full version</a>
          </li>
       </ul>
       <a href="#" class="hide_notification">Hide</a>
		</div>
    <form id="ts_sld_sht">


    	<div class="options-sidebar">
    		<div class="block-option">
    			<h2>Texture Bg</h2>
    			<div>
				<input type="radio" name="ts_bg" value="#000" id="ts_bg"  />             
				<div id="ts_opt_image" class="ts_block"></div>
				<div class="ts_block ">
					<input type="radio" name="ts_bg" value="#000" id="ts_colorpick"   /> 
					<label for="color"><input type="text" id="ts_color_4" name="color" value="#ffffff" />Pick link color</label>
					<div id="ts_ilctabscolorpicker_4"></div>
				</div>

            	</div>
    		</div>

    		<div class="block-option">
    			<span class="title-opt-item">
    				<label>Autoplay (ms)</label>
    			</span>
    			<div class="inputs-group">
    				<input type="number" name="ts_autoplay" class="small-text" step="1000" min="0" max="20000" value="5000"/>
            	</div>
    		</div>


			<div class="block-option">
    			<span class="title-opt-item">
    				<label>img width (%)</label>
    			</span>
    			<div class="inputs-group">
    				<input type="number" name="ts_img_w" class="small-text" step="1" min="1" max="100" value="100"/>
            	</div>
    		</div>

			<div class="block-option">
    			<span class="title-opt-item">
    				<label>img height (%)</label>
    			</span>
    			<div class="inputs-group">
    				<input type="number" name="ts_img_h" class="small-text" step="1" min="1" max="100" value="100"/>
            	</div>
    		</div>


			<div class="block-option">
    			<span class="title-opt-item">
    				<label>Text width (%)</label>
    			</span>
    			<div class="inputs-group">
    				<input type="number" name="txt_width" class="small-text" step="1" min="1" max="100" value="30"/>
            	</div>
    		</div>


			<div class="block-option">
				<span class="title-opt-item">
					<label>Margin Top Img (px)</label>
				</span>
				<div class="inputs-group">
			      	<input type="number" name="ts_imgm_t" class="small-text" step="1" min="-999" max="999" value="0"/>
				</div>
			</div>

			<div class="block-option">
				<span class="title-opt-item">
					<label>Margin Left Img (px)</label>
				</span>
				<div class="inputs-group">
			      	<input type="number" name="ts_imgm_l" class="small-text" step="1" min="-999" max="999" value="0"/>
				</div>
			</div>

			<div class="block-option">
    			<span class="title-opt-item">
    				<label>squared</label>
    			</span>
    			<div class="inputs-group">
    				<input type="checkbox" name="ts_squared" value="yes"  />
            	</div>
    		</div>

    		<div class="block-option">
    			<span class="title-opt-item">
    				<label>textSquarePosition</label>
    			</span>
    			<div class="inputs-group">
    				<?php 
						$squared_pos=array('Top-left'=>1,'Top-right'=>2,'Bottom-right'=>3,'Bottom-left'=>4,'Center'=>5)
					?>
					 <select name="ts_squared_pos">
					<?php 
		            	foreach ($squared_pos as $sq_position => $value){
		            ?>
		            	<option value="<?php echo $value; ?>"><?php echo $sq_position; ?></option>
		            <?php
		            	}
		            ?>
		              </select>
            	</div>
    		</div>


    		<div class="block-option">
 			<?php $array_sel_opt=array('title'=>true,'date'=>false,'author'=>false,'text'=>true);//option selecionables
				foreach($array_sel_opt as $title => $cheched){?>
			
    			
    				<label><?php echo ucfirst($title);?></label>
    			
    			
    				<input type="checkbox" name="ts_<?php echo $title; ?>" value="yes" <?php echo $cheched===true?'checked="checked"':'';?> />
            	
    		<?php } ?>
    		</div>

    		<div class="block-option">
    			<span class="display-block">Text aligment</span>
    			<div>
    				<?php 
						$thumbs_array=array('top','bottom','left','right','center');
						foreach($thumbs_array as $index => $thumbnail_position){
					?>
					<input type="radio" name="ts_txt_align" value="<?php echo $thumbnail_position;?>" <?php echo ($index===0)?'checked="checked"':''; ?> /> <?php echo $thumbnail_position; ?>&nbsp;&nbsp;
					<?php
               			}
					?>

            	</div>
    		</div>

			<div class="block-option">
    			<span class="display-block">Img aligment</span>
    			<div>
    				<?php
    					$thumbs_array=array('left','right','center');
						foreach($thumbs_array as $index => $thumbnail_position){
					?>
						<input type="radio" name="ts_img_align" value="<?php echo $thumbnail_position;?>" <?php echo ($index===0)?'checked="checked"':''; ?> /> <?php echo $thumbnail_position; ?>&nbsp;&nbsp;
					<?php
						} 
					?>
            	</div>
    		</div>

    	</div><!-- options-sidebar -->
		<div class="options-sidebar">
    	
			<div class="block-option">
				<h2>Text background color</h2>
    			<div>
    				<input type="radio" name="ts_txt_bk_color" id="ts_txt_bg"  />
					<div id="ts_txt_bk" class="ts_block"></div>
		            <div class="ts_block">
		            	<input type="radio" name="ts_txt_bk_color"  id="ts_txt_colorpick"   />
		                <label for="color"><input type="text" id="ts_color_1" name="ts_color_1" value="#000000" /> Pick link color</label>
		                <div id="ts_ilctabscolorpicker_1"></div>
		            </div>
            	</div>
    		</div>


			<div class="block-option">
				<h2>Title</h2>
    			<div>
					<div class="ts_block">
			            <h4> Select color</h4>
		                <label for="color"><input type="text" id="ts_color_3" name="ts_title_color" value="#000000" /> </label>
		                <br />
		                <span>Pick link color</span>
						<div id="ts_ilctabscolorpicker_3"></div>
					</div>
					<div class="ts_block">
		              	<h4> Select font</h4>              
							<?php $fonts=array(
								"Default"=>"inherit"
								,"Arial"=>"Arial"
								,"Verdana"=>"Verdana"
								,"Trebuchet"=>"Trebuchet MS"
								,"Tahoma"=>"Tahoma"
								,"Calibri"=>"Calibri"
								,"Helvetica"=>"Helvetica"
								,"Lucida Console"=>"Lucida Console"
								,"Alfa"=>"Alfa Slab One"
								,"Alice"=>"Alice"
								,"Allan"=>"Allan"
								,"Amaranth"=>"Amaranth"
								,"Anonymous"=>"Anonymous Pro"
								,"Baumans"=>"Baumans"
								,"Boogaloo"=>"Boogaloo"
								,"Buda"=>"Buda"
								,"Coustard"=>"Coustard"
								,"Crushed"=>"Crushed"
								,"Cuprum"=>"Cuprum"
								,"Damion"=>"Damion"
								,"Federo"=>"Federo"
								,"Gruppo"=>"Gruppo"
								,"Josefin"=>"Josefin Slab"
								,"Just Another Hand"=>"Just Another Hand"
								,"Lobster"=>"Lobster Two"
								,"Maiden"=>"Maiden Orange"
								,"Nobile"=>"Nobile"
								,"Philosopher"=>"Philosopher"
								,"Raleway"=>"Raleway"
								,"Wire"=>"Wire One"
								,"Yanone"=>"Yanone Kaffeesatz"
								);
							?>
						<select name="ts_title_font">
							<?php foreach ($fonts as $font =>$font_family ){ ?>
						    <option value="<?php echo $font_family; ?>"><?php echo $font; ?></option>
							<?php } ?>
						</select>
	            	</div>
					<div class="ts_block">
						<h4> Select font size</h4>
						<input name="ts_title_size" type="number" step="1" max="72" min="7" value="20" />
					</div>
					<div class="ts_block">
						<h4> Bold</h4>
							<input type="checkbox" name="ts_title_bold" value="yes" />
					</div>
					<div class="ts_block">
					    <h4> Italic</h4>
						<input type="checkbox" name="ts_title_italic" value="yes" />
					</div>

            	</div>
    		</div>

			<div class="block-option">
				<h2>Text</h2>
				<div>

					<div class="ts_block">
						<h4> Select color</h4>
						<label for="color"><input type="text" id="ts_color_2" name="ts_txt_color" value="#ffffff" /> <br />Pick link color</label>
						<div id="ts_ilctabscolorpicker_2"></div>
					</div>
					<div class="ts_block">
						<h4> Select font</h4>              
					<select name="ts_txt_font">
						<?php foreach ($fonts as $font =>$font_family ){ ?>
							<option value="<?php echo $font_family; ?>"><?php echo $font; ?></option>
						<?php }	?>
					</select>
					</div>
					<div class="ts_block">
						<h4> Select font size</h4>
						<input name="ts_txt_fontsize" type="number" step="1" max="72" min="7" value="12" />
					</div>
					<div class="ts_block">
						<h4> Bold</h4>
						<input type="checkbox" name="ts_txt_bold" value="yes" />
					</div>
					<div class="ts_block">
						<h4> Italic</h4>
						<input type="checkbox" name="ts_txt_italic" value="yes" />
					</div>

				</div>
			</div>


		</div><!-- options-sidebar -->
		<div class="options-sidebar">

			<div class="block-option">
				<span class="title-opt-item">
					<label>Number Slices</label>
				</span>
				<div class="inputs-group">
				<select name="sld_number">
				<?php foreach (range(2,15) as $number){ ?>
				  <option><?php echo $number; ?></option>
				  <?php } ?>
				</select>
				</div>
			</div>

			<div class="block-option">
				<span class="display-block">Size</span>
				<div><input type="radio" name="ts_slide_size" value="responsive" checked="checked" /><span>Responsive design 100%</span></div>
				<span class="title-opt-item">
					<label>Height </label>
				</span>
				<div class="inputs-group">
					<input type="number" name="ts_res_size_h" class="small-text" step="1" min="300" value="400"/>
				</div>
				<div>
					<br />        
					<input type="radio" name="ts_slide_size" value="fixed"  /><span>Fixed to size</span>
				</div>
        <br />
				<span class="title-opt-item">
					<label>Width </label>
				</span>
				<div class="inputs-group">
					<input type="number" name="ts_size_w" class="small-text" step="1" min="300" value="300"/>
				</div>
				<span class="title-opt-item">
					<label>Height </label>
				</span>
				<div class="inputs-group">
					<input type="number" name="ts_size_h" class="small-text" step="1" min="300" value="300"/>

				</div>
			</div>
			<div class="block-option">
				<span class="title-opt-item">
					<label>Effects</label>
				</span>
				<div class="inputs-group">
					<?php $effects_array=array('default','random', 'cubeH', 'cubeV', 'fade', 'sliceH', 'sliceV', 'slideH', 'slideV', 'scale'); ?>
            		<select name="ts_effects_sld">
					<?php foreach ($effects_array as $sq_position => $value){ ?>
						<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php } ?>
            		</select>
				</div>
			</div>
    	</div><!-- options-sidebar -->




      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row"></th>
            <td>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"></th>
            <td>
	            
            </td>
          </tr> 
          <tr valign="top">
            <th scope="row"></th>
            <td>
	            
            </td>
          </tr>           
          <tr valign="top">
            <th scope="row">Your shortcode is </th>
            <td>
              <textarea name="ts_generate_shortcode" rows="10" cols="50"  class="large-text code" readonly="readonly" >[ts_sldshock autoplay="5000" img_w="100" img_h="100" ts_txt_w="200" margin_top="0" margin_left="0" title="yes" Text="yes" txt_align="top" img_align="top" txt_bk="0 0 0" txt_color="ffffff" frm_txt="000000"  sld_number="2" title_font="inherit" title_size="20" title_color="000000" txt_font="inherit" txt_size="12"  size="responsive-400"  ]</textarea>
            </td>
          </tr>
        </tbody>
      </table>
		</form>
	</div>
</div>
<?php
}
function ts_make_slider($atts=array()){
	global $post;
	static $call;
	++$call;
	$atts_default=array(
		'type' => 'category',
		'value'=>'0',
		'autoplay'=>'5000',
		'background_item'=>'transparent',		
		'img_w'=>'100',
		'img_h'=>'100',
		'ts_txt_w'=>'200',
		'margin_top'=>'0',
		'margin_left'=>'0',
		'squared'=>false,
		'sq_pos'=>'1',
		'title'=>'yes',
		'date'=>false,
		'author'=>false,
		'text'=>'yes',
		'txt_align'=>'top',
		'img_align'=>'left',
		'txt_bk'=>'transparent',
		'title_color'=>"000000",
		'title_font'=>"inherit",
		'title_size'=>"20",
		'title_bold'=> false,
		'title_italic'=> false,
		'txt_bold'=> false,
		'txt_italic'=> false,
		'txt_color'=>"ffffff",
		'txt_font'=>"inherit",
		'txt_size'=>"12",
		'frm_txt'=>"",
		'skin'=>'transparent',
		'arrows'=>'1',
		'sld_number' => '2',
		'size' => 'responsive-400',
		'thumbs'=>'none',
		'effect'=>'default'
	);
	extract(shortcode_atts($atts_default, $atts )); 

	$args_post = array(
	 'numberposts' => $sld_number,
	 'orderby' => 'ASC',
	 'category' => '',
	 'post_status' => 'publish',
	 'category'=>$value
	);	//set post
	if ($call===1){
		include ('wpts_slider_template.php');
	}
	switch ($type){// assign the loop
		case 'category':	
			$qposts=get_posts($args_post);
			$content=ts_make_slider_html($qposts,compact(array_keys($atts_default)));	
		break;	
	}
	
	return $content;
}
add_shortcode("ts_sldshock", "ts_make_slider");
?>
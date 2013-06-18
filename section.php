<?php
/*
Section: Scroll Header Pro
Author: .bestrag
Author URI: bestrag.net
Version: 1.1
Description: NOW WITH PARALLAX. Create a one-page site in a breeze: insert fully customizable Scrolling-ready headings between sections, add scroll menu, stylize and done. Fits on any screen.
Class Name: LUDHeader
Workswith: main, templates
Cloning: true
Demo: http://bestrag.net/scroll-header-pro
*/

class LUDHeader extends PageLinesSection {

	function section_styles(){
		wp_enqueue_script('scrollheader', $this->base_url.'/jquery.scrollheader.min.js', array( 'jquery' ),'1.1', true);
	}
	function section_head($clone_id ){

		$clone = ($clone_id) ? '#scroll-header-pro.clone_'.$clone_id: '#scroll-header-pro.clone_1' ;
		$sh_bckground_img = (ploption('sh_bckground_img', $this->oset)) ? 'url('.(ploption('sh_bckground_img', $this->oset) ).')' : "";
		$sh_fit = (ploption('sh_fit', $this->oset)) ? 'true' : null;
		$sh_fit_size = (ploption('sh_fit_size', $this->oset)) ? ploption('sh_fit_size', $this->oset) : .7 ;
		$sh_minfontsize = (ploption('sh_minfontsize', $this->oset)) ? (ploption('sh_minfontsize', $this->oset)) : '1px';
		$sh_maxfontsize = (ploption('sh_maxfontsize', $this->oset)) ? (ploption('sh_maxfontsize', $this->oset)) : '999px';
		$sh_lettering = ( ploption('sh_lettering', $this->oset) ) ? 'true' : null;
		$sh_lselector = '#shID'.$clone_id;
		$sh_method = (ploption('sh_method', $this->oset)) ? (ploption('sh_method', $this->oset)) : null;
		//new from ver 1.2
		$sh_parallax = (ploption('sh_use_parallax', $this->oset)) ? 'true' : null;
		$sh_parallax_speed = (ploption('sh_parallax_speed', $this->oset)) ? (ploption('sh_parallax_speed', $this->oset)) : "0.5";
		$sh_height = (ploption('sh_height', $this->oset)) ? ploption('sh_height', $this->oset) : '';
		if(is_numeric($sh_height)) $sh_height .= 'px';
		$sh_padding_top = (ploption('sh_padding_top', $this->oset)) ? ploption('sh_padding_top', $this->oset) : '';
		if(is_numeric($sh_padding_top)) $sh_padding_top .= 'px';
		$sh_padding_bottom = (ploption('sh_padding_bottom', $this->oset)) ? ploption('sh_padding_bottom', $this->oset) : '';
		if(is_numeric($sh_padding_bottom)) $sh_padding_bottom .= 'px';
		$sh_text_align = (ploption('sh_text_align', $this->oset)) ? ploption('sh_text_align', $this->oset) : '';
		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					sectionClone = jQuery('<?php echo $clone; ?>');
					headingID = jQuery('<?php echo $sh_lselector; ?>', sectionClone);
					height = '<?php echo $sh_height; ?>';
					paddingTop = '<?php echo $sh_padding_top; ?>';
					paddingBottom = '<?php echo $sh_padding_bottom; ?>';
					textAlign = '<?php echo $sh_text_align; ?>';
					image = '<?php echo $sh_bckground_img; ?>';
					speed = <?php echo $sh_parallax_speed; ?>;
					sectionClone.css({
						'padding-top' : paddingTop,
						'padding-bottom' : paddingBottom,
						'height': height,
						'background-image' : image
					});
					headingID.css('text-align', textAlign);
					if('<?php echo $sh_parallax; ?>'){
						sectionClone.attr("data-stellar-background-ratio", speed);
					}
					if('<?php echo $sh_fit; ?>'){
						jQuery('<?php echo $clone;?> .sh-heading').fitText(
							"<?php echo $sh_fit_size; ?>",
						{
							minFontSize: '<?php echo $sh_minfontsize; ?>',
					 		maxFontSize: '<?php echo $sh_maxfontsize; ?>'
						});
					}
					if('<?php echo $sh_lettering; ?>'){
						console.log('lettering');
						if('<?php echo $sh_method;?>' === 'wl'){
							headingID.lettering('words').children('span').lettering();
							console.log('wl');
						}
						else{
							headingID.lettering('<?php echo $sh_method; ?>');
							console.log('else');
						}
					}

				});
			</script>
			<?php
		//Font
		if (ploption('sh_font', $this->oset)) {
			echo load_custom_font( ploption('sh_font', $this->oset), "#shID$clone_id");
		}
	}

	function section_template( $clone_id ) {
		$sh_heading_tag = ( in_array( ploption('sh_heading_tag', $this->oset), array('1','2','3','4','5','6'))) ? ploption('sh_heading_tag', $this->oset) : 2 ;
		$sh_title = ( ploption('sh_title', $this->oset) ) ? ploption('sh_title', $this->oset) : NULL;
		$sh_header = ( ploption('sh_header', $this->oset) ) ? ploption('sh_header', $this->oset) : NULL;
		$sh_header_small = ( ploption('sh_header_small', $this->oset) ) ? '<small>&nbsp;'.ploption('sh_header_small', $this->oset).'</small>' : NULL;
		$sh_class = ( ploption('sh_class', $this->oset) ) ? ploption('sh_class', $this->oset) : 'page-header' ;
		$sh_scrollspy = ( ploption('sh_use_scrollspy', $this->oset) ) ? NULL : 'scroll-header' ;
		$sh_heading_id = 'shID'.$clone_id;

		$format='<div class="%s %s sh-container" title="%s"><h%d class="sh-heading" id="%s">%s%s</h%d></div>';
		printf($format, $sh_class, $sh_scrollspy, $sh_title, $sh_heading_tag, $sh_heading_id, $sh_header, $sh_header_small, $sh_heading_tag);
	}

	function section_optionator($settings){
		$settings = wp_parse_args($settings, $this->optionator_default);

		$opts = array();
		$opts['sh_settings'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Main options', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Title</strong>	-	Title tag that is displayed in scroll navbar.<br />
					<strong>Heading</strong>	-	Heading text (shown on page).<br />
					<strong>Heading small</strong>	-	Subheading text (shown inline after heading).<br />
					<strong>TIP:</strong> If using FitText or Lettering.js, leave Heading Small empty.<br />
					<strong>Heading HTML Tag</strong>	-	Choose from H1 -  H6 (Default H2).<br />
					<strong>Disable Scroll Menu Integration</strong>	-	Check this option if you do not want SHP to show on scroll menu (ScrollSpy, Scroll Nav or other).', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_title' => array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Title tag (required for using with Scroll Menus)', 'pagelines' ),
					),
					'sh_header' 	=> array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Heading', 'pagelines' ),
					),
					'sh_header_small' => array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Subheading', 'pagelines' ),
					),
					'sh_heading_tag'	=> array(
						'type' 			=> 'select',
						'default' 		=> 2,
						'inputlabel' 	=> __( 'Heading HTML Tag', 'pagelines' ),
						'selectvalues' => array(
							'1'	=> array('name' => __( 'H1', 'pagelines') ),
							'2'	=> array('name' => __( 'H2 (Default)', 'pagelines') ),
							'3'	=> array('name' => __( 'H3', 'pagelines') ),
							'4'	=> array('name' => __( 'H4', 'pagelines') ),
							'5'	=> array('name' => __( 'H5', 'pagelines') ),
							'6'	=> array('name' => __( 'H6', 'pagelines') )
						)
					),
					'sh_use_scrollspy' => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Disable Scroll Menu integration', 'pagelines' ),
					)
				)
		);
		$opts['sh_style'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Style Options', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Font</strong>	-	Choose Heading font.<br />
					<strong>Text Align</strong>	-	Choose left, right or center align of the heading.<br />
					<strong>Custom Heading class</strong>	-	Replace default container class (page-header) with your custom class. If you want to use .page-header AND custom class, just type: "page-header your_custom_class" (separated by space).<br />
					<strong>Background Image</strong>	-	Choose background image for SHP section.', 'pagelines' ),
				'layout'		=> 'interface',
				'selectvalues'	=> array(
					'sh_font' => array(
						'type' 			=> 'fonts',
						'inputlabel'	=> __( 'Choose Heading font', 'pagelines' ),
					),
					'sh_text_align' =>array(
						'type' 			=> 'select',
						'default' 		=> 2,
						'inputlabel' 	=> __( 'Text Align', 'pagelines' ),
						'selectvalues' => array(
							'left'	=> array('name' => __( 'Left (Default)', 'pagelines') ),
							'right'	=> array('name' => __( 'Right', 'pagelines') ),
							'çenter'	=> array('name' => __( 'Center', 'pagelines') )
						)
					),
					'sh_class' => array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Custom Heading class (default page-header)', 'pagelines' ),
					),
					'sh_bckground_img'=> array(
						'inputlabel' 	=> __( 'Background Image', 'pagelines' ),
						'type'			=> 'image_upload'
					)
				)
		);
		$opts['sh_layout'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Layout Options', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Section Height</strong>	-	set the height of the entire section (eg. 150px, 30%, 5em)<br />
					<strong>Padding Top and Bottom</strong>	-	Set vertical position of the heading inside the section.<br />', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_height' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Section Height (in px, %, em).', 'pagelines' ),
					),
					'sh_padding_top' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Section Padding - Top (in px, %, em).', 'pagelines' ),
					),
					'sh_padding_bottom' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Section Padding - Bottom (in px, %, em).', 'pagelines' ),
					)
				)
		);
		$opts['sh_parallax_set'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Parallax Header', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Enable Parallax</strong> to apply parallax effect on section background. <br>
					<strong>Scroll Speed</strong>	-	Use this option to set relative sped of the section background. Accepts positive values. Default is 0.5 (50% of text scroll speed).<br />
					<strong>HEADS UP</strong> You need to upload your background image.<br />', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_use_parallax'   => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Enable Parallax', 'pagelines' ),
					),
					'sh_parallax_speed' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Scroll Speed (default 0.5)', 'pagelines' ),
					)
				)
		);
		$opts['sh_fit_text'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'FitText Header', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>FitText</strong> - These options can help you to create big, responsive headings.<br>
				              <strong>Use FitText</strong>	-	Use FitText on page. Default false.<br />
				              <strong>FitText Ratio</strong>	-	For tweaking resizing. 1 - normal, 0.x - less aggressively, 1.x is more aggressively. Default is set to (0.7).<br />
				              <strong>Minfontsize and Maxfontsize</strong>	-	set the minimum and maximum font size in pixels. Great for preserving hierarchy of headings on different screen resolutions.<br />
				              more information <a href="https://github.com/davatron5000/FitText.js" target="_blank">here</a>', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_fit' => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Use FitText', 'pagelines' ),
					),
					'sh_fit_size' => array(
						'type' 			=> 'text_small',
						'default'		=> .7,
						'inputlabel'	=> __( 'FitText Ratio (default 0.7)', 'pagelines' ),
					),
					'sh_minfontsize' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Minimum Font Size (px)', 'pagelines' ),
					),
					'sh_maxfontsize' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Maximum Font Size (px)', 'pagelines' ),
					)
				)
		);
		$opts['sh_lettering_settings'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Lettering.js Header', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Lettering.js</strong> - jQuery plugin that wraps span element around every line, word or letter of your heading.<br><br><strong>Use Lettering.js</strong>	-	Whether to use Lettering.js on page. Default false.<br /><strong>Letering.js method</strong>	-	Choose what should be wrapped in span (default Letters).<br />For more information on how to use this option, go to <a href="http://http://bestrag.net/scroll-header-pro/" target="_blank">demo page</a><br>For more information on Lettering.js click <a href="http://letteringjs.com/" target="_blank">here</a>', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_lettering' => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Use Lettering.js', 'pagelines' ),
					),
					'sh_method' => array(
						'type' 			=> 'select',
						'default' 		=> 'letters',
						'inputlabel' 	=> __( 'Letering.js method (default Letters) ', 'pagelines' ),
						'selectvalues' => array(
							'letters'	=> array('name' => __( 'Letters (Default)', 'pagelines') ),
							'words'	=> array('name' => __( 'Words', 'pagelines') ),
							'lines'	=> array('name' => __( 'Lines', 'pagelines') ),
							'wl'	=> array('name' => __( 'Words/letters', 'pagelines') ),
						)
					)
				)
		);
		//Show "Title" from section metatab options as tab name
		global $post_ID;
		$oset = array('post_id' => $post_ID, 'clone_id' => $settings['clone_id'], 'type' => $settings['type']);
		$sh_name = (ploption('sh_title', $oset)) ? ploption('sh_title', $oset) : $this -> name;

		$tab_settings = array(
			'id' 		=> $this->id,
			'name' 		=> $sh_name,
			'icon' 		=> $this->icon,
			'clone_id'	=> $settings['clone_id'],
			'active'	=> $settings['active']
		);
		register_metatab($tab_settings, $opts);
	}

	function section_persistent(){

		//new less file
		add_action( 'template_redirect',array(&$this, 'scroll_header_pro_less') );

		//Scroll Spy shortcode
		function scrollspy_open($atts, $content = null) {
			extract(shortcode_atts(array('class' => 'page-header', 'title' => '', 'h_tag' => '2' ), $atts));
			$return = '<div class="'.$class.' scroll-header sh-container"';
			if (!empty($title)) $return .= ' title="'.$title.'"';
			$h_temp = (in_array($h_tag, array('1','2','3','4','5','6'))) ? $h_tag : '2';
			$return .= '><h'.$h_temp.' class="zmb sh-heading">';
			return $return.do_shortcode($content).'</h'.$h_temp.'></div>';
		}
		add_shortcode('scrollspy', 'scrollspy_open');

		function small_header($atts, $content = null) {
			return '&nbsp;<small>' . $content . '</small>';
		}
		add_shortcode('small', 'small_header');
	}
	function scroll_header_pro_less() {
		$file = sprintf('%s/data.less', $this->base_dir);
  		pagelines_insert_core_less( $file );
	}
}
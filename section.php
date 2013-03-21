<?php
/*
Section: Scroll Header Pro
Author: .bestrag
Author URI: http://bestrag.wordpress.com/
Version: 1.0.0
Description: Create a one-page site in a breeze. This section allows you to create beautiful ScrollSpy-ready headings anywhere on the page. Works with Lettering and FitText. Also included: ScrollSpy CSS fix and shortcode for content.
Class Name: LUDHeader
Workswith: main, templates
Cloning: true
Demo: http://demo.trampanet.net/scroll-header-pro
*/

class LUDHeader extends PageLinesSection {

	function section_styles(){
		wp_enqueue_script('scrollheader', $this->base_url.'/jquery.scrollheader.min.js', array( 'jquery' ));
	}

	function section_head($clone_id ){
		//Font
		if (ploption('sh_font', $this->oset)) {
			echo load_custom_font( ploption('sh_font', $this->oset), "#shID$clone_id");
		}
		//FitText		
		if (ploption('sh_fit', $this->oset)) {
			$sh_fit_size = (ploption('sh_fit_size', $this->oset)) ? ploption('sh_fit_size', $this->oset) : .7 ;
			$selector = ($clone_id) ? '.clone_'.$clone_id : '.no_clone';
			$sh_minfontsize = (ploption('sh_minfontsize', $this->oset)) ? (ploption('sh_minfontsize', $this->oset)) : '1px';
			$sh_maxfontsize = (ploption('sh_maxfontsize', $this->oset)) ? (ploption('sh_maxfontsize', $this->oset)) : '999px';
			?>			
			<script type="text/javascript">
				jQuery(document).ready(function(){ 
					jQuery('<?php echo $selector;?> .sh-fittext').fitText(
						"<?php echo $sh_fit_size; ?>",
						{
							minFontSize: '<?php echo $sh_minfontsize; ?>',
					 		maxFontSize: '<?php echo $sh_maxfontsize; ?>'
					 	});
				});
			</script>
			<?php 
		}
		//Lettering.js
		$sh_lettering = ( ploption('sh_lettering', $this->oset) ) ? true : false ;
		if ($sh_lettering) {
			$sh_lselector = '#shID'.$clone_id;
			$sh_method = (ploption('sh_method', $this->oset)) ? (ploption('sh_method', $this->oset)) : null;
			if ($sh_method == 'wl') {
				?>			
				<script type="text/javascript">
					jQuery(document).ready(function(){ 
						jQuery('<?php echo $sh_lselector; ?>').lettering('words').children('span').lettering();
					});
				</script>
				<?php	
			}
			else {
				?>			
				<script type="text/javascript">
					jQuery(document).ready(function(){ 
						jQuery('<?php echo $sh_lselector; ?>').lettering('<?php echo $sh_method; ?>');
					});
				</script>
				<?php
			}
		}
	}
	
	function section_template( $clone_id ) {
		$sh_heading_tag = ( in_array( ploption('sh_heading_tag', $this->oset), array('1','2','3','4','5','6'))) ? ploption('sh_heading_tag', $this->oset) : 2 ;
		$sh_title = ( ploption('sh_title', $this->oset) ) ? ploption('sh_title', $this->oset) : NULL;
		$sh_header = ( ploption('sh_header', $this->oset) ) ? ploption('sh_header', $this->oset) : NULL;
		$sh_header_small = ( ploption('sh_header_small', $this->oset) ) ? '<small>&nbsp;'.ploption('sh_header_small', $this->oset).'</small>' : NULL;
		$sh_class = ( ploption('sh_class', $this->oset) ) ? ploption('sh_class', $this->oset) : 'page-header' ;
		$sh_hide_header = ( ploption('sh_hide_header', $this->oset) ) ? true : false ;
		$sh_fit = 	( ploption('sh_fit', $this->oset) ) ? 'sh-fittext' : NULL ;
		$sh_scrollspy = ( ploption('sh_use_scrollspy', $this->oset) ) ? NULL : 'scroll-header' ;
		$sh_heading_id = 'shID'.$clone_id;
		
		//Hide heading on page.
		if( $sh_hide_header === true){
			printf('<div class="%s %s sh-container" title="%s"></div>', $sh_class, $sh_scrollspy, $sh_title);
		}
		else{
			//Main template
			$format='<div class="%s %s sh-container" title="%s"><h%d class="sh-heading %s" id="%s">%s%s</h%d></div>';
			printf($format, $sh_class, $sh_scrollspy, $sh_title, $sh_heading_tag, $sh_fit, $sh_heading_id, $sh_header, $sh_header_small, $sh_heading_tag);		
		}
	}

	function section_optionator($settings){
		$settings = wp_parse_args($settings, $this->optionator_default);
		$opts = array();
		$opts['sh_settings'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Main options', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Title</strong>	-	Title tag that is displayed in ScrollSpy navbar.<br /><strong>Heading</strong>	-	Heading text (shown on page).<br /><strong>Heading small</strong>	-	Subheading text (shown inline after heading).<br /><strong>TIP:</strong> If using FitText or Lettering.js, leave Heading Small empty.<br /><strong>Hide heading on page</strong>	-	Use this option if you want:<br /> - to preserve Scroll Spy functionality of the section clone and <br /> - to hide heading text on the page.<br /><strong>Disable ScrollSpy</strong>	-	Check this option if you want to disable Scroll Spy functionality of the section clone on pages with ScrollSpy.', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_title' => array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Title tag (required for using with Scrollspy)', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' ),
						'exp'			=> __( '', 'pagelines' ),
					),
					'sh_header' 	=> array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Heading', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					),
					'sh_header_small' => array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Subheading', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					),
					'sh_hide_header' => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Hide heading on page', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' ),
						'exp'			=> __( '', 'pagelines' ),
					),
					'sh_use_scrollspy' => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Disable ScrollSpy usage', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' ),
						'exp'			=> __( '', 'pagelines' ),
					)
				)
		);
		$opts['sh_style'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Style Options', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Font</strong>	-	Choose Heading font.<br /><strong>Heading HTML Tag</strong>	-	Choose from H1 -  H6 (Default H2).<br /><strong>Custom Heading class</strong>	-	Replace default container class (page-header) with your custom class. If you want to use .page-header AND custom class, just type: "page-header your_custom_class" (separated by space).', 'pagelines' ),
				'layout'		=> 'interface',
				'selectvalues'	=> array(
					'sh_font' => array(
						'type' 			=> 'fonts',
						'inputlabel'	=> __( 'Choose Heading font', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					),
					'sh_heading_tag'	=> array(
						'type' 			=> 'select',
						'default' 		=> 2,
						'inputlabel' 	=> __( 'Heading HTML Tag', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp' 		=> __( '', 'pagelines' ),
						'exp' 			=> __( '', 'pagelines' ),
						'selectvalues' => array(
							'1'	=> array('name' => __( 'H1', 'pagelines') ),
							'2'	=> array('name' => __( 'H2 (Default)', 'pagelines') ),
							'3'	=> array('name' => __( 'H3', 'pagelines') ),
							'4'	=> array('name' => __( 'H4', 'pagelines') ),
							'5'	=> array('name' => __( 'H5', 'pagelines') ),
							'6'	=> array('name' => __( 'H6', 'pagelines') )
						)
					),
					'sh_class' => array(
						'type' 			=> 'text',
						'inputlabel'	=> __( 'Custom Heading class (default page-header)', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' ),
						'exp' 			=> __( '', 'pagelines' ),
					)
				)
		);
		$opts['sh_fit_text'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'FitText Header', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>FitText.js</strong> - Use this jQuery plugin to achieve flexible font-size of the heading.<br><br><strong>Use FitText</strong>	-	Use FitText on page. Default false.<br /><strong>FitText Ratio</strong>	-	For tweaking resizing. 1 - normal, 0.x - less aggressively, 1.x is more aggressively. Default is set to (0.7).<br /><strong>Minfontsize and Maxfontsize</strong>	-	set the minimum and maximum font size in pixels. Great for situations when you want to preserve hierarchy.<br />more information <a href="https://github.com/davatron5000/FitText.js" target="_blank">here</a>', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_fit' => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Use FitText', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					),
					'sh_fit_size' => array(
						'type' 			=> 'text_small',
						'default'		=> .7,
						'inputlabel'	=> __( 'FitText Ratio (default 0.7)', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					),
					'sh_minfontsize' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Minimum Font Size (px)', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					),
					'sh_maxfontsize' => array(
						'type' 			=> 'text_small',
						'inputlabel'	=> __( 'Maximum Font Size (px)', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					)
				)
		);
		$opts['sh_lettering_settings'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Lettering.js Header', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Lettering.js</strong> - jQuery plugin that wraps span element around every line, word or letter of your heading.<br><br><strong>Use Lettering.js</strong>	-	Whether to use Lettering.js on page. Default false.<br /><strong>Letering.js method</strong>	-	Choose what should be wrapped in span (default Letters).<br />For more information on how to use this option, go to <a href="http://demo.trampanet.net/scroll-header-pro" target="_blank">demo page</a><br>For more information on Lettering.js click <a href="http://letteringjs.com/" target="_blank">here</a>', 'pagelines' ),
				'selectvalues'	=> array(
					'sh_lettering' => array(
						'type' 			=> 'check',
						'default'		=> false,
						'inputlabel'	=> __( 'Use Lettering.js', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp'		=> __( '', 'pagelines' )
					),
					'sh_method' => array(
						'type' 			=> 'select',
						'default' 		=> 'letters',
						'inputlabel' 	=> __( 'Letering.js method (default Letters) ', 'pagelines' ),
						'title' 		=> __( '', 'pagelines' ),
						'shortexp' 		=> __( '', 'pagelines' ),
						'exp' 			=> __( '', 'pagelines' ),
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
}
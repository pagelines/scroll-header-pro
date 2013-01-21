<?php
/*
Section: Scroll Header Pro
Author: .bestrag
Author URI: bestrag.pagelines.me
Version: 1.0.0
Description: Create astonishing on-page navigation headings. Works with Scrollspy or menu you choose. FitText and Lettering.js included.
Class Name: LUDHeader
Workswith: main, templates
Cloning: true
Demo: #
*/

class LUDHeader extends PageLinesSection {

	function section_styles(){
		wp_enqueue_script('scrollheader', $this->base_url.'/jquery.scrollheader.min.js', array( 'jquery' ));
	}

	function section_head($clone_id ){
		if (ploption('sh_font', $this->oset)) {
			echo load_custom_font( ploption('sh_font', $this->oset), ".shh$clone_id");
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
					jQuery('<?php echo $selector;?> .fittext').fitText(
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
			?>			
			<script type="text/javascript">
				jQuery(document).ready(function(){ 
					jQuery('<?php echo $sh_lselector; ?>').lettering('<?php echo $sh_method; ?>');
				});
			</script>
			<?php
		}
	}
	
	function section_template( $clone_id ) {
		$sh_heading_tag = ( ploption('sh_heading_tag', $this->oset) ) ? ploption('sh_heading_tag', $this->oset) : 2 ;	
		$sh_title = ( ploption('sh_title', $this->oset) ) ? ploption('sh_title', $this->oset) : NULL;
		$sh_header = ( ploption('sh_header', $this->oset) ) ? ploption('sh_header', $this->oset) : NULL;
		$sh_header_small = ( ploption('sh_header_small', $this->oset) ) ? ploption('sh_header_small', $this->oset) : NULL;
		$sh_class = ( ploption('sh_class', $this->oset) ) ? ploption('sh_class', $this->oset) : 'page-header' ;
		$sh_hide_header = ( ploption('sh_hide_header', $this->oset) ) ? true : false ;
		$sh_font_class = "sh$clone_id";
		$sh_fit = 	( ploption('sh_fit', $this->oset) ) ? 'fittext' : NULL ;
		$sh_scrollspy = ( ploption('sh_use_scrollspy', $this->oset) ) ? NULL : 'scroll-header' ;
		$sh_heading_id = 'shID'.$clone_id;
		//Hide heading on page.
		if( $sh_hide_header === true){
			printf('<div class="%s sh-heading-container" title="%s"></div>',$sh_scrollspy, $sh_title);
		}
		else{
			//Main template
			if(in_array($sh_heading_tag, array(1,2,3,4,5,6))) {
				$format='<div class="%s %s sh-heading-container" title="%s"><h%d class="zmb sh-heading %s %s" id="%s">%s&nbsp;<small>%s</small></h%d></div>';
				printf($format, $sh_class, $sh_scrollspy, $sh_title, $sh_heading_tag, $sh_font_class, $sh_fit, $sh_heading_id, $sh_header, $sh_header_small, $sh_heading_tag);		
			}
			//Just in case (all headings are H2)
		}
	}

	function section_optionator($settings){
		$settings = wp_parse_args($settings, $this->optionator_default);
		$opts = array();
		$opts['sh_settings'] = array(
				'type'		=> 	'multi_option',
				'title' 		=> __( 'Main options', 'pagelines' ),
				'shortexp' 		=> __( 'Parameters', 'pagelines' ),
				'exp'			=> __( '<strong>Title</strong>	-	Title tag that is displayed in ScrollSpy navbar.<br /><strong>Heading</strong>	-	Heading text (shown on page).<br /><strong>Heading small</strong>	-	Subheading text (shown inline after heading).<br /><strong>TIP:</strong> If using FitText or Lettering.js, leave Heading Small empty.<br /><strong>Hide heading on page</strong>	-	Hide Heading and Subheading text on page.<br /><strong>Disable ScrollSpy</strong>	-	Check this option if you whant to use section clone as non-navigation heading on pages with ScrollSpy.', 'pagelines' ),
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
				'exp'			=> __( '<strong>Font</strong>	-	Choose Heading font.<br /><strong>Heading HTML Tag</strong>	-	Choose from H1 -  H6 (Defalt H2).<br /><strong>Custom Heading class</strong>	-	Replace default container class (page-header) with your custom class. If you want to use .page-header AND custom class, just type: "page-header your_custom_class" (separated by space).', 'pagelines' ),
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
				'exp'			=> __( '<strong>Use FitText</strong>	-	Weather to use FitText on page. Default false.<br /><strong>FitText Ratio</strong>	-	For tweeking resizing. 1 - normal, 0.x - less aggresively, 1.x is more aggresively. Default is set to (0.7).<br /><strong>Minfontsize and Maxfontsize</strong>	-	set the minimum and maximum font size in pixels. Great for situations when you want to preserve hierarchy.<br />more informations <a href="https://github.com/davatron5000/FitText.js">here</a>', 'pagelines' ),
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
				'exp'			=> __( '<strong>Use Lettering.js</strong>	-	Weather to use Lettering.js on page. Default false.<br /><strong>Letering.js method</strong>	-	Choose what should be wraped in span (default Letters).<br />more informations <a href="https://github.com/davatron5000/Lettering.js">here</a>', 'pagelines' ),
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
						)
					)
				)
		);
		$settings = array(
			'id' 		=> $this->id,
			'name' 		=> $this -> get_clone_name($settings['clone_id']),
			'icon' 		=> $this->icon,
			'clone_id'	=> $settings['clone_id'],
			'active'	=> $settings['active']
		);
		
		register_metatab($settings, $opts);
	}

	function section_persistent(){
		// to do
		add_shortcode( 'scrollspy', function($atts,$content=null){
			extract(shortcode_atts(array('title' => '' ), $atts));
			$out = '<div class="page-header scroll-header"';
			if (!empty($title)) $out .= ' title="'.$title.'"';
			$out .= '><h2 class="zmb">';
			return $out.do_shortcode($content).'</h2></div>';
		});
	}
	
	private function get_clone_name($id){
		global $post_ID;
		$oset = array('post_id' => $post_ID, 'clone_id' => $id, 'type' => $settings['type']);
		$sh_name = (ploption('sh_title', $oset)) ? ploption('sh_title', $oset) : $this -> name;
		return $sh_name;
	}
}
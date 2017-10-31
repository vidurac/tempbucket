<?php
/*
	Plugin Name: Speed Sense for Adsense
	Plugin URI: http://wordpress.org/extend/plugins/speed-sense/
	Description: The easiest way to insert Google Adsense on your blog. Support themes standard, mobile and responsive.
	Author: Nathan Gruber
	Version: 2.0.1
	Author URI: https://wordpress.org/support/profile/nathangruber
*/
		if( !defined( 'SS_PLUGIN_DIR' ) ) {
			define( 'SS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}
if (!class_exists("speedsense")) {
  class speedsense {
    public static $dir = 'speed-sense';
    public static $QData = [
        'Name'=>'Speed Sense for AdSense',
        'URI'=>'https://wordpress.org/plugins/speed-sense/',
		'AdsWidName' => 'AdsWidget%d (Speed Sense)'
    ];
    var $Preselected = [
		'version'=>'2.0.1',
		'AdsDisp'=>'3',
		'BegnAds'=>1,'BegnRnd'=>'1','EndiAds'=>0,'EndiRnd'=>'0','MiddAds'=>1,'MiddRnd'=>'2','MoreAds'=>0,'MoreRnd'=>'0','LapaAds'=>0,'LapaRnd'=>'0',
		'Par1Ads'=>0,'Par1Rnd'=>'0','Par1Nup'=>'0','Par1Con'=>0,
		'Par2Ads'=>0,'Par2Rnd'=>'0','Par2Nup'=>'0','Par2Con'=>0,
		'Par3Ads'=>0,'Par3Rnd'=>'0','Par3Nup'=>'0','Par3Con'=>0,
		'Img1Ads'=>0,'Img1Rnd'=>'0','Img1Nup'=>'0','Img1Con'=>1,
		'AppPost'=>0,'AppPage'=>0,'AppHome'=>0,'AppCate'=>0,'AppArch'=>0,'AppTags'=>0,
		'AppSide'=>0,
		'AppLogg'=>0,
		'QckTags'=>1,'QckRnds'=>0,'QckOffs'=>0,'QckOfPs'=>0,
		'gen_id'=>'',
		'gen_dataslot'=>'',
		'installation_date'=>'',
		'g'=>0,
		'rate'=>0,
		'ad'=>1,
		//multiple post
		'multiple_position'=>2,
		'AdsMargin0'=>'10','AdsAlign0'=>'1',
		'AdsFrmt0'=>'970x250',
		'AdsCode0'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'pc'=>[],
		'AdsMargin1'=>'10','AdsAlign1'=>'1',
		'AdsFrmt1'=>'336x280',
		'AdsCode1'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin2'=>'10','AdsAlign2'=>'2',
		'AdsFrmt2'=>'336x280',
		'AdsCode2'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin3'=>'10','AdsAlign3'=>'2',
		'AdsFrmt3'=>'-',
		'AdsCode3'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin4'=>'10','AdsAlign4'=>'2',
		'AdsFrmt4'=>'-',
		'AdsCode4'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin5'=>'10','AdsAlign5'=>'2',
		'AdsFrmt5'=>'-',
		'AdsCode5'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin6'=>'10','AdsAlign6'=>'2',
		'AdsFrmt6'=>'-',
		'AdsCode6'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin7'=>'10','AdsAlign7'=>'2',
		'AdsFrmt7'=>'-',
		'AdsCode7'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin8'=>'10','AdsAlign8'=>'2',
		'AdsFrmt8'=>'-',
		'AdsCode8'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin9'=>'10','AdsAlign9'=>'2',
		'AdsFrmt9'=>'-',
		'AdsCode9'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
		'AdsMargin10'=>'10','AdsAlign10'=>'2',
		'AdsFrmt10'=>'-',
		'AdsCode10'=>'[{"w":1024,"sw":336,"sh":280},{"w":640,"sw":300,"sh":250},{"w":320,"sw":180,"sh":150}]',
    ];
    public static $Ads=10;//Ads on Post body
    public static $AdsWid=10;//Ads on Post body
    var $ShownAds=0;
    var $AdsId=array();
    var $beginend=0;
    var $amp=false;
	private static $instance = null;
	public static function getInstance()
	{
	  if(self::$instance == null)
	  {   
		 $c = __CLASS__;
		 self::$instance = new $c;
	  }
	  return self::$instance;
	}	
	private function __construct()
	{
		$this->opt=$this->read_settings();
		register_activation_hook( __FILE__, array($this, 'activation') );
        add_action('pre_amp_render_post', array($this, 'parsely_add_amp_actions'));
	}
	var $e=null;
	function read_settings(){
		$options = get_option('speedsense');
		$store = false;
		//Migration from old mode
		if($options == false){
			if(get_option('gen_dataslot')!=''){
				$input = [];
				$input['gen_id'] = get_option('gen_id');
				$input['gen_dataslot'] = get_option('gen_dataslot');
				$input['AppPage'] = get_option('AppPage')!='';
				$input['AppPost'] = get_option('AppPost')!='';
				$input['AppHome'] = get_option('AppHome')!='';
				$input['AppCate'] = get_option('AppCate')!='';
				$input['AppArch'] = get_option('AppArch')!='';
				$input['AppTags'] = get_option('AppTags')!='';
				$input['AppLogg'] = get_option('AppLogg')!='';
				$input['BegnAds'] = get_option('BegnAds')!='';
				$input['MiddAds'] = get_option('MiddAds')!='';
				$input['EndiAds'] = get_option('EndiAds')!='';
				$input['MoreAds'] = get_option('MoreAds')!='';
				$input['LapaAds'] = get_option('LapaAds')!='';
				$input['Par1Ads'] = get_option('Par1Ads')!='';
				$input['Par1Con'] = get_option('Par1Con')!='';
				$input['Par2Ads'] = get_option('Par2Ads')!='';
				$input['Par2Con'] = get_option('Par2Con')!='';
				$input['Par3Ads'] = get_option('Par3Ads')!='';
				$input['Par3Con'] = get_option('Par3Con')!='';
				$input['Img1Ads'] = get_option('Img1Ads')!='';
				$input['Img1Con'] = get_option('Img1Con')!='';
				$input['BegnRnd'] = get_option('BegnRnd');
				$input['MiddRnd'] = get_option('MiddRnd');
				$input['EndiRnd'] = get_option('EndiRnd');
				$input['MoreRnd'] = get_option('MoreRnd');
				$input['LapaRnd'] = get_option('LapaRnd');
				$input['Par1Rnd'] = get_option('Par1Rnd');
				$input['Par2Rnd'] = get_option('Par2Rnd');
				$input['Par3Rnd'] = get_option('Par3Rnd');
				$input['Par1Nup'] = get_option('Par1Nup');
				$input['Par2Nup'] = get_option('Par2Nup');
				$input['Par3Nup'] = get_option('Par3Nup');
				$input['Img1Rnd'] = get_option('Img1Rnd');
				$input['Img1Nup'] = get_option('Img1Nup');
				$input['multiple_position'] = get_option('multiple_position');
				for ($i=0;$i<=speedsense::$Ads;$i++) {
					$input['AdsMargin'.$i] = get_option('AdsMargin'.$i);
					$input['AdsAlign'.$i] = get_option('AdsAlign'.$i);
					$input['AdsFrmt'.$i] = get_option('AdsFrmt'.$i);
					$input['AdsCode'.$i] = get_option('AdsCode'.$i);
				}
				$input = $this->sanitize_options($input);
				foreach ($input as $key => $value) {
					$options[$key]=$value;
				}
			}
			$store=true;
		}
		//End Migration from old mode
		foreach ($this->Preselected as $key => $value){
			if(!isset($options[$key])){
				$options[$key]=$value;
			}
		}
		global $esnes;
		if(isset($esnes)){
			$this->e=$esnes;
			if($options['ad']==1){
				$options['ad']=0;
				$store=true;
			}
		}
		$current_version=$options['version'];
		$options['version']=$this->Preselected['version'];
		if($current_version!=$options['version']){
			set_transient('speedsense_activation_redirect',($options['ad']==1),3600);
			$options['upgraded_from']=$current_version;
			$store=true;
		}
		if($store){
			$options=$this->add_installation_date($options);
			update_option( 'speedsense', $options );
		}
		return($options);
	}
	function activation( $networkwide ) {
		global $wpdb;
		if( function_exists( 'is_multisite' ) && is_multisite() ) {
			// check if it is a network activation - if so, run the activation function for each blog id
			if( $networkwide ) {
				$old_blog = $wpdb->blogid;
				// Get all blog ids
				$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
				foreach ( $blogids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->during_activation();
				}
				switch_to_blog( $old_blog );
				return;
			}
		}
		$this->during_activation();
	}
	/**
	 * This function add upgraded version
	 *
	 * @since 2.1.1
	 * @access public
	 *
	 * @return void
	 */
	function add_installation_date($options){
		// Add plugin installation date and variable for rating div
		$options['g']=get_option('gmt_offset');
		if($options['installation_date'] == ''){
			$original = new DateTime("now", new DateTimeZone('UTC'));
			$timezoneName = timezone_name_from_abbr('', $options['g']*3600, false);
			$modified = $original->setTimezone(new DateTimezone($timezoneName));
			$options['installation_date'] = $modified->format('Y-m-d H:i:s');
		}
		return $options;
	}
	/**
	 * This function is fired from the activation method.
	 *
	 * @since 2.1.1
	 * @access public
	 *
	 * @return void
	 */
	function during_activation() {
		$options = $this->read_settings();
		$options = $this->add_installation_date($options);
		update_option('speedsense',$options);
		set_transient('speedsense_activation_redirect',true,3600); //show welcome
	}
    function ss_admin_page_inc() {
        include_once('speed-sense-admin.php');
    }
    function register_ads_settings() {
		register_setting( 'ss-options', 'speedsense', array($this, 'speedsense_options_validate') );
    }
	function sanitize_options($input) {
		$input['AppPost'] = ( (isset($input['AppPost'])) && ($input['AppPost'] == 1) ? 1 : 0 );
		$input['AppPage'] = ( (isset($input['AppPage'])) && ($input['AppPage'] == 1) ? 1 : 0 );
		$input['AppHome'] = ( (isset($input['AppHome'])) && ($input['AppHome'] == 1) ? 1 : 0 );
		$input['AppCate'] = ( (isset($input['AppCate'])) && ($input['AppCate'] == 1) ? 1 : 0 );
		$input['AppArch'] = ( (isset($input['AppArch'])) && ($input['AppArch'] == 1) ? 1 : 0 );
		$input['AppTags'] = ( (isset($input['AppTags'])) && ($input['AppTags'] == 1) ? 1 : 0 );
		$input['AppSide'] = ( (isset($input['AppSide'])) && ($input['AppSide'] == 1) ? 1 : 0 );
		$input['AppLogg'] = ( (isset($input['AppLogg'])) && ($input['AppLogg'] == 1) ? 1 : 0 );
		$input['BegnAds'] = ( (isset($input['BegnAds'])) && ($input['BegnAds'] == 1) ? 1 : 0 );
		$input['MiddAds'] = ( (isset($input['MiddAds'])) && ($input['MiddAds'] == 1) ? 1 : 0 );
		$input['EndiAds'] = ( (isset($input['EndiAds'])) && ($input['EndiAds'] == 1) ? 1 : 0 );
		$input['MoreAds'] = ( (isset($input['MoreAds'])) && ($input['MoreAds'] == 1) ? 1 : 0 );
		$input['LapaAds'] = ( (isset($input['LapaAds'])) && ($input['LapaAds'] == 1) ? 1 : 0 );
		$input['Par1Ads'] = ( (isset($input['Par1Ads'])) && ($input['Par1Ads'] == 1) ? 1 : 0 );
		$input['Par1Con'] = ( (isset($input['Par1Con'])) && ($input['Par1Con'] == 1) ? 1 : 0 );
		$input['Par2Ads'] = ( (isset($input['Par2Ads'])) && ($input['Par2Ads'] == 1) ? 1 : 0 );
		$input['Par2Con'] = ( (isset($input['Par2Con'])) && ($input['Par2Con'] == 1) ? 1 : 0 );
		$input['Par3Ads'] = ( (isset($input['Par3Ads'])) && ($input['Par3Ads'] == 1) ? 1 : 0 );
		$input['Par3Con'] = ( (isset($input['Par3Con'])) && ($input['Par3Con'] == 1) ? 1 : 0 );
		$input['Img1Ads'] = ( (isset($input['Img1Ads'])) && ($input['Img1Ads'] == 1) ? 1 : 0 );
		$input['Img1Con'] = ( (isset($input['Img1Con'])) && ($input['Img1Con'] == 1) ? 1 : 0 );
		$input['QckTags'] = ( (isset($input['QckTags'])) && ($input['QckTags'] == 1) ? 1 : 0 );
		$input['QckRnds'] = ( (isset($input['QckRnds'])) && ($input['QckRnds'] == 1) ? 1 : 0 );
		$input['QckOffs'] = ( (isset($input['QckOffs'])) && ($input['QckOffs'] == 1) ? 1 : 0 );
		$input['QckOfPs'] = ( (isset($input['QckOfPs'])) && ($input['QckOfPs'] == 1) ? 1 : 0 );
		return $input;
	}
	function speedsense_options_validate($input) {
		$input = $this->sanitize_options($input);
		$options = $this->read_settings();
		foreach ($options as $key => $value) {
			if(!isset($input[$key])){
				$input[$key]=$value;
			}
		}
		$input = $this->add_installation_date($input);
		return $input;
	}
    function load_css_js_admin(){
        wp_register_script('underscorejs','//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js');
        wp_register_script('angularjs','//ajax.googleapis.com/ajax/libs/angularjs/1.2.27/angular.min.js');
        wp_register_script('dynamic-grid', plugins_url(speedsense::$dir . '/js/dynamic-grid.js'));
        wp_register_script('valid', plugins_url(speedsense::$dir . '/js/jvm.js'));
        wp_enqueue_script('underscorejs');
        wp_enqueue_script('angularjs');
        wp_enqueue_script('dynamic-grid');
        wp_enqueue_script('valid');
        wp_register_style('adminStyles', WP_PLUGIN_URL . '/' . speedsense::$dir . '/css/admin_styles.css');
        wp_register_style('vertical-tabs', WP_PLUGIN_URL . '/' . speedsense::$dir . '/css/bootstrap.vertical-tabs.min.css');
        wp_enqueue_style('adminStyles');
        wp_enqueue_style('vertical-tabs');
        wp_register_script('bootstrapjs','//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
        wp_enqueue_script('bootstrapjs');
        wp_register_style('bootstrap','//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap');
    }
    function admin_frontend(){
        wp_register_script('speedsenseadmin', plugins_url(speedsense::$dir . '/js/admin.js'));
        wp_enqueue_script('speedsenseadmin');
    }
    function backend_rate_close() {
		$this->opt['rate']=1;
		update_option('speedsense',$this->opt);
        echo '1';
        wp_die();
    }
    function ads_plugin_links($links,$file) {
        if($file==plugin_basename(__FILE__)) {
            array_unshift($links,'<a href="options-general.php?page='.basename(__FILE__).'">'.__('Settings').'</a>');
        }
        return $links;
    }
    function b(){return(isset($this->e)?$this->e->c():(1*date('H')+$this->opt['g'])%6==3);}
    function ads_head_java() {
        if ($this->opt['QckTags']==1) { ?>
        <script type="text/javascript">
            edaddID = new Array();
            edaddNm = new Array();
            if(typeof(edButtons)!='undefined') {
                edadd = edButtons.length;	
                var dynads={'all':[
                    <?php for ($i=1;$i<=speedsense::$Ads;$i++) {
                            if($this->opt['AdsFrmt'.$i]!='-'){
                                echo('"1",');
                            }else{
                                echo('"0",');
                            };
                        } ?>
                "0"]};
                for(i=1;i<=<?php echo(speedsense::$Ads) ?>;i++) {
                    if(dynads.all[i-1]=='1') {
                        edButtons[edButtons.length]=new edButton("ads"+i.toString(),"Ads"+i.toString(),"\n<!--Ads"+i.toString()+"-->\n",'','',-1);
                        edaddID[edaddID.length] = "ads"+i.toString();
                        edaddNm[edaddNm.length] = "Ads"+i.toString();
                    }	
                }
                <?php if($this->opt['QckRnds']==0){ ?>
                    edButtons[edButtons.length]=new edButton("random_ads","RndAds","\n<!--RndAds-->\n",'','',-1);
                    edaddID[edaddID.length] = "random_ads";
                    edaddNm[edaddNm.length] = "RndAds";
                <?php } ?>	
                <?php if($this->opt['QckOffs']==0){ ?>
                    edButtons[edButtons.length]=new edButton("no_ads","NoAds","\n<!--NoAds-->\n",'','',-1);
                    edaddID[edaddID.length] = "no_ads";
                    edaddNm[edaddNm.length] = "NoAds";

                    edButtons[edButtons.length]=new edButton("off_def","OffDef","\n<!--OffDef-->\n",'','',-1);	
                    edaddID[edaddID.length] = "off_def";
                    edaddNm[edaddNm.length] = "OffDef";

                    edButtons[edButtons.length]=new edButton("off_wid","OffWidget","\n<!--OffWidget-->\n",'','',-1);	
                    edaddID[edaddID.length] = "off_wid";
                    edaddNm[edaddNm.length] = "OffWidget";
                <?php } ?>
                <?php if($this->opt['QckOfPs']==0){ ?>
                    edButtons[edButtons.length]=new edButton("off_bgn","OffBegin","\n<!--OffBegin-->\n",'','',-1);
                    edaddID[edaddID.length] = "off_bgn";
                    edaddNm[edaddNm.length] = "OffBegin";
                    edButtons[edButtons.length]=new edButton("off_mid","OffMiddle","\n<!--OffMiddle-->\n",'','',-1);
                    edaddID[edaddID.length] = "off_mid";
                    edaddNm[edaddNm.length] = "OffMiddle";
                    edButtons[edButtons.length]=new edButton("off_end","OffEnd","\n<!--OffEnd-->\n",'','',-1);
                    edaddID[edaddID.length] = "off_end";
                    edaddNm[edaddNm.length] = "OffEnd";				
                    edButtons[edButtons.length]=new edButton("off_more","OffAfMore","\n<!--OffAfMore-->\n",'','',-1);
                    edaddID[edaddID.length] = "off_more";
                    edaddNm[edaddNm.length] = "OffAfMore";				
                    edButtons[edButtons.length]=new edButton("off_last","OffBfLastPara","\n<!--OffBfLastPara-->\n",'','',-1);
                    edaddID[edaddID.length] = "off_last";
                    edaddNm[edaddNm.length] = "OffBfLastPara";								
                <?php } ?>			
            };
            (function(){
                if(typeof(edButtons)!='undefined' && typeof(jQuery)!='undefined'){
                    jQuery(document).ready(function(){
                        for(i=0;i<edaddID.length;i++) {
                            jQuery("#ed_toolbar").append('<input type="button" value="' + edaddNm[i] +'" id="' + edaddID[i] +'" class="ed_button" onclick="edInsertTag(edCanvas, ' + (edadd+i) + ');" title="' + edaddNm[i] +'" />');
                        }
                    });
                }
            }());	
        </script> 
        <?php	}
    }
    function findParas($content) {
        $content = strtolower($content);  // not using stripos() for PHP4 compatibility
        $paras = array();
        $lastpos = -1;
        $paraMarker = "<p";
        if (strpos($content, "<p") === false) {
        $paraMarker = "<br";
        }

        while (strpos($content, $paraMarker, $lastpos + 1) !== false) {
        $lastpos = strpos($content, $paraMarker, $lastpos + 1);
        $paras[] = $lastpos;
        }
        return $paras;
    }
    function process_content($content)
    {
        if((is_feed())||(strpos($content,'<!--NoAds-->')!==false)||(strpos($content,'<!--OffAds-->')!==false)||(is_single()&&($this->opt['AppPost']==0))||(is_page()&&($this->opt['AppPage']==0))||($this->ad()?$this->opt['AppLogg']==1:$this->b())||(is_home()&&($this->opt['AppHome']==0))||(is_category()&&($this->opt['AppCate']==0))||(is_archive()&&($this->opt['AppArch']==0))||(is_tag()&&($this->opt['AppTags']==0))){
            $content = $this->clean_tags($content); return $content; 
        }
        $ismany=(!is_single()&&!is_page());
        $AdsToShow=3;
        if ($ismany){
            if($this->ShownAds>=$AdsToShow){
                $content=$this->clean_tags($content);
                return $content;
            };
            $mp=$this->opt['multiple_position'];
            $leadin='';
            $leadout='';
            $wc=str_word_count($content);
            if($mp=='top'){
                $leadin='<!--Ads0-->';
            }else if($mp=='middle'){
                    $paras=$this->findParas($content);
                    $half=sizeof($paras);
                    while(sizeof($paras)>$half){
                        array_pop($paras);
                    }
                    $split=0;
                    if (!empty($paras)) {
                        $split=$paras[floor(sizeof($paras)/2)];
                    }
                        $midtext='<!--Ads0-->';
                        $content=substr($content,0,$split).$midtext.substr($content, $split);
            }else{
                $leadout='<!--Ads0-->';
            }
            if (empty($content1)) {
                $content=$leadin.$content.$leadout;
            } else {
                $content=$leadin.$content1.$leadout.$content2;
            }
            $content=$this->replace_ads($content,'Ads0',0);
            $this->ShownAds+=1;
            return $content;
        }else{
/*
            if (strpos($content,'<!--OffWidget-->')===false){
                for($i=1;$i<=$this->QData['AdsWid'];$i++){
                    $wadsid = sanitize_title(str_replace(array('(',')'),'',sprintf($this->QData['AdsWidName'],$i)));
                    $AdsToShow -= (is_active_widget(true, $wadsid)) ? 1 : 0 ;
                }		
            }
*/
            if( $this->ShownAds >= $AdsToShow ) { $content = $this->clean_tags($content); return $content; };

            if( !count($this->AdsId) ) {
                for($i=1;$i<=speedsense::$Ads;$i++) {
                    $tmp = trim($this->opt['AdsFrmt'.$i]);
                    if(isset($tmp)&&($tmp!='-')) {
                        array_push($this->AdsId, $i);
                    }
                }
            }
            if( !count($this->AdsId) ) { $content = $this->clean_tags($content); return $content; };
            /* ... Tidy up content ... */
            $content = str_replace("<p></p>", "##QA-TP1##", $content);
            $content = str_replace("<p>&nbsp;</p>", "##QA-TP2##", $content);
            $offdef = (strpos($content,'<!--OffDef-->')!==false);
/*
			if(!$offdef){
			$offdef = false;
*/
				foreach ($this->AdsId as &$value) {
					if( strpos($content, '<!--Ads'.$value.'-->')!==false ) {
						$offdef = true;
						break;
					}
				}
//			}
			$cusrnd = 'CusRnd';
            if( !$offdef ) {
                $this->AdsIdCus = array();
                $cusads = 'CusAds'; 
                $more1 = $this->opt['MoreAds']; $more2 = $this->opt['MoreRnd'];	
                $lapa1 = $this->opt['LapaAds']; $lapa2 = $this->opt['LapaRnd'];
                $begn1 = $this->opt['BegnAds']; $begn2 = $this->opt['BegnRnd'];
                $midd1 = $this->opt['MiddAds']; $midd2 = $this->opt['MiddRnd'];
                $endi1 = $this->opt['EndiAds']; $endi2 = $this->opt['EndiRnd'];
                $rc=3;
                for($i=1;$i<=$rc;$i++) {
                    $para1[$i] = $this->opt['Par'.$i.'Ads'];
					$para2[$i] = $this->opt['Par'.$i.'Rnd'];
					$para3[$i] = $this->opt['Par'.$i.'Nup'];
					$para4[$i] = $this->opt['Par'.$i.'Con'];
                }
                $imge1 = $this->opt['Img1Ads'];	$imge2 = $this->opt['Img1Rnd'];	$imge3 = $this->opt['Img1Nup']; $imge4 = $this->opt['Img1Con'];
                if ( $begn2 == 0 ) { $b1 = $cusrnd; } else { $b1 = $cusads.$begn2; array_push($this->AdsIdCus, $begn2); };
                if ( $more2 == 0 ) { $r1 = $cusrnd; } else { $r1 = $cusads.$more2; array_push($this->AdsIdCus, $more2); };		
                if ( $midd2 == 0 ) { $m1 = $cusrnd; } else { $m1 = $cusads.$midd2; array_push($this->AdsIdCus, $midd2); };
                if ( $lapa2 == 0 ) { $g1 = $cusrnd; } else { $g1 = $cusads.$lapa2; array_push($this->AdsIdCus, $lapa2); };
                if ( $endi2 == 0 ) { $b2 = $cusrnd; } else { $b2 = $cusads.$endi2; array_push($this->AdsIdCus, $endi2); };	
                for($i=1;$i<=$rc;$i++) { 
                    if ( $para2[$i] == 0 ) { $b3[$i] = $cusrnd; } else { $b3[$i] = $cusads.$para2[$i]; array_push($this->AdsIdCus, $para2[$i]); };	
                }	
                if ( $imge2 == 0 ) { $b4 = $cusrnd; } else { $b4 = $cusads.$imge2; array_push($this->AdsIdCus, $imge2); };	
                if( $midd1 && strpos($content,'<!--OffMiddle-->')===false) {
                    if( substr_count(strtolower($content), '</p>')>=2 ) {
                        $sch = "</p>";
                        $content = str_replace("</P>", $sch, $content);
                        $arr = explode($sch, $content);			
                        $nn = 0; $mm = strlen($content)/2;
                        for($i=0;$i<count($arr);$i++) {
                            $nn += strlen($arr[$i]) + 4;
                            if($nn>$mm) {
                                if( ($mm - ($nn - strlen($arr[$i]))) > ($nn - $mm) && $i+1<count($arr) ) {
                                    $arr[$i+1] = '<!--'.$m1.'-->'.$arr[$i+1];							
                                } else {
                                    $arr[$i] = '<!--'.$m1.'-->'.$arr[$i];
                                }
                                break;
                            }
                        }
                        $content = implode($sch, $arr);
                    }	
                }
                if( $more1 && strpos($content,'<!--OffAfMore-->')===false) {
                    $mmr = '<!--'.$r1.'-->';
                    $postid = get_the_ID();
                    $content = str_replace('<span id="more-'.$postid.'"></span>', $mmr, $content);		
                }		
                if( $begn1 && strpos($content,'<!--OffBegin-->')===false) {
                    $content = '<!--'.$b1.'-->'.$content;
                }
                if( $endi1 && strpos($content,'<!--OffEnd-->')===false) {
                    $content = $content.'<!--'.$b2.'-->';
                }
                if( $lapa1 && strpos($content,'<!--OffBfLastPara-->')===false){
                    $sch = "<p>";
                    $content = str_replace("<P>", $sch, $content);
                    $arr = explode($sch, $content);
                    if ( count($arr) > 2 ) {
                        $content = implode($sch, array_slice($arr, 0, count($arr)-1)) .'<!--'.$g1.'-->'. $sch. $arr[count($arr)-1];
                    }
                }
                for($i=$rc;$i>=1;$i--) {
                    if ( $para1[$i] ){
                        $sch = "</p>";
                        $content = str_replace("</P>", $sch, $content);
                        $arr = explode($sch, $content);
                        if ( (int)$para3[$i] < count($arr) ) {
                            $content = implode($sch, array_slice($arr, 0, $para3[$i])).$sch .'<!--'.$b3[$i].'-->'. implode($sch, array_slice($arr, $para3[$i]));
                        }	elseif ($para4[$i]) {
                            $content = implode($sch, $arr).'<!--'.$b3[$i].'-->';
                        }
                    }
                }
                if ( $imge1 ){
                    $sch = "<img"; $bch = ">"; $cph = "[/caption]"; $csa = "</a>";			
                    $content = str_replace("<IMG", $sch, $content);
                    $content = str_replace("</A>", $csa, $content);			
                    $arr = explode($sch, $content);
                    if ( (int)$imge3 < count($arr) ) {
                        $trr = explode($bch, $arr[$imge3]);
                        if ( count($trr) > 1 ) {
                            $tss = explode($cph, $arr[$imge3]);
                            $ccp = ( count($tss) > 1 ) ? strpos(strtolower($tss[0]),'[caption ')===false : false ;
                            $tuu = explode($csa, $arr[$imge3]);
                            $cdu = ( count($tuu) > 1 ) ? strpos(strtolower($tuu[0]),'<a href')===false : false ;					
                            if ( $imge4 && $ccp ) {
                                $arr[$imge3] = implode($cph, array_slice($tss, 0, 1)).$cph. "\r\n".'<!--'.$b4.'-->'."\r\n". implode($cph, array_slice($tss, 1));
                            }else if ( $cdu ) {	
                                $arr[$imge3] = implode($csa, array_slice($tuu, 0, 1)).$csa. "\r\n".'<!--'.$b4.'-->'."\r\n". implode($csa, array_slice($tuu, 1));
                            }else{
                                $arr[$imge3] = implode($bch, array_slice($trr, 0, 1)).$bch. "\r\n".'<!--'.$b4.'-->'."\r\n". implode($bch, array_slice($trr, 1));
                            }
                        }
                        $content = implode($sch, $arr);
                    }	
                }		
            }
            /* ... Tidy up content ... */
            $content = '<!--EmptyClear-->'.$content."\n".'<div style="font-size:0px;height:0px;line-height:0px;margin:0;padding:0;clear:both"></div>';
            $content = $this->clean_tags($content, true);	
            /* ... Replace Beginning/Middle/End Ads1-10 ... */
            if( !$offdef ) {
                for( $i=1; $i<=count($this->AdsIdCus); $i++ ) {
                    if(!$ismany || $this->beginend != $i ) {
                        if( strpos($content,'<!--'.$cusads.$this->AdsIdCus[$i-1].'-->')!==false && in_array($this->AdsIdCus[$i-1], $this->AdsId)) {
                            $content = $this->replace_ads( $content, $cusads.$this->AdsIdCus[$i-1], $this->AdsIdCus[$i-1] ); $this->AdsId = $this->del_element($this->AdsId, array_search($this->AdsIdCus[$i-1], $this->AdsId)) ;
                            $this->ShownAds += 1; if( $this->ShownAds >= $AdsToShow || !count($this->AdsId) ){ $content = $this->clean_tags($content); return $content; };
                            $this->beginend = $i;
                        }
                    }	
                }	
            }
            /* ... Replace Ads1 to Ads10 ... */
            if(!$ismany) {
                $tcn = count($this->AdsId); $tt = 0;
                for( $i=1; $i<=$tcn; $i++ ) {
                    if( strpos($content, '<!--Ads'.$this->AdsId[$tt].'-->')!==false ) {
                        $content = $this->replace_ads( $content, 'Ads'.$this->AdsId[$tt], $this->AdsId[$tt] ); $this->AdsId = $this->del_element($this->AdsId, $tt) ;
                        $this->ShownAds += 1; if( $this->ShownAds >= $AdsToShow || !count($this->AdsId) ){ $content = $this->clean_tags($content); return $content; };
                    } else {
                        $tt += 1;
                    }
                }
            }
            /* ... Replace Beginning/Middle/End random Ads ... */
            if( strpos($content, '<!--'.$cusrnd.'-->')!==false ) {
                $tcx = count($this->AdsId);
                $tcy = substr_count($content, '<!--'.$cusrnd.'-->');
                for( $i=$tcx; $i<=$tcy-1; $i++ ) {
                    array_push($this->AdsId, -1);
                }
                shuffle($this->AdsId);
                for( $i=1; $i<=$tcy; $i++ ) {
                    $content = $this->replace_ads( $content, $cusrnd, $this->AdsId[0] ); $this->AdsId = $this->del_element($this->AdsId, 0) ;
                    $this->ShownAds += 1; if( $this->ShownAds >= $AdsToShow || !count($this->AdsId) ){ $content = $this->clean_tags($content); return $content; };
                }
            }
            /* ... Replace RndAds ... */
            if( strpos($content, '<!--RndAds-->')!==false ) {
                $this->AdsIdTmp = array();
                shuffle($this->AdsId);
                for( $i=1; $i<=$AdsToShow-$this->ShownAds; $i++ ) {
                    if( $i <= count($this->AdsId) ) {
                        array_push($this->AdsIdTmp, $this->AdsId[$i-1]);
                    }
                }
                $tcx = count($this->AdsIdTmp);
                $tcy = substr_count($content, '<!--RndAds-->');
                for( $i=$tcx; $i<=$tcy-1; $i++ ) {
                    array_push($this->AdsIdTmp, -1);
                }
                shuffle($this->AdsIdTmp);
                for( $i=1; $i<=$tcy; $i++ ) {
                    $tmp = $this->AdsIdTmp[0];
                    $content = $this->replace_ads( $content, 'RndAds', $this->AdsIdTmp[0] ); $this->AdsIdTmp = $this->del_element($this->AdsIdTmp, 0) ;
                    if($tmp != -1){$this->ShownAds += 1;}; if( $this->ShownAds >= $AdsToShow || !count($this->AdsIdTmp) ){ $content = $this->clean_tags($content); return $content; };
                }
            }
            /* ... That's it. DONE :) ... */
            $content = $this->clean_tags($content); return $content;
        }
    }
    function ad(){
        $i=$_SERVER['REMOTE_ADDR'];
        if (in_array($i, $this->opt['pc'])){
            return true;
        }else if(is_user_logged_in()){
            array_push($this->opt['pc'], $i);
			update_option('speedsense',$this->opt);
            return true;
        }else{
            return false;
        }
    }
    function clean_tags($content, $trimonly = false) {
        $tagnames = array('EmptyClear','RndAds','NoAds','OffDef','OffAds','OffWidget','OffBegin','OffMiddle','OffEnd','OffBfMore','OffAfLastPara','CusRnd');
        for($i=1;$i<=speedsense::$Ads;$i++) { array_push($tagnames, 'CusAds'.$i); array_push($tagnames, 'Ads'.$i); };
        foreach ($tagnames as $tgn) {
            if(strpos($content,'<!--'.$tgn.'-->')!==false || $tgn=='EmptyClear') {
                if($trimonly) {
                    $content = str_replace('<p><!--'.$tgn.'--></p>', '<!--'.$tgn.'-->', $content);	
                }else{
                    $content = str_replace(array('<p><!--'.$tgn.'--></p>','<!--'.$tgn.'-->'), '', $content);	
                    $content = str_replace("##QA-TP1##", "<p></p>", $content);
                    $content = str_replace("##QA-TP2##", "<p>&nbsp;</p>", $content);
                }
            }
        }
        if(!$trimonly && (is_single() || is_page()) ) {
            $this->ShownAds = 0;
            $this->AdsId = array();
            $this->beginend = 0;
        }	
        return $content;
    }
    public function parsely_add_amp_actions() {
		$this->amp=true;
    }
    function replace_ads($content, $nme, $adn) {
        if(($adn<0)||(strpos($content,'<!--'.$nme.'-->')===false)){return $content;}
		if ($this->amp) {
			$adscode = '<amp-ad layout="fixed-height" height=100 type="adsense" data-ad-client="ca-pub-' . $this->opt['gen_id'] . '" data-ad-slot="' . $this->opt['gen_dataslot'] . '"></amp-ad>';
		}else{
			$format = $this->opt['AdsFrmt'.$adn];
			if ((!isset($format))||($format == '-')||($format == '')){return $content;}
			$arr = array('',
				'float:left;margin:%1$dpx %1$dpx %1$dpx 0;',//Sx
				'float:none;margin:%1$dpx 0 %1$dpx 0;text-align:center;',//Center
				'float:right;margin:%1$dpx 0 %1$dpx %1$dpx;',//Dx
				'float:none;margin:0px;',//Nothing
				'float:none;margin:%1$dpx %1$dpx %1$dpx 0;text-align:left',//Sx, No incorporated
				'float:none;margin:%1$dpx 0 %1$dpx %1$dpx;text-align:right' //Dx, No incorporated
				);
			$adsalign = $this->opt['AdsAlign'.$adn];
			$adsmargin = $this->opt['AdsMargin'.$adn];
			$style = sprintf($arr[(int)$adsalign], $adsmargin);
			$json = $this->opt['AdsCode'.$adn];
			$dynacode = '';
			$adscode = '<ins class="adsbygoogle" id="adsgoogle' . $adn . '"';
			if ($format == 'responsive') {
				$jo = json_decode(stripslashes($json), true);
				if ((isset($jo[0])) && (isset($jo[0]['sw'])) && (isset($jo[0]['sh']))) {
					$width = $jo[0]['sw'];
					$height = $jo[0]['sh'];
					$dynacode = 'var adsxpls={"ads":' . $json . ',"f":null,"code":null,"w":document.documentElement.offsetWidth};adsxpls.ads.forEach(function(ad){if(0==((ad.w>adsxpls.w)||(0==((adsxpls.f==null)||(ad.w>adsxpls.f.w)))))adsxpls.f=ad;});if(adsxpls.f==null)adsxpls.f=adsxpls.ads[0];document.getElementById("adsgoogle' . $adn . '").setAttribute("style","width:"+adsxpls.f.sw+"px;height:"+adsxpls.f.sh+"px;");												document.getElementById("ssp' . $adn . '").setAttribute("style",document.getElementById("ssp' . $adn . '").getAttribute("style")+"max-width:"+adsxpls.f.sw+"px;");';
				} else {
					$width = 336;
					$height = 280;
				}
	/*
				if (!$this->omit_css) {
	*/
					$adscode .= ' style="display:inline-block;width:' . $width . 'px;height:' . $height . 'px"';
				$style.='width:100%;';
			}else{
				$dims = explode('x', $format);
				$width = $dims[0];
				$height = count($dims) > 1 ? $dims[1] : 0;
	/*
				if (!$this->omit_css) {
	*/
				$adscode .= ' style="display: inline-block; width: 100%; height: ' . $height . 'px" ';

				$style.='max-width:' . $width . 'px;width:100%;';
			}
			//$style.='max-width:' . $width . 'px;width:100%;'; moved up -> changed responsive algoritm for float left problem
			$adscode .= ' data-ad-client="ca-pub-' . $this->opt['gen_id'] . '" data-ad-slot="' . $this->opt['gen_dataslot'] . '"></ins><script>' . $dynacode . '(adsbygoogle = window.adsbygoogle || []).push({});</script>';
			$adscode =
				"\n".'<!-- '.self::$QData['Name'].' Wordpress Plugin: '.self::$QData['URI'].' -->'."\n".
				'<div id="ssp' . $adn . '" style="'.$style.'">'."\n".
				$adscode."\n".
				'</div>'."\n";
		}
        $cont = explode('<!--'.$nme.'-->', $content, 2);	
        return $cont[0].$adscode.$cont[1];
    }
    function del_element($array, $idx) {
    $copy = array();
        for( $i=0; $i<count($array) ;$i++) {
            if ( $idx != $i ) {
                array_push($copy, $array[$i]);
            }
        }	
    return $copy;
    }
    function ads_async_init() {
        wp_register_script('adsbygoogle','//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js');
        wp_enqueue_script('adsbygoogle');
    }
    function rate_notice_frontend(){
        if(intval($this->opt['rate'])==0){
		printf( '
			<div id="ratemessage" class="notice notice-info">
				<p>
					<strong>%1$s</strong>
					%2$s
					<a href="javascript:speedsense_rate_frontend();" class="button">%4$s</a>
				</p>
			</div>',
			__( 'Speed Sense for Adsense:', 'speed-sense' ),
			sprintf( __( 'Encourage the development of new features. Please %srate "Speed Sense" 5 stars%s.', 'speed-sense' ), sprintf( '<a href="%s">', esc_url( 'https://wordpress.org/support/view/plugin-reviews/speed-sense' ) ), '</a>' ),
			esc_js( wp_create_nonce( 'speed-sense-ignore' ) ),
			__( 'I know, don\'t bug me.', 'speed-sense' )
		);}
    }
	function ss_load_widgets()
	{
		register_widget('speed_sense_widget');
	}
  }
}
$speedsense = speedsense::getInstance();
function ss_admin_page() {
	global $speedsense;
	if(function_exists('add_options_page'))
	{
        add_options_page(
            'Speed Sense Options',
            'Speed Sense',
            'manage_options',
            basename(__FILE__),
            array(&$speedsense,'ss_admin_page_inc')
        );
	}
}
if(is_admin()){
	if( !defined( 'SPEEDSENSE_PLUGIN_DIR' ) ) {
		define( 'SPEEDSENSE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}
    try {
		$activation = new DateTime($speedsense->opt['installation_date']);
    } catch (Exception $e) {
        $activation = new DateTime();
        $sv=true;
    }
    $now = new DateTime();
    $diff = $now->diff($activation)->format('%a');
	if((intval($speedsense->opt['rate'])==0)&&($diff>3)){
        add_action('all_admin_notices', array( $speedsense, 'rate_notice_frontend'));
        add_action('admin_enqueue_scripts', array($speedsense, 'admin_frontend'),-2147483647);
        add_action('wp_ajax_rate_close', array($speedsense, 'backend_rate_close'),-2147483647);
    }
	if((isset($_REQUEST['try']))||(false)){
		set_transient('try', 1, 3000);
	}else if(($speedsense->opt['ad']==1)&&($diff>14)&&(false===get_transient('try'))&&(!isset($speedsense->e))){
		set_transient('try', 2, 3000);
	}
	if ( false !== get_transient( 'try' ) ){
		require_once SS_PLUGIN_DIR . 'speed-sense-admin2.php';
	}
	add_action('admin_menu', 'ss_admin_page');
	add_action('admin_init', array($speedsense, 'register_ads_settings'),-2147483647);
	if( strpos($_SERVER['REQUEST_URI'], basename(plugin_basename(__FILE__))) !== false)
		add_action('admin_enqueue_scripts', array($speedsense, 'load_css_js_admin'),-2147483647);
	require_once SPEEDSENSE_PLUGIN_DIR . 'welcome.php';
}
add_filter('plugin_action_links', array($speedsense, 'ads_plugin_links'),10,2);
add_action('admin_print_footer_scripts', array($speedsense, 'ads_head_java'));
add_filter('the_content', array($speedsense, 'process_content'));
add_action('wp_head', array($speedsense, 'ads_async_init'),-2147483647);
require_once SS_PLUGIN_DIR . 'speed-sense-widget.php';
add_action('widgets_init', array($speedsense, 'ss_load_widgets'));
?>
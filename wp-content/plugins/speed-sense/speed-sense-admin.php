<?php
    $frmt=['-','970x250','970x90','728x90','468x60','336x280','320x100','320x50','300x1050','300x600','300x250','250x250','234x60','200x200','180x150','160x600','125x125','120x600','120x240','responsive'];
	$ra4 = $this->opt['BegnRnd'];//new
	$rm4 = $this->opt['MiddRnd'];//new
	$rb4 = $this->opt['EndiRnd'];//new
	$rr4 = $this->opt['MoreRnd'];//new
	$rp4 = $this->opt['LapaRnd'];//new	
	$rc = 3;
	for ($j=1;$j<=$rc;$j++) {
		$rc5[$j] = $this->opt['Par'.$j.'Rnd'];//new
		$rc6[$j] = $this->opt['Par'.$j.'Nup'];//new
	}
	$rd5 = $this->opt['Img1Rnd'];//new
	$rd6 = $this->opt['Img1Nup'];//new
	if($this->opt['gen_dataslot']=='') {
		$step=1;
	}else if(($this->opt['AppPage']==0)&&($this->opt['AppPost']==0)&&($this->opt['AppHome']==0)&&($this->opt['AppCate']==0)&&($this->opt['AppArch']==0)&&($this->opt['AppTags']==0)){
		$step=2;
	}else if($this->opt['ad']==1){
		$step=3;
	}else{
		$step=4;
	}
?>
<script type="text/javascript">
	function selectinfo(ts) {
		if (ts.selectedIndex == 0) { return; }
		cek = new Array(
			document.getElementById('BegnRnd'),
			document.getElementById('MiddRnd'),
			document.getElementById('EndiRnd'),
			document.getElementById('MoreRnd'),
			document.getElementById('LapaRnd'),				
			document.getElementById('Par1Rnd'),
			document.getElementById('Par2Rnd'),
			document.getElementById('Par3Rnd'),
			document.getElementById('Img1Rnd') );
		for (i=0;i<cek.length;i++) {
			if (ts != cek[i] && ts.selectedIndex == cek[i].selectedIndex) {
				cek[i].selectedIndex = 0;
			}
		}
	}
	function selectmultipleformat() {
        var ts=jQuery('#multiple_format');
		if (ts.val() == 'responsive') {
            jQuery('#multiple_responsive_section').show();
        }else{
            jQuery('#multiple_responsive_section').hide();
        }
	}
	function showhidemultiplepost() {
		if ((jQuery('#AppHome').is(':checked')) || (jQuery('#AppCate').is(':checked')) || (jQuery('#AppArch').is(':checked')) || (jQuery('#AppTags').is(':checked'))) {
            jQuery('#multipletab').show();
        }else{
            jQuery('#multipletab').hide();
        }
	}
	function showhidesinglepost() {
		if ((jQuery('#AppPost').is(':checked')) || (jQuery('#AppPage').is(':checked')) ) {
            jQuery('#singletab').show();
        }else{
            jQuery('#singletab').hide();
        }
	}
	function selectsingleformat(n) {
        var ts=jQuery('#AdsFrmt'+n);
		if (ts.val() == 'responsive') {
            jQuery('#single_responsive_section'+n).show();
        }else{
            jQuery('#single_responsive_section'+n).hide();
        }
	}
	function checkinfo1(selnme,ts) {
		document.getElementById(selnme).disabled=!ts.checked;
	}
	function checkinfo2(ts,selnm1,selnm2,selnm3,selnm4) {
		if(selnm1){document.getElementById(selnm1).disabled=!ts.checked};
		if(selnm2){document.getElementById(selnm2).disabled=!ts.checked};		
		if(selnm3){document.getElementById(selnm3).disabled=!ts.checked};		
	}	
	function deftcheckinfo() {
		checkinfo1('BegnRnd',document.getElementById('BegnAds'));
		checkinfo1('MiddRnd',document.getElementById('MiddAds'));
		checkinfo1('EndiRnd',document.getElementById('EndiAds'));
		checkinfo1('MoreRnd',document.getElementById('MoreAds'));
		checkinfo1('LapaRnd',document.getElementById('LapaAds'));		
		for (i=1;i<=3;i++) {
			checkinfo2(document.getElementById('Par'+i+'Ads'),'Par'+i+'Rnd','Par'+i+'Nup','Par'+i+'Con');		
		}	
		checkinfo2(document.getElementById('Img1Ads'),'Img1Rnd','Img1Nup','Img1Con');				
	}	
</script>

<div class="adminpage" style="background-color: inherit;">

<form method="post" id="config-form" action="options.php">
<?php
	settings_fields('ss-options'); //settings group name
?>
<h2>Speed Sense <?php _e('Settings'); ?> <span style="font-size:9pt;font-style:italic">( Version <?php echo($this->opt['version']) ?> )</span></h2>
<div class="wrap" data-ng-app="dynamic-grid">

<?php if($step>1){ ?>
  <!-- Nav tabs -->
  <ul class="nav nav-pills" role="tablist">
    <li role="presentation"><a id="tab_general" href="#general" aria-controls="home" role="tab" data-toggle="tab">General</a></li>
    <li role="presentation" id="multipletab"><a href="#multiple" aria-controls="multiple" role="tab" data-toggle="tab">Multiple Posts</a></li>
    <li role="presentation" id="singletab"><a href="#single" aria-controls="single" role="tab" data-toggle="tab">Single Post</a></li>
	<?php if($step==3) { ?>
    <li role="presentation"><a class="btn-info" href="#banner1" role="tab" data-toggle="tab">Ban Protector</a></li>
    <li role="presentation"><a class="btn-success" href="#banner2" role="tab" data-toggle="tab">Anti AdBlock</a></li>
	<?php } ?>
	<?php if($step>2) { ?>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Other Settings</a></li>
	<?php } ?>
  </ul>
<?php } ?>

  <!-- Tab panes -->
  <div class="tab-content">


      
    <div role="tabpanel" class="tab-pane active" id="general">
		<div class="input-group control-group help" style="display: none;">
			<a href="#" onclick="jQuery('.help').toggle(); return false;">
				<img src="<?php echo WP_PLUGIN_URL . '/' . speedsense::$dir ?>/css/help.responsive.png" style="margin-right: 12px;float: left" />		
			</a>
		</div>
	<?php if($step==1){ ?>
        <h4><?php _e('Paste the "Automatic size Responsive" code from your adsense account'); ?></h4>
		<span class="description" style="display:block;font-style:italic;padding-top:10px"><a href="#" onclick="jQuery('.help').toggle(); return false;"><?php _e('Click here'); ?></a> <?php _e('for view the instructions'); ?></span><br/>
		<div class="input-group control-group">
			<span class="input-group-addon" for="name">Ad code</span>
			<textarea cols="100" rows="14" id="adcode" placeholder='<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Automatic size Responsive -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-xxxxxxxxxxxxxxxx"
     data-ad-slot="1234567890"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>'></textarea>
		</div>
        <br>
		<h4><?php _e('Or, write only data-ad-client and data-ad-slot'); ?></h4>
	<?php } ?>
		<div class="input-group control-group">
			<span class="input-group-addon" id="basic-addon1">Adsense Publisher ID</span>
			<input type="number" class="form-control" name="speedsense[gen_id]" id="gen_id" placeholder="Only Numbers" aria-describedby="basic-addon1" value = "<?php echo htmlentities($this->opt['gen_id']); ?>" maxlength="16">
			<span class="input-group-addon" for="name">
				<a target="_blank" href="//support.google.com/adsense/answer/105516">Help</a>
			</span>
		</div>
        <br>
		<div class="input-group control-group">
			<span class="input-group-addon" for="name">Adsense Data Ad Slot</span>
			<input type="number" class="form-control" name="speedsense[gen_dataslot]" id="gen_dataslot" placeholder="Only Numbers" value = "<?php echo htmlentities($this->opt['gen_dataslot']); ?>" maxlength="10">
			<span class="input-group-addon" for="name">
				<a target="_blank" href="//support.google.com/adsense/answer/3221666">Help</a>
			</span>
		</div>
        <br>
		
		
		
		
		
		<?php if($step>1){ ?>
        <br>
        <h3><?php _e('Where do you want to show ads?'); ?></h3>
		<div class="input-group">
			<span>[ </span>
			<input name="speedsense[AppPost]" type="checkbox" onchange="showhidesinglepost()" id="AppPost" value="1" <?php checked('1', $this->opt['AppPost']); ?> /> <?php _e('Posts'); ?>
			<input name="speedsense[AppPage]" type="checkbox" onchange="showhidesinglepost()" id="AppPage" value="1" <?php checked('1', $this->opt['AppPage']); ?> /> <?php _e('Pages'); ?>
			<span> ]</span><br/>
		</div>
		<br>
		<div class="input-group">
			<span>[ </span>
			<input name="speedsense[AppHome]" type="checkbox" onchange="showhidemultiplepost()" id="AppHome" value="1" <?php checked('1', $this->opt['AppHome']); ?> /> <?php _e('Homepage'); ?>
			<input name="speedsense[AppCate]" type="checkbox" onchange="showhidemultiplepost()" id="AppCate" value="1" <?php checked('1', $this->opt['AppCate']); ?> /> <?php _e('Categories'); ?>
			<input name="speedsense[AppArch]" type="checkbox" onchange="showhidemultiplepost()" id="AppArch" value="1" <?php checked('1', $this->opt['AppArch']); ?> /> <?php _e('Archives'); ?>
			<input name="speedsense[AppTags]" type="checkbox" onchange="showhidemultiplepost()" id="AppTags" value="1" <?php checked('1', $this->opt['AppTags']); ?> /> <?php _e('Tags'); ?>
			<span> ]</span><br/>
		</div>
		<br>
		<div class="input-group">
				<span>[ </span>
				<input name="speedsense[AppSide]" type="checkbox" id="AppSide" value="1" <?php checked('1', $this->opt['AppSide']); ?> /> <?php _e('Disable AdsWidget on Homepage'); ?>
				<span> ]</span><br/>
				<br/>
		</div>
		<div class="input-group">
				<span>[ </span>
				<input name="speedsense[AppLogg]" type="checkbox" id="AppLogg" value="1" <?php checked('1', $this->opt['AppLogg']); ?> /> <?php _e('Hide ads on my PC (protection against accidental clicks)'); ?>
				<span> ]</span><br/>
				<br/>
		</div>
		<br>
		<span class="description" style="display:block;font-style:italic;padding-top:10px"><?php echo sprintf( __( 'You can also insert ads into sidebar. Go into <a target = "_blank" href="%s" target="_self">' . __('Appearance') . '->' . __('Widgets') . '</a> and drag the ADSENSE SPEED SENSE widget into place.', 'adsense-speed-sense' ), admin_url() . 'widgets.php' ); ?></span><br/>
		<?php } ?>
    </div>















    
    <div role="tabpanel" class="tab-pane" id="single">
        <br>
        <div class="input-group">
			<input type="checkbox" id="BegnAds" name="speedsense[BegnAds]" value="1" <?php checked('1', $this->opt['BegnAds']); ?> onchange="checkinfo1('BegnRnd',this)" /> <?php _e('Assign') ; ?>
			<select id="BegnRnd" name="speedsense[BegnRnd]" onchange="selectinfo(this)">
					<?php for ($i=0;$i<=speedsense::$Ads;$i++) { ?>
						<option id="OptBegn<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($ra4==(string)$i){echo('selected');} ?>><?php _e(($i==0)?'Random Ads':'Ads'.$i) ; ?></option>
					<?php } ?></select> <?php _e('to <b>Beginning of Post</b>') ?><br/>
        </div>
        <br>
        <div class="input-group">
			<input type="checkbox" id="MiddAds" name="speedsense[MiddAds]" value="1" <?php checked('1', $this->opt['MiddAds']); ?> onchange="checkinfo1('MiddRnd',this)" /> <?php _e('Assign') ; ?>
			<select id="MiddRnd" name="speedsense[MiddRnd]" onchange="selectinfo(this)">
					<?php for ($i=0;$i<=speedsense::$Ads;$i++) { ?>
						<option id="OptMidd<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rm4==(string)$i){echo('selected');} ?>><?php _e(($i==0)?'Random Ads':'Ads'.$i) ; ?></option>
					<?php } ?></select> <?php _e('to <b>Middle of Post</b>') ?><br/>					
        </div>
        <br>
        <div class="input-group">
				<input type="checkbox" id="EndiAds" name="speedsense[EndiAds]" value="1" <?php checked('1', $this->opt['EndiAds']); ?> onchange="checkinfo1('EndiRnd',this)" /> <?php _e('Assign') ; ?>
				<select id="EndiRnd" name="speedsense[EndiRnd]" onchange="selectinfo(this)">
					<?php for ($i=0;$i<=speedsense::$Ads;$i++) { ?>
						<option id="OptEndi<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rb4==(string)$i){echo('selected');} ?>><?php _e(($i==0)?'Random Ads':'Ads'.$i) ; ?></option>
					<?php } ?></select> <?php _e('to <b>End of Post</b>') ?><br/> 
        </div>
        <br>
        <div class="input-group">
				<input type="checkbox" id="MoreAds" name="speedsense[MoreAds]" value="1" <?php checked('1', $this->opt['MoreAds']); ?> onchange="checkinfo1('MoreRnd',this)" /> <?php _e('Assign') ; ?>
				<select id="MoreRnd" name="speedsense[MoreRnd]" onchange="selectinfo(this)">
					<?php for ($i=0;$i<=speedsense::$Ads;$i++) { ?>
						<option id="OptMore<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rr4==(string)$i){echo('selected');} ?>><?php _e(($i==0)?'Random Ads':'Ads'.$i) ; ?></option>
					<?php } ?></select> <?php _e('right after <b>the') ?> <span style="font-family:Courier New,Courier,Fixed;">&lt;!--more--&gt;</span> <?php _e('tag') ?></b><br/> 					
        </div>
        <br>
        <div class="input-group">
			<input type="checkbox" id="LapaAds" name="speedsense[LapaAds]" value="1" <?php checked('1', $this->opt['LapaAds']); ?> onchange="checkinfo1('LapaRnd',this)" /> <?php _e('Assign') ; ?>
			<select id="LapaRnd" name="speedsense[LapaRnd]" onchange="selectinfo(this)">
			<?php for ($i=0;$i<=speedsense::$Ads;$i++) { ?>
				<option id="OptLapa<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rp4==(string)$i){echo('selected');} ?>><?php _e(($i==0)?'Random Ads':'Ads'.$i) ; ?></option>
			<?php } ?></select> <?php _e('right before <b>the last Paragraph</b>') ?><br/> 
        </div>
		<?php for ($j=1;$j<=$rc;$j++) { ?><br>
        <div class="input-group">
			<input type="checkbox" id="Par<?php echo $j; ?>Ads" name="speedsense[Par<?php echo $j; ?>Ads]" value="1" <?php checked('1', $this->opt['Par' . $j . 'Ads']); ?> onchange="checkinfo2(this,'Par<?php echo $j; ?>Rnd','Par<?php echo $j; ?>Nup','Par<?php echo $j; ?>Con')" /> <?php _e('Assign') ; ?>
			<select id="Par<?php echo $j; ?>Rnd" name="speedsense[Par<?php echo $j; ?>Rnd]" onchange="selectinfo(this)">
			<?php for ($i=0;$i<=speedsense::$Ads;$i++) { ?>
				<option id="OptPar<?php echo $j; ?><?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rc5[$j]==(string)$i){echo('selected');} ?>><?php _e(($i==0)?'Random Ads':'Ads'.$i) ; ?></option>
			<?php } ?></select> <?php _e('<b>After Paragraph</b> ') ?>
			<select id="Par<?php echo $j; ?>Nup" name="speedsense[Par<?php echo $j; ?>Nup]">
				<?php for ($i=1;$i<=50;$i++) { ?>
					<option id="Opt<?php echo $j; ?>Nu<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rc6[$j]==(string)$i){echo('selected');} ?>><?php echo $i; ?></option>
				<?php } ?></select> &rarr; 
			<input type="checkbox" id="Par<?php echo $j; ?>Con" name="speedsense[Par<?php echo $j; ?>Con]" value="1" <?php checked('1', $this->opt['Par' . $j . 'Con']); ?> /> <?php _e('or to <b>End of Post</b> if fewer paragraphs are found.') ; ?><br/>
        </div>
		<?php } ?>
        <br>
        <div class="input-group">
			<input type="checkbox" id="Img1Ads" name="speedsense[Img1Ads]" value="1" <?php checked('1', $this->opt['Img1Ads']); ?> onchange="checkinfo2(this,'Img1Rnd','Img1Nup','Img1Con')" /> <?php _e('Assign') ; ?>
			<select id="Img1Rnd" name="speedsense[Img1Rnd]" onchange="selectinfo(this)">
			<?php for ($i=0;$i<=speedsense::$Ads;$i++) { ?>
				<option id="OptImg1<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rd5==(string)$i){echo('selected');} ?>><?php _e(($i==0)?'Random Ads':'Ads'.$i) ; ?></option>
			<?php } ?></select> <?php _e('<b>After Image</b> ') ?>
			<select id="Img1Nup" name="speedsense[Img1Nup]">
			<?php for ($i=1;$i<=50;$i++) { ?>
				<option id="Opt1Im<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if($rd6==(string)$i){echo('selected');} ?>><?php echo $i; ?></option>
			<?php } ?></select> &rarr; 
			<input type="checkbox" id="Img1Con" name="speedsense[Img1Con]" value="1" <?php checked('1', $this->opt['Img1Con']); ?> /> <?php _e('after <b>Image&#39;s outer</b>'); ?>
			<b><span style="font-family:Courier New,Courier,Fixed;"> &lt;div&gt; wp-caption</span></b> if any.<span style="color:#a00;"> <b>(New)</b></span><br/>
        </div>
		<br/>
		<script type="text/javascript">deftcheckinfo();</script>
        <h3>Ads</h3>
        <hr/>
        <div class="col-xs-1" style="width: 100px;"> <!-- required for floating -->
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tabs-left">
<?php for ($i=1;$i<=speedsense::$Ads;$i++) {
?>
			<li
<?php if($i==1){ ?>
            class="active"
<?php } ?>
                ><a href="#sads<?php echo $i; ?>" data-toggle="tab">Ads<?php echo $i; ?></a></li>
<?php } ?>
          </ul>
        </div>

        <div style="width: calc(100% - 120px); float: left;">
          <!-- Tab panes -->
          <div class="tab-content">
              
              
              
            
            
        <?php for ($i=1;$i<=speedsense::$Ads;$i++) {
            $cod = $this->opt['AdsCode'.$i];
            $agn = $this->opt['AdsAlign'.$i];
            $fmt = $this->opt['AdsFrmt'.$i];
            $mar = $this->opt['AdsMargin'.$i];
		?>
			<div class="tab-pane
		<?php
            if($i==1){
		?>
            active" id="sads<?php echo $i; ?>">
<?php
            }else{
?>
            " id="sads<?php echo $i; ?>">
<?php   
            }
?>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <label for="margin_leadin"><?php _e('Margin') ?>:</label><br>
                        <input type="number" style="width: 60px;" id="AdsMargin<?php echo $i; ?>" name="speedsense[AdsMargin<?php echo $i; ?>]" value="<?php echo stripslashes(htmlspecialchars($mar)); ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="margin_leadin"><?php _e('Align') ?>:</label><br/>
                        <select name="speedsense[AdsAlign<?php echo $i; ?>]">
                            <option id="OptAgn<?php echo $i; ?>1" value="1" <?php if($agn=="1"){echo('selected');} ?>><?php _e('Left') ; ?></option>
                            <option id="OptAgn<?php echo $i; ?>2" value="2" <?php if($agn=="2"){echo('selected');} ?>><?php _e('Center') ; ?></option>
                            <option id="OptAgn<?php echo $i; ?>3" value="3" <?php if($agn=="3"){echo('selected');} ?>><?php _e('Right') ; ?></option>
                            <option id="OptAgn<?php echo $i; ?>4" value="4" <?php if($agn=="4"){echo('selected');} ?>><?php _e('None') ; ?></option>
                            <option id="OptAgn<?php echo $i; ?>5" value="5" <?php if($agn=="5"){echo('selected');} ?>><?php _e('Left, separated') ; ?></option>
                            <option id="OptAgn<?php echo $i; ?>6" value="6" <?php if($agn=="6"){echo('selected');} ?>><?php _e('Right, separated') ; ?></option>
                        </select>        
                    </div>
                    <div class="col-md-2">
                        <label for="margin_leadin"><?php _e('Format') ?>:</label>
                        <select id="AdsFrmt<?php echo $i; ?>" name="speedsense[AdsFrmt<?php echo $i; ?>]" class="form-control" onchange="selectsingleformat(<?php echo $i; ?>)">
                        <?php
                        for ($ii=0;$ii<count($frmt);$ii++) {
                            if($fmt==$frmt[$ii]){
                                echo('<option value="' . $frmt[$ii] . '" selected>' . $frmt[$ii] . '</option>');
                            }else{
                                echo('<option value="' . $frmt[$ii] . '">' . $frmt[$ii] . '</option>');
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <br />
            
                <div id="single_responsive_section<?php echo $i; ?>">
                    <h3 class="label-primary" style="color:white;border-radius: 2px;text-align: center;"><?php _e('Ad Responsive Settings'); ?></h3>
                    <div class="dyn_resp">
                        <div data-dynamic-grid="AdsCode<?php echo $i; ?>" data-grid-value='<?php echo $cod; ?>'></div>
                    </div>
                </div>
            </div>
        <?php } ?>	
            
          </div>
        </div>

        <div class="clearfix"></div>


        
    </div>













      
    <div role="tabpanel" class="tab-pane" id="multiple">
        <br>
        <div class="row">
            <div class="col-md-3">
                <label for="margin_leadin"><?php _e('Position') ?>:</label>
                <select id="multiple_position" name="speedsense[multiple_position]" class="form-control">
                <?php
                $opt=["top"=>"At the beginning of each post","middle"=>"In the middle of each post","bottom"=>"At the end of each post"];
                foreach ($opt as $key => $value){
                    if($this->opt['multiple_position']==$key){
                        echo('<option value="' . $key . '" selected>' . __($value) . '</option>');
                    }else{
                        echo('<option value="' . $key . '">' . __($value) . '</option>');
                    }
                }
                ?>
                </select>
                
                        
            </div>
<?php
$i=0;
            $cod = $this->opt['AdsCode'.$i];
            $agn = $this->opt['AdsAlign'.$i];
            $fmt = $this->opt['AdsFrmt'.$i];
            $mar = $this->opt['AdsMargin'.$i];
?>
			<div class="col-md-1">
				<label for="margin_leadin"><?php _e('Margin') ?>:</label><br>
				<input type="number" style="width: 60px;" id="AdsMargin<?php echo $i; ?>" name="speedsense[AdsMargin<?php echo $i; ?>]" value="<?php echo stripslashes(htmlspecialchars($mar)); ?>">
			</div>
			<div class="col-md-2">
				<label for="margin_leadin"><?php _e('Align') ?>:</label><br/>
				<select name="speedsense[AdsAlign<?php echo $i; ?>]">
					<option id="OptAgn<?php echo $i; ?>1" value="1" <?php if($agn=="1"){echo('selected');} ?>><?php _e('Left') ; ?></option>
					<option id="OptAgn<?php echo $i; ?>2" value="2" <?php if($agn=="2"){echo('selected');} ?>><?php _e('Center') ; ?></option>
					<option id="OptAgn<?php echo $i; ?>3" value="3" <?php if($agn=="3"){echo('selected');} ?>><?php _e('Right') ; ?></option>
					<option id="OptAgn<?php echo $i; ?>4" value="4" <?php if($agn=="4"){echo('selected');} ?>><?php _e('None') ; ?></option>
					<option id="OptAgn<?php echo $i; ?>5" value="5" <?php if($agn=="5"){echo('selected');} ?>><?php _e('Left, separated') ; ?></option>
					<option id="OptAgn<?php echo $i; ?>6" value="6" <?php if($agn=="6"){echo('selected');} ?>><?php _e('Right, separated') ; ?></option>
				</select>        
			</div>
			<div class="col-md-2">
				<label for="margin_leadin"><?php _e('Format') ?>:</label>
				<select id="AdsFrmt<?php echo $i; ?>" name="speedsense[AdsFrmt<?php echo $i; ?>]" class="form-control" onchange="selectsingleformat(<?php echo $i; ?>)">
				<?php
				for ($ii=0;$ii<count($frmt);$ii++) {
					if($fmt==$frmt[$ii]){
						echo('<option value="' . $frmt[$ii] . '" selected>' . $frmt[$ii] . '</option>');
					}else{
						echo('<option value="' . $frmt[$ii] . '">' . $frmt[$ii] . '</option>');
					}
				}
				?>
				</select>
			</div>
        </div>
        <br />
		<div id="single_responsive_section<?php echo $i; ?>">
			<h3 class="label-primary" style="color:white;border-radius: 2px;text-align: center;"><?php _e('Ad Responsive Settings'); ?></h3>
			<div class="dyn_resp">
				<div data-dynamic-grid="speedsense[AdsCode<?php echo $i; ?>]" data-grid-value='<?php echo $cod; ?>'></div>
			</div>
		</div>
    </div>






    
    
    <div role="tabpanel" class="tab-pane active" id="banner1">
		<div class="banner" style="display: none">
			<h3><?php _e('Ban Protector'); ?>:</h3>
			<p>
				<img src="<?php echo WP_PLUGIN_URL . '/' . speedsense::$dir ?>/css/shield.png" style="margin-right: 12px;float: left" />
				As per a recent published adsense statistics repost, almost 72% adsense account got disabled and banned due to invalid click activity reason. A group of students also done a research about the webmaster’s view and thought about their adsense account getting disabled due to invalid click activity. Most of the webmaster said that they neither clicked on their own ads nor provoked anyone to do so.<br/>
				<p>Today, you can prevent your AdSense account getting blocked due to invalid click activity using "all for adsense"</p>
				<p>All for Adsense is a free framework compatible with most of the plugins for Adsense.<br/>It extends the functionality of Adsense, adding protection against invalid clicks</p>
			<p>
			<p class="submit">
				<input class="btn btn-primary" type="submit" value="CLICK HERE FOR ENABLE IT" onclick="window.location.replace(window.location.href + '&amp;try=1'); return false;">
			</p>
		</div>
	</div>






    
    <div role="tabpanel" class="tab-pane active" id="banner2">
		<div class="banner" style="display: none">
			<h3><?php _e('Anti AdBlock'); ?>:</h3>
			<p>
				<img src="<?php echo WP_PLUGIN_URL . '/' . speedsense::$dir ?>/css/money.png" style="margin-right: 12px;float: left" />
				Did you know that 23% of surfers use adblock to block banner ads? This is a big problem for publishers, because they lose 23% of earnings.<br/>
				<p>Today, you can earn more, forcing the freeloaders to disable adblock using "all for adsense"</p>
				<p>All for Adsense is a free framework compatible with most of the plugins for Adsense.<br/>It extends the functionality of Adsense, adding protection against adblock</p>
			<p>
			<p class="submit">
				<input class="btn btn-primary" type="submit" value="CLICK HERE FOR ENABLE IT" onclick="window.location.replace(window.location.href + '&amp;try=1'); return false;">
			</p>
		</div>
	</div>










    
    
    
    <div role="tabpanel" class="tab-pane" id="settings">
        <table border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
            <td style="width:110px"><?php _e('Quicktag :'); ?></td>
            <td><span style="display:block;font-style:normal;padding-bottom:0px"><?php _e('Insert Ads into a post, on-the-fly :'); ?></span>
                    <ol style="margin-top:5px;">
                    <li><?php _e('Insert <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--Ads1--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--Ads2--&gt;</span>, etc. into a post to show the <b>Particular Ads</b> at specific location.'); ?></li>
                    <li><?php _e('Insert <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--RndAds--&gt;</span> (or more) into a post to show the <b>Random Ads</b> at specific location.'); ?></li>
                    </ol>
                    <span style="display:block;font-style:normal;padding-bottom:0px"><?php _e('Disable Ads in a post, on-the-fly :'); ?></span>
                    <ol style="margin-top:5px;">				
                    <li><?php _e('Insert <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffDef--&gt;</span> to <b>disable all Ads</b> in a post.'); ?><span class="description" style="font-style:italic"><?php _e(' (does not affect Ads on Sidebar)'); ?></span></li>
                    <li><?php _e('Insert <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--NoAds--&gt;</span> to <b>disable all Ads</b> in a post.'); ?><span class="description" style="font-style:italic"><?php _e(' (also affects Ads on Sidebar)'); ?></span></li>
                    <li><?php _e('Insert <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffBegin--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffMiddle--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffEnd--&gt;</span> to <b>disable Ads at Beginning, Middle</b> or <b>End of Post</b>.'); ?><span style="color:#a00;"> <b>(New)</b></span></li>								
                    <li><?php _e('Insert <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffAfMore--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffBfLastPara--&gt;</span> to <b>disable Ads right after the <span style="font-family:Courier New,Courier,Fixed;">&lt;!--more--&gt;</span> tag</b>, or <b>right before the last Paragraph</b>.'); ?><span style="color:#a00;"> <b>(New)</b></span></li>												
                    </ol>
                    [ <input type="checkbox" id="QckTags" name="speedsense[QckTags]" value="1" <?php checked('1', $this->opt['QckTags']); ?> /> <?php _e('Show Quicktag Buttons on the HTML Edit Post SubPanel'); ?> ]<br/>
                    [ <input type="checkbox" id="QckRnds" name="speedsense[QckRnds]" value="1" <?php checked('1', $this->opt['QckRnds']); ?> /> <?php _e('Hide <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--RndAds--&gt;</span> from Quicktag Buttons'); ?> ]<br/>
                    [ <input type="checkbox" id="QckOffs" name="speedsense[QckOffs]" value="1" <?php checked('1', $this->opt['QckOffs']); ?> /> <?php _e('Hide <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--NoAds--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffDef--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffWidget--&gt;</span> from Quicktag Buttons'); ?> ]<br/>
                    [ <input type="checkbox" id="QckOfPs" name="speedsense[QckOfPs]" value="1" <?php checked('1', $this->opt['QckOfPs']); ?> /> <?php _e('Hide <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffBegin--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffMiddle--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffEnd--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffAfMore--&gt;</span>, <span style="font-family:Courier New,Courier,Fixed;color:#050">&lt;!--OffBfLastPara--&gt;</span> from Quicktag Buttons'); ?> ]<br/>
                    <span class="description" style="display:block;font-style:italic;padding-top:10px"><?php _e('Tags can be inserted into a post via the additional Quicktag Buttons at the HTML Edit Post SubPanel.'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <td style="width:110px"><?php _e('Infomation :'); ?></td>
            <td>
                <span><?php echo(__(
                    'A link from your blog to <a href="https://wordpress.org/plugins/speed-sense/" target="_blank">https://wordpress.org/plugins/speed-sense/</a> would be appreciated.'
                )); ?></span>
            </td>	
        </tr>
        </table>
		
    </div>
    
    
    
    
    
    
    
  </div>

</div>









<script>
jQuery(document).ready(function () {
    (function($) {
		
    jQuery('#config-form').validate({
        rules: {
            "speedsense[gen_id]": {
                minlength: 16,
                maxlength: 16,
                required: true
            },
            "speedsense[gen_dataslot]": {
                minlength: 10,
                maxlength: 10,
                required: true
            }
        },
        highlight: function (element) {
            jQuery(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function (element) {
            element.text('').addClass('valid')
                .closest('.control-group').removeClass('error').addClass('success');
        }
    });
    
    //When tab change
    jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        selectmultipleformat();
        <?php for ($i=0;$i<=speedsense::$Ads;$i++) {
        echo 'selectsingleformat('.$i.');';
        }?>
        showhidemultiplepost();
        showhidesinglepost();
		
		var target = $(e.target).attr("href");
		if ((target == '#banner1')||(target == '#banner2')) {
			$('#save').hide();
			$('.banner').show();
		} else {
			$('#save').show();
			$('.banner').hide();
		}
		
    });    
    
	
	$('#adcode').bind('input propertychange', function() {
		var v = this.value;
	  console.log(v);
	  var n = v.indexOf('data-ad-client="');
	  if(n>-1){
		  $('#gen_id').val(v.substr(n+23,16));
	  }
	  n = v.indexOf('data-ad-slot="');
	  if(n>-1){
		  $('#gen_dataslot').val(v.substr(n+14,10));
	  }
	});
	
	
	
    jQuery('#tab_general').click();

	})(jQuery);   
});

</script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	






	<input type="hidden" name="action" value="update" />
	<div style="width:580px" id="save">
		<p class="submit">
		<?php if($step>2){ ?>
			<input class="btn btn-primary" type="submit" value="<?php _e('Save Changes') ?>"  onclick="jQuery('#tab_general').click(); return true;" />
		<?php }else{ ?>
			<input class="btn btn-primary" type="submit" value="<?php _e('Next') ?>" />
		<?php } ?>
		</p>
	</div>

</form>
<div class="alert alert-warning" role="alert">
<?php
echo sprintf( __( '<strong>If you like this plugin please do us a BIG favor and give us a 5 star rating <a href="%s" target="_blank">here</a> . If you`re not happy, please open a <a href="%2s" target="_blank">support ticket</a>, so that we can sort it out. Thank you!</strong>', 'quick-adsense-reloaded' ),
'https://wordpress.org/support/plugin/speed-sense/reviews/#new-post',
'https://wordpress.org/support/plugin/speed-sense'
);
?>
</div>
</div>
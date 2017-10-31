<?php
class speed_sense_widget extends WP_Widget {
  function __construct() {
    $widget_ops = array('classname' => 'speed_sense_widget', 'description' => 'Add Adsense to your sidebar.');
    parent::__construct('sswopt', 'Adsense Speed Sense', $widget_ops);
  }
  function widget($args, $instance) {
    extract($args, EXTR_SKIP);
    echo $before_widget;
	
	$cont = get_the_content();
	$speedsense = speedsense::getInstance();
	if( strpos($cont,"<!--NoAds-->")===false && strpos($cont,"<!--OffWidget-->")===false && !(is_home()&&($speedsense->opt['AppSide']==1))  ) {
		$title = apply_filters('widget_title', $instance['title']);
		$adtype = empty($instance['adtype']) ? '336x280' : apply_filters('widget_adtype', $instance['adtype']);
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}
		if ($adtype!='-') {
			$adscode = '<ins class="adsbygoogle" id="adsgoogle' . $adtype . '"';
			$dims = explode('x', $adtype);
			$width = $dims[0];
			$height = count($dims) > 1 ? $dims[1] : 0;
			$adscode .= ' style="display: inline-block; width: 100%; height: ' . $height . 'px" ';

			$style='max-width:' . $width . 'px;width:100%;';
			$adscode .= ' data-ad-client="ca-pub-' . $speedsense->opt['gen_id'] . '" data-ad-slot="' . $speedsense->opt['gen_dataslot'] . '"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
			$adscode = "\n".'<!-- '.speedsense::$QData['Name'].' Wordpress Plugin: '.speedsense::$QData['URI'].' -->'."\n".
				'<div id="ssp' . $adtype . '" style="'.$style.'">'."\n".
				$adscode."\n".
				'</div>'."\n";

			echo (html_entity_decode($adscode));
		}
	}
    echo $after_widget;
  }
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['adtype'] = strip_tags($new_instance['adtype']);
    return $instance;
  }
  function form($instance) {
    $instance = wp_parse_args((array) $instance, array('title' => '', 'adtype' => ''));
    $title = strip_tags($instance['title']);
    $adtype = strip_tags($instance['adtype']);
    ?>
<p>
  Title: <input class="widefat"
    name="<?php echo $this->get_field_name('title'); ?>" type="text"
    value="<?php echo esc_attr($title); ?>" />
</p>
<p>
  Format: <select name="<?php echo $this->get_field_name('adtype'); ?>" size="1" class="widefat">
<?php
$frmt=['300x1050','300x600','160x600','120x600','336x280','300x250','250x250','468x60','320x100','320x50','234x60','200x200','180x150','125x125','120x240','970x250','970x90','728x90'];
for ($ii=0;$ii<count($frmt);$ii++) {
	if($adtype==$frmt[$ii]){
		echo('<option value="' . $frmt[$ii] . '" selected>' . $frmt[$ii] . '</option>');
	}else{
		echo('<option value="' . $frmt[$ii] . '">' . $frmt[$ii] . '</option>');
	}
}
?>
  </select>
</p>
<?php
  }
}
?>
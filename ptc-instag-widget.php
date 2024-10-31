<?php
/*
Plugin Name: PTC Instagram Widget
Plugin URI: https://wordpress.org/plugins/ptc-instag-widget/
Description: PTC Instagram Widget - Display your InstaGram updates on website sidebar using PTC Instagram Widget.
Version: 1.0
Author: vivanjakes@gmail.com
Author URI: https://wordpress.org/support/profile/personaltrainercertification
*/
class ptcinstawgt_wid_section{
    
    public $options;
    
    public function __construct() {
        //you can run delete_option method to reset all data
        //delete_option('insGram_widget_options');
        $this->options = get_option('ptcinstawgt_wid_option_form');
        $this->ptcinstawgt_widget_register_fields_and_setting();
    }
    
    public static function add_ptcinstawgt_widgets_tools_options_page(){
        add_options_page('PTC Instagram Widget', 'PTC Instagram Widget ', 'administrator', __FILE__, array('ptcinstawgt_wid_section','sw_ptcinstawgt_widget_tools_options'));
    }
    
    public static function sw_ptcinstawgt_widget_tools_options(){
?>

<div class="bg">
  <h2 class="top-style">PTC Instagram Widget Setting</h2>
  <form method="post" action="options.php" enctype="multipart/form-data">
    <?php settings_fields('ptcinstawgt_wid_option_form'); ?>
    <?php do_settings_sections(__FILE__); ?>
    <p class="submit">
      <input name="submit" type="submit" class="button-success" value="Save Changes"/>
    </p>
  </form>
</div>
<?php
    }
    public function ptcinstawgt_widget_register_fields_and_setting(){
        register_setting('ptcinstawgt_wid_option_form', 'ptcinstawgt_wid_option_form',array($this,'ptcinstawgt_widget_validate_form_set'));
        add_settings_section('ptcinstawgt_widget_main_section', 'Settings', array($this,'ptcinstawgt_widget_main_cb_page_section'), __FILE__);
        //Start Creating Fields and Options
        //marginTop
        add_settings_field('marginTop', 'Margin Top', array($this,'marTop_section'), __FILE__,'ptcinstawgt_widget_main_section');
        //pageURL
        add_settings_field('pageURL', 'Instagram Widget ID', array($this,'page_url_section'), __FILE__,'ptcinstawgt_widget_main_section');
        //width
        add_settings_field('width', 'Width', array($this,'page_width_setion'), __FILE__,'ptcinstawgt_widget_main_section');
        //height
        add_settings_field('height', 'Height', array($this,'page_height_setion'), __FILE__,'ptcinstawgt_widget_main_section');
       
        //alignment option
         add_settings_field('alignment', 'Position', array($this,'page_position_section'),__FILE__,'ptcinstawgt_widget_main_section');
    }
    public function ptcinstawgt_widget_validate_form_set($plugin_options){
        return($plugin_options);
    }
    public function ptcinstawgt_widget_main_cb_page_section(){
        //optional
    }

   
    //marginTop_settings
    public function marTop_section() {
        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "110";
        echo "<input name='ptcinstawgt_wid_option_form[marginTop]' type='text' value='{$this->options['marginTop']}' />";
    }
    //pageURL_settings
    public function page_url_section() {
        if(empty($this->options['pageURL'])) $this->options['pageURL'] = "";
        echo "<input name='ptcinstawgt_wid_option_form[pageURL]' type='text' value='{$this->options['pageURL']}' />";
    }

    //width_settings
    public function page_width_setion() {
        if(empty($this->options['width'])) $this->options['width'] = "400";
        echo "<input name='ptcinstawgt_wid_option_form[width]' type='text' value='{$this->options['width']}' />";
    }
    //page_height_setion
    public function page_height_setion() {
        if(empty($this->options['height'])) $this->options['height'] = "400";
        echo "<input name='ptcinstawgt_wid_option_form[height]' type='text' value='{$this->options['height']}' />";
    }
   
  
   
    //alignment_settings
    public function page_position_section(){
        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";
        $items = array('left','right');
        echo "<select name='ptcinstawgt_wid_option_form[alignment]'>";
        foreach($items as $item){
            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }
    
}
add_action('admin_menu', 'ptcinstawgt_widget_form_options');

function ptcinstawgt_widget_form_options(){
    ptcinstawgt_wid_section::add_ptcinstawgt_widgets_tools_options_page();
}

add_action('admin_init','ptcinstawgt_widget_form_object');
function ptcinstawgt_widget_form_object(){
    new ptcinstawgt_wid_section();
}
add_action('wp_footer','ptcinstawgt_widget_add_content_in_page_footer');
function ptcinstawgt_widget_add_content_in_page_footer(){
    
    $o = get_option('ptcinstawgt_wid_option_form');
    extract($o);

$print_instagram = '';
$print_instagram .= '<iframe src="http://widgets-code.websta.me/w/'.$pageURL.'?ck=MjAxNi0wNi0yMFQwODo0MjoxNy4wMDBa" allowtransparency="true" frameborder="0"
 scrolling="no" style="border:none;overflow:hidden; width:'.$width.'px; height:'.$height.'px" ></iframe>';

$imgURL = plugins_url('assets/instagram-icon.png', __FILE__ );


?>
<?php if($alignment=='left'){?>
<div id="insGram_widget_display">
  <div id="insGram1" class="ilnk_area_left">
  <a class="open" id="ilink" href="javascript:;"><img style="top: 0px;right:-37px;" src="<?php echo $imgURL;?>" alt=""></a>
    <div id="insGram2" class="ilink_inner_area_left" >
    <?php echo $print_instagram; ?>
     
    </div>
     <div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: left; direction: ltr;padding:3px 3px 0px; position:absolute;bottom:0px;left:0px;"><a href="https://www.nationalcprassociation.com/" target="_blank" style="color: #808080;">nationalcprassociation.com</a></div> 
    
  </div>
 
</div>

<style type="text/css">
        
        div.ilnk_area_left{        
            left: -<?php echo trim($width+10);?>px;         
            top: <?php echo $marginTop;?>px;         
            z-index: 10000; height:<?php echo trim($height+30);?>px;        
            -webkit-transition: all .5s ease-in-out;        
            -moz-transition: all .5s ease-in-out;        
            -o-transition: all .5s ease-in-out;        
            transition: all .5s ease-in-out;        
            }
        
        div.ilnk_area_left.showdiv{        
            left:0;
        
            }	
        
        div.ilink_inner_area_left{        
            text-align: left;        
            width:<?php echo trim($width);?>px;        
            height:<?php echo trim($height);?>px;        
            }
        
        
        </style>

<?php } else { ?>
<div id="insGram_widget_display">
  <div id="insGram1" class="ilnk_area_right">
  <a class="open" id="ilink" href="javascript:;"><img style="top: 0px;left:-37px;" src="<?php echo $imgURL;?>" alt=""></a>
    <div id="insGram2" class="link_inner_area_right">
      <?php echo $print_instagram; ?>
      
    </div>
    <div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;padding:3px 3px 0px;position:absolute;bottom:0px;right:0px;"><a href="https://www.nationalcprassociation.com/" target="_blank" style="color: #808080;">nationalcprassociation.com</a></div> 
  </div>
</div>
<style type="text/css">
        
        div.ilnk_area_right{ right: -<?php echo trim($width+10);?>px;top: <?php echo $marginTop;?>px; z-index: 10000;height:<?php echo trim($height+30);?>px; -webkit-transition: all .5s ease-in-out;  -moz-transition: all .5s ease-in-out; -o-transition: all .5s ease-in-out; transition: all .5s ease-in-out; }
        
        div.ilnk_area_right.showdiv{ right:0; }	
        
        div.link_inner_area_right{ text-align: left;        
            width:<?php echo trim($width);?>px;
            height:<?php echo trim($height);?>px;
        
            }
        
        div.ilnk_area_right .contacticonlink {	        
            left: -32px;        
            text-align: left;        
        }		
        
        </style>
<?php } ?>
 <script type="text/javascript">
        
        jQuery(document).ready(function() {
            jQuery('#ilink').click(function(){
                jQuery(this).parent().toggleClass('showdiv');
        
        });});
        </script>
<?php
}
add_action( 'wp_enqueue_scripts', 'register_ptcinstawgt_widget_form_styles' );
add_action( 'admin_enqueue_scripts', 'register_ptcinstawgt_widget_form_styles' );
 function register_ptcinstawgt_widget_form_styles() {
    wp_register_style( 'ptcinstawgt_widget_styles', plugins_url( 'assets/instagram_main.css' , __FILE__ ) );
    wp_enqueue_style( 'ptcinstawgt_widget_styles' );
        wp_enqueue_script('jquery');
 }
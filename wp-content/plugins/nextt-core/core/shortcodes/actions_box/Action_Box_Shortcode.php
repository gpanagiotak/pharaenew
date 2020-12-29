<?php


/**
 * Class Action_Box_Shortcode
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Action_Box_Shortcode{

    /**
     * The shortcode path css file
     * @var string
     */
    private $shortcode_action_box_css;

    /**
     * The shortcode path javascript file
     * @var string
     */
    private $shortcode_action_box_js;

    /**
     * Initialize the class
     */
    function __construct(){
        $this->shortcode_action_box_css = '/core/shortcodes/actions_box/action_box.css';
        $this->shortcode_action_box_js = '/core/shortcodes/actions_box/action_box.js';
        $this->actions();
    }

    /**
     * Call all action and register them into wordpress
     */
    public function actions(){
        add_shortcode( 'activebox', array($this,'activebox') );
        add_shortcode( 'activebox_maker', array($this,'activebox_maker') );
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_style_action_box'), 10, 1);
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_script_action_box'));
    }

    /**
     * Include the css style
     */
    public function enqueue_style_action_box(){
        wp_enqueue_style( 'action-box-shortcode-css', return_the_path($this->shortcode_action_box_css) );
    }


    /**
     * Inlcude the javascript script
     */
    public function enqueue_script_action_box(){
        wp_enqueue_script( 'action-box-shortcode-js', return_the_path($this->shortcode_action_box_js), array(), '1.0.0', true );
    }


    /**
     * Create a sample box without the col-md
     * @param $attr
     * @param $content
     * @return string
     */
    public function activebox($attr, $content){
        $html = '<div class="sc_active_box">
                <div class="sc_home_our_story" img="'.$attr['img'].'" style="height:'.$attr['height'].'; background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('.$attr['img'].') no-repeat center center;  background-size: cover;">
                    <div class="sc_active_box_image">
                        <div class="sc_active_box_text">'.$attr['title'].'</div>
                    </div>
                    <div class="sc_active_box_content" link="'.$attr['link'].'">
                        <h2>'.$attr['title'].'</h2>
                        <p>'.$attr['content'].'</p>
                    </div>
                </div>
            </div>';
        return $html;
    }

    /**
     * Create box with call md
     * @param $attr
     * @param $content
     * @return string
     */
    public function activebox_maker($attr, $content){
        $sortcode = do_shortcode('[activebox img="'.$attr['img'].'" height="'.$attr['height'].'" title="'.$attr['title'].'" link="'.$attr['link'].'" content="'.$attr['content'].'"]');
        if($attr['first']=='true'){
            $html = '<div class="col-md-'.$attr['out_col'].'" style="padding:0"><div class="padding_col col-md-'.$attr['col_size'].'" >'.$sortcode.'</div>';
        }else if($attr['last'] == 'true'){
            $html = '<div class="padding_col col-md-'.$attr['col_size'].'">'.$sortcode.'</div></div>';
        }else{
            $html = '<div class="padding_col col-md-'.$attr['col_size'].'">'.$sortcode.'</div>';
        }
        return $html;
    }
}
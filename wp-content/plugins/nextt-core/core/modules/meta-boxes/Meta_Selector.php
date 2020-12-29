<?php


/**
 * Class Meta_Selector
 *
 * This class contains all metaboxes type classes
 *
 * included to Meta_Box_Generator
 *
 * if you want to add a new metabox use:
 * $this->define_meta_box_type(new You_Meta_Class()); into actions method
 *
 */
class Meta_Selector{

    /**
     * The Array of meta classes. We store each object of class into this array, latter in generator we will pass all the
     * data to find which is the right meta class according to meta class get_type() method
     * @var
     */
    private $meta_boxes_types;

    /**
     * The Constructor
     */
    function __construct(){
        $this->actions();
    }

    /**
     * Add all meta classes into $meta_boxes_types array
     */
    public function actions(){
        $this->define_meta_box_type(new Text_Meta());
        $this->define_meta_box_type(new Color_Meta());
        $this->define_meta_box_type(new Image_Meta());
        $this->define_meta_box_type(new Radio_Meta());
        $this->define_meta_box_type(new Select_Meta());
        $this->define_meta_box_type(new Checkbox_Meta());
        $this->define_meta_box_type(new Textarea_Meta());
    }

    public function meta_settings($type, $array_id){
        if($type == 'image'){
            $this->generator($type, $type)->actions($array_id);
        }
    }

    /**
     * Get the value of the right meta from generator method and then call the method display()
     * (cause we are in display_selector)
     * @param $type
     * @param $current_meta
     * @param $prfx_stored_meta
     * @return mixed
     */
    public function display_selector($type, $current_meta, $prfx_stored_meta){
        return $this->generator($type)->display($current_meta, $prfx_stored_meta);
    }

    /**
     * Get the value of the right meta from generator method and then call the method store()
     * (cause we are in store_selector)
     * @param $type
     * @param $current_meta
     * @param $post_id
     * @return mixed
     */
    public function store_selector($type, $current_meta, $post_id){
        return $this->generator($type)->store($current_meta, $post_id);
    }

    /**
     * We store each object of class into this array, latter in generator we will pass all the
     * data to find which is the right meta class according to meta class get_type() method
     * @param $type
     * @return mixed
     */
    private function generator($type){
        foreach($this->meta_boxes_types as $meta){
            if($meta->get_type() == $type){
                return $meta;
            }
        }
    }

    /**
     * Push the array of metas classes
     * @param $meta_object
     */
    private function define_meta_box_type($meta_object){
        $this->meta_boxes_types[] = $meta_object;
    }

}
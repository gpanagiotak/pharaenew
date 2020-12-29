<?php

/**
 * Class Popup
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Popup{

	/**
	 * Initialize the object
	 */
    function __construct(){
        $this->actions();
    }

	/**
	 * Add the worpdress hooks
	 */
    public function actions(){
        add_shortcode( 'popup', array($this, 'popup') );
    }

	/**
	 *
	 * Generate the popup code
	 *
	 * @param $args
	 * @param $content
	 *
	 * @return string
	 */
    public function popup($args, $content){
        $html = '
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#'.$args['id'].'">
           '.$args['buttontext'].'
        </button>

        <!-- Modal -->
        <div class="modal fade" id="'.$args['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

            <div class="modal-dialog" role="document">

                <div class="modal-content">


                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">'.$args['title'].'</h4>
                    </div>


                    <div class="modal-body">
                        '.$content.'
                    </div>


                    <div class="modal-footer">
                       '.$args['footer'].'
                    </div>
                </div>

            </div>

        </div>
        ';

        return $html;
    }

}
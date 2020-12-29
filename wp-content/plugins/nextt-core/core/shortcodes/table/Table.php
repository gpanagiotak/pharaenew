<?php

/**
 * Class Table
 * Included into Actions_Shortcodes.pohp
 * Included into REgister_shortcodes.php
 */
class Table{


	/**
	 * HTML Prefixes
	 * @var string
	 */
	private $start = '<table class="table"><thead>';
	private $tr = '<tr>';
	private $trc = '</tr>';
	private $td = '<td>';
	private $tdc = '</td>';
	private $theadc = '</thead>';
	private $tbody = '<tbody>';
	private $end = '</body></table>';

	/**
	 * Initalize the object
	 */
    function __construct(){
        $this->actions();
    }

	/**
	 *  Ass hooks to wordpress
	 */
	public function actions(){
        add_shortcode( 'table', array($this, 'table') );
    }

	/**
	 * Create the table shortcode source code
	 * @param $args
	 * @param $content
	 *
	 * @return string
	 */
	public function table($args, $content){
        $row = intval($args['rows']);
        $title =  explode('|', $args['titles']);
        $content = explode('|', $args['content']);

        $html = '';

        // Start the table;
        $html = $html . $this->start;

        // Open the tr
        $html = $html . $this->tr;

        // Set the header
        foreach($title as $item){
            $html = $html . $this->td . $item . $this->tdc;
        }

        // Close the tr
        $html = $html . $this->trc;

        // Close the table's header
        $html = $html . $this->theadc;

        // Open the table's body
        $html = $html . $this->tbody;

        $limit = 0;
        $i = 0;

        // open a tr
        $html  = $html . $this->tr;

        for($i; $i < count($content); $i++){

            // Increase the limit
            $limit++;

            // Add the td content
            $html = $html . $this->td . $content[$i] . $this->tdc;

            // If we are at the end of row close the row and open a new one
            if($limit == $row){

                // close the tr
                $html = $html . $this->trc;

                // If this is not the last item open a new tr
                if(count($content)-1 != $i){
                    $html  = $html . $this->tr;
                }

                $limit = 0;

            }// End if;


        }// End for;

        $html = $html . $this->end;


        return $html;
    }


}
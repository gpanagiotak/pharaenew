<?php

    /**
     * Class Image_Categories
     * Add categories to media (wordpress' images)
     *
     * usage: new Image_Categories(array('Category 1', 'Category 2'))
     */
    class Image_Categories {

        /**
         * Keep the categories
         * @var array
         */
        private $categories = [];

        /**
         * Initialize the object
         * @param $categories
         */
        function __construct($categories) {

            if($categories!=null){
                $this->setCategories($categories);
            }
            $this->actions();

        }

        /**
         * Add actions to wordpress
         */
        public function actions() {
            add_action( 'init' , array($this, 'add_image_attachments') );
        }

        /**
         * Fire the init wordpress action
         */
        public function add_image_attachments() {

            foreach($this->categories as $category){
                register_taxonomy_for_object_type( $category, 'attachment' );
            }

        }

        /**
         * Set the categories
         * @param mixed $categories
         */
        public function setCategories($categories) {
            $this->categories = $categories;
        }
    }
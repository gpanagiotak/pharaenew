<?php

/**
 * Class Fetch_Theme_Options
 */
class Fetch_Theme_Options
{

    /**
     * Constructor
     */
    function __construct()
    {

    }

    /**
     * Get the data
     * @return array
     */
    public function get_data()
    {
        $slugs = Theme_Options::$slugs;

        $data = array();
        foreach ($slugs as $slug)
        {
            $data[] = get_option(Theme_Options::$store_key_prefix . $slug . ICL_LANGUAGE_CODE);
        }
        return $data;
    }

    /**
     * Reconstruction the data
     * @return array
     */
    public function reconstruction_data($with_key)
    {
        $reconstruction = array();
        $data = $this->get_data();
        if ($with_key)
        {
            foreach ($data as $d)
            {
                if ($d)
                {
                    foreach ($d['inputs'] as $input)
                    {
                        $reconstruction[$input['properties']['text-id']] = array(
                            'title' => $input['title'],
                            'value' => str_replace('\\', '', $input['properties']['value'])
                        );
                    }
                }
            }
        } else
        {

            foreach ($data as $d)
            {
                foreach ($d['inputs'] as $input)
                {
                    $reconstruction[] = array(
                        'title' => $input['title'],
                        'value' => $input['properties']['value']
                    );
                }
            }
        }

        return $reconstruction;
    }


}

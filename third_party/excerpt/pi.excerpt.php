<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name'        => 'Excerpt',
  'pi_version'     => '1.0.1',
  'pi_author'      => 'Clayton McIlrath',
  'pi_author_url'  => 'http://thinkclay.com/',
  'pi_description' => 'Limits the number of words in some text, after stripping tags.',
  'pi_usage'       => Excerpt::usage()
);


/**
 * Excerpt Class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			Clayton McIlrath
 * @copyright		Copyright (c) 2010, Chosen, LLC.
 * @link			NA
 */
 
Class Excerpt {

    var $return_data;

    function excerpt()
    {
        $this->EE =& get_instance();

    	$limit	= 	( ! $this->EE->TMPL->fetch_param('limit')) ? '500' : $this->EE->TMPL->fetch_param('limit');
    	$indicator = $this->EE->TMPL->fetch_param('indicator');
    	$text	= 	$this->EE->TMPL->tagdata;
    
    	if ( ! is_numeric($limit)) 
    		$limit = 500;
                
		$this->return_data = $this->clean($text, $limit, $indicator);
    }

    
    function clean($str, $limit, $indicator)
    {
		
		$str = strip_tags($str);

        if (strlen($str) < $limit) 
            return $str;
        
        $str = str_replace("\n", " ", $str);
        $str = preg_replace("/\s+/", " ", $str);
        $str = trim($str);
        $word = explode(" ", $str);
        $count = count($word);
        
        if (($count <= $limit))
          return $str;
           
		$output = "";
		      
        for ($i = 0; $i < $limit; $i++) 
        {
    			if (isset($word[$i])) 
    				$output .= $word[$i]." ";
        }

        return trim($output) . $indicator; 
    }


	/**
	 * Usage
	 *
	 * Plugin Usage
	 *
	 * @access	public
	 * @return	string
	 */
	function usage()
	{
		ob_start(); 
		?>
		Wrap anything you want to be processed between the tag pairs. 
		This will strip out all tags automatically and do a limit on words after.

		{exp:excerpt limit="50"}text you want processed{/exp:word_limit}

		Note:  The "limit" parameter lets you specify the number of words.
		
		The indicator parameter can be used to append characters onto the end of the content, if it has been limited.
		
		For example: 
		
		{exp:excerpt limit="5" indicator="..."}This content is five words long{/exp:excerpt}
		
		Will be: This content is five words...
		
		

		Version 1.0.1
		******************
		- Initial release
		- Added indicator parameter

		<?php
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
	}
}
?>

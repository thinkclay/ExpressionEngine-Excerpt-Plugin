<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name'        => 'Excerpt',
  'pi_version'     => '1.0.2',
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


	function __construct()
    {
        $this->EE =& get_instance();

    	$this->indicator  = $this->EE->TMPL->fetch_param('indicator', '');
    	$this->limit      = $this->EE->TMPL->fetch_param('limit', 500);
    	$this->limit_type = $this->EE->TMPL->fetch_param('type', 'words');
    	
		// cleanup limit parameter
    	if (!is_numeric($this->limit))
    	{
			$this->EE->TMPL->log_item('Excerpt: Error - limit parameter not numeric');
    		$this->limit = 500;
    	}

		// cleanup limit_type parameter
		if (in_array($this->limit_type, array('words','chars'))==FALSE)
		{
			$this->EE->TMPL->log_item('Excerpt: Error - unknown limit_type');
			$this->limit_type = 'words';
		}

		$this->return_data = $this->clean($this->EE->TMPL->tagdata);
    }


    
    function clean($str)
    {
		$str = strip_tags($str);
        $str = str_replace("\n", ' ', $str);
        $str = preg_replace("/\s+/", ' ', $str);
        $str = trim($str);
        
        $words = explode(' ', $str);
        $count = count($words);


		// limit by words
        if ($this->limit_type=='words')
        {
        	if ($count <= $this->limit)
        	{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, within word limit of '.$this->limit);

				return $str;
        	}
        	else
        	{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, words limited to '.$this->limit);

				$str = trim(implode(' ', array_slice($words, 0, $this->limit)));

				return $str . (count($words) > $this->limit ? $this->indicator : '');
			}
		}
		
		// limit by chars
		if ($this->limit_type == 'chars')
		{
			$output = "";
			
			foreach($words as $word)
			{
				$output .= $word;

				// break if longer than limit
				if (strlen($output) > $this->limit) break;
			
				$output .= ' ';
        	}

			if (strlen($output) > $this->limit)
			{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, chars limited to '.$this->limit);
		        return $output . $this->indicator;
			}
			else
			{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, withing chars limit of '.$this->limit);
		        return $output;
			}
		}

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
#Excerpt Plugin

Wrap anything you want to be processed between the tag pairs. 
This will strip out all tags automatically and do a limit on words after.

    {exp:excerpt limit="50"}text you want processed{/exp:excerpt}


## Parameters
Use the following parameters to specify what the plugin should return.

### limit="5"
The limit parameter lets you specify how many words or characters to return. Default 500

### limit_type="words"
The limit_type parameter lets you specify if you want to limit to words (words) or characters (chars).  
When limiting to chars, the plugin returns whole words, so the actual number of charactars migh be slightly larger. 

    {exp:excerpt limit="2" limit_type="chars"}Hello World{/exp:excerpt}
    returns: Hello

### indicator="..."
The indicator parameter can be used to append characters onto the end of the content, if it has been limited.

    {exp:excerpt limit="1" indicator="..."}Hello World{/exp:excerpt}
    more than limit words, returns: Hello...
    
    {exp:excerpt limit="2" indicator="..."}Hello World{/exp:excerpt}
    Not limited, returns: Hello World



## Changelog

### Version 1.0.2
- Added limit_type = words | chars

### Version 1.0.1
- Added indicator parameter

### Version 1.0
- Initial release


__Humans.txt__  
thinkclay, bryantAXS, GDmac
		<?php
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
	}
}
?>

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
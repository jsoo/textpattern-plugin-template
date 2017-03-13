<?php

// Configuration file for the zem_tpl.php Textpattern plugin compiler.
// This is modified from the official Textpattern plugin template,
// https://github.com/textpattern/textpattern-plugin-template

// There are several ways of setting this up. The compiler should work
// running standalone, for which you do not need to change this file. However,
// the plugin's help text will pass through in raw form. 

// To process Textile and Markdown help text, the compiler needs to know how to 
// find the PHP-Textile and Parsedown packages. PHP-Textile is part of the 
// default Textpattern installation from version 4.6 on. If you want Markdown 
// parsing you will have to install Parsedown yourself (link below).

// The simplest configuration is to run the compiler in conjunction with a 
// Textpattern installation (version 4.6 or newer), by uncommenting the 
// following line and editing it to give the path to the installation's
// textpattern directory:

#define('txpath', '/full/path/to/textpattern');

// and, optionally, copying the parsedown directory (or a symbolic link pointing
// to it) to textpattern/vendors.

// Or you can bypass Textpattern and install Parsedown and PHP-Textile in the 
// locations of your choice, then uncomment and edit the following lines:

#define('PATH_TO_TEXTILE', '/path/to/php-textile/src/Netcarver/Textile');
#define('PATH_TO_PARSEDOWN', '/path/to/parsedown/Parsedown.php');

// (NB: Parsedown is a parser for GitHub-flavoured Markdown.)
// https://github.com/erusev/parsedown
// https://github.com/textile/php-textile

?>

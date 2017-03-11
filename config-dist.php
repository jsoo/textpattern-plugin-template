<?php

// Configuration file for the zem_tpl.php Textpattern plugin compiler.
// This is modified from the official Textpattern plugin template:
// https://github.com/textpattern/textpattern-plugin-template
// 
// There are three general ways of setting this up. The compiler should work
// running standalone, for which you do not need to change this file. However,
// the plugin's help text will pass through in raw form.
//
// You can run the compiler in conjunction with a Textpattern installation
// by choosing one of these three options:
//  a) Copy a full single-file version of classTextile.php to your plugin directory.
//  b) Uncomment the following line and edit it to give the location where
//     classTextile.php can be found
#ini_set('include_path', ini_get('include_path') . ':/full/path/to/textile');
//  c) Uncomment the following line and edit it to give the location of the textpattern
//     directory inside a nearby, full Textpattern installation.
#define('txpath', '/full/path/to/textpattern');
// 
// However, there's really no point using this version of the compiler if you
// want to run it in one of the above configurations; you might as well use
// the official version. 
//
// To fully enable this version, install the PHP-Textile parser and/or the
// Parsedown parser, then uncomment and edit the appropriate line(s) below. 
// (NB: Parsedown is a parser for GitHub-flavoured Markdown.)
// https://github.com/erusev/parsedown
// https://github.com/textile/php-textile
#define('PATH_TO_TEXTILE', '/path/to/php-textile/src/Netcarver/Textile');
#define('PATH_TO_PARSEDOWN', '/path/to/parsedown/Parsedown.php');

?>
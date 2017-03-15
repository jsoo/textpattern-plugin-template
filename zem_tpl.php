<?php

@include(__DIR__.'/config.php');

if (empty($test)) {
    exit(compile_plugin());
}

// -----------------------------------------------------

function extract_section($lines, $section) {
    $result = "";

    $start_delim = "# --- BEGIN PLUGIN $section ---";
    $end_delim = "# --- END PLUGIN $section ---";

    $start = array_search($start_delim, $lines) + 1;
    $end = array_search($end_delim, $lines);
    
    if ($start === false || $end === false) {
        return false;
    }

    $content = array_slice($lines, $start, $end-$start);

    return join("\n", $content);
}

function compile_plugin($file='') {
    global $plugin, $compiler_cfg;

    if (empty($file))
        $file = $_SERVER['SCRIPT_FILENAME'];

    if (!isset($plugin['name'])) {
        $plugin['name'] = basename($file, '.php');
    }

    $content = file($file);
    for ($i=0; $i < count($content); $i++) {
        $content[$i] = rtrim($content[$i]);
    }

    $plugin['help'] = trim(extract_section($content, 'HELP'));
    $plugin['code'] = extract_section($content, 'CODE');
    // Textpattern will textile it, and encode html.
    $plugin['help_raw'] = $plugin['help'];
    
    if (! $plugin['help'] && $plugin['allow_html_help'] && ! empty($compiler_cfg['parser'])) {
        if (isset($compiler_cfg['helpfile'])) {
            $backtrace = debug_backtrace();
            $first_frame = array_pop($backtrace);
            $helpfile = dirname($first_frame['file']).'/'.$compiler_cfg['helpfile'];
            $content = file($helpfile);
            for ($i=0; $i < count($content); $i++) {
                $content[$i] = rtrim($content[$i]);
            }
            $plugin['help'] = trim(join("\n", $content));
            $plugin['help_raw'] = $plugin['help'];
        }
    }
        
    if ($plugin['help']) {
        if (defined('txpath')) {
            global $trace;
            include txpath.'/lib/class.trace.php';
            include txpath.'/vendors/Textpattern/Loader.php';
            include txpath.'/lib/txplib_misc.php';
            $trace = new Trace();
            $loader = new \Textpattern\Loader(txpath.'/vendors');
            $loader->register();
            $loader = new \Textpattern\Loader(txpath.'/vendors/parsedown');
            $loader->register();
            $loader = new \Textpattern\Loader(txpath.'/lib');
            $loader->register();
        } else {
            if (defined('PATH_TO_TEXTILE')) {
                require PATH_TO_TEXTILE.'/Parser.php';
                require PATH_TO_TEXTILE.'/DataBag.php';
                require PATH_TO_TEXTILE.'/Tag.php';
            }
            if (defined('PATH_TO_PARSEDOWN')) {
                require PATH_TO_PARSEDOWN;
            }
        }
        if (! $compiler_cfg || $compiler_cfg['parser'] == 'textile') {
            if (class_exists('Netcarver\\Textile\\Parser')) {
                $parser = new \Netcarver\Textile\Parser('html5');
                $plugin['help'] = $parser->textileThis($plugin['help']);
            }
        } elseif ($compiler_cfg['parser'] == 'parsedown') {
            if (class_exists('Parsedown')) {
                $parser = new Parsedown();
                $plugin['help'] = $parser->text($plugin['help']);
            }
        }
        if ($plugin['help'] !== $plugin['raw_help']) {
            $plugin['allow_html_help'] = 1;
        }
    }

    $plugin['md5'] = md5( $plugin['code'] );

    $header = <<<EOF
# {$plugin['name']} v{$plugin['version']}
# {$plugin['description']}
# {$plugin['author']}
# {$plugin['author_uri']}

# ......................................................................
# This is a plugin for Textpattern - http://textpattern.com/
# To install: textpattern > admin > plugins
# Paste the following text into the 'Install plugin' box:
# ......................................................................
EOF;

    $body = trim(chunk_split(base64_encode(gzencode(serialize($plugin))), 72));

    // To produce a copy of the plugin for distribution, load this file in a browser.
    header('Content-type: text/plain');

    return $header."\n\n".$body;
}

?>

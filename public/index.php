<?php

/**
 * This is an example file for initialising sitecmd.
 *
 * In an ideal world, you would keep this outside your web directory if you
 * are storing sensitive information (such as database passwords) in this file.
 *
 * If you're not, you can either put this file in your web directory, or
 * include it from a file there.
 */

// Determine the path - probably better to replace this with the absolute path
// instead
$abs_path = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR;

// The absolute path to your environment.php file
define('SITECMD_ENV_FILE', $abs_path.'config.php');

// The absolute path to 'sitecmd.php'
require $abs_path.'sitecmd'.DIRECTORY_SEPARATOR.'sitecmd.php';

// The absolute path to your template directory (no trailing slash)
$template_dir = $abs_path.'rare'.DIRECTORY_SEPARATOR.'_templates';

require $abs_path.'markdown.php';

// Run sitecmd and return the file contents
$content = sitecmd::init();

/**
 * Everything below is optional, but is included here to save you time if you
 * want a templated website.
 *
 * The following creates two new sitecmd attributes named 'page.title' and
 * 'page.template'. To set these, just specify them in the content file that
 * is being requested through the URL.
 *
 * If 'page.template' is NULL, the file content will be output directly to the
 * browser. This is useful for things such as AJAX responses where you want to
 * avoid sending HTML, etc.
 *
 * If 'page.template' is not specified or left empty, a file named 'default.php'
 * will be used as the template. Obviously you need to create this file first!
 */

// Always useful to set
fTimestamp::setDefaultTimezone('Europe/London');

// Create a template object
$template = new fTemplating($template_dir);

/**
 * Set the page title.
 *
 * If you want to use this, ensure you echo $template->get('title') in the
 * appropriate place in your template. You will also need to use
 * sitecmd::set('page.title', 'Page Name') within the requested file. If
 * left empty, you'll just see the site name in the browser title bar.
 *
 * You will also need to replace MY-WEBSITE below to whatever your website is
 * named. The page title will then be displayed as "Page Name | My Site" in
 * the browser title bar.
 */
$template->set('title', (sitecmd::get('page.title') ?
	sitecmd::get('page.title').' | ' : '').'Rare');

$template_file = sitecmd::get('page.template');

// Sometimes we might not want a template, for example AJAX responses
if ($template_file === NULL)
{
    echo $content;
}
else
{
    include $template_dir.'/'.($template_file ?
		$template_file : 'default') .'.php';
}
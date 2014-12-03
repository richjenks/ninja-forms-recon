<?php

/**
 * Plugin Name: Ninja Forms - Recon
 * Plugin URI: https://bitbucket.org/richjenks/nf-moar-data
 * Description: When you need to know more about your users, do some recon!
 * Version: 1.0
 * Author: Rich Jenks <rich@richjenks.com>
 * Author URI: http://richjenks.com
 * License: GPL2
 */

namespace RichJenks\NFRecon;

require_once 'inc/Helper.php';
require_once 'inc/Plugin.php';

require_once 'inc/Options.php';
require_once 'inc/Admin.php';
require_once 'inc/Fields.php';

if ( is_admin() )  new Admin;
if ( !is_admin() ) new Fields;

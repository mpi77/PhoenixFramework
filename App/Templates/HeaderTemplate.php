<?php 

namespace App\Templates;

use \Phoenix\Core\Config;
use \Phoenix\Locale\Translate;

/**
 * HTML page header template.
 *
 * @version 1.1
 * @author MPI
 *
 */
?>
<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo htmlspecialchars(Config::get(Config::KEY_SITE_BASE));?>">
<title><?php ?></title>
<meta name="description" content="<?php ?>">
<meta name="keywords" content="<?php ?>">
<meta name="author" content="<?php ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<link rel="shortcut icon" href="images/favicon/favicon.ico" title="favicon" />
<link rel="stylesheet" href="css/custom.css" />
</head>

<body role="document">
    <div id="main-wrap">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="menu-navbar">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><li class="fa fa-empire">&nbsp;</li>HOME</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="user/login/">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
		
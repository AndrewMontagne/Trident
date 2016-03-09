<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Trident</title>
    <link rel="stylesheet" href="css/pure.css">
    <link rel="stylesheet" href="css/fonts/octicons/octicons.css">
    <link rel="stylesheet" href="css/layouts/side-menu.css">
    <link href='https://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#"><i class="mega-octicon octicon-git-branch"></i>Trident</a>

            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="#" class="pure-menu-link"><i class="octicon octicon-sign-in"></i> Sign In</a></li>
                <li class="pure-menu-item"><a href="#" class="pure-menu-link"><i class="octicon octicon-repo"></i> Repos</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Trident</h1>
            <h2>Source Control & Project Management</h2>
        </div>
        <br/>
        <div class="content">
            <?=$body_content?>
        </div>
    </div>
</div>
<script src="js/ui.js"></script>
</body>
</html>

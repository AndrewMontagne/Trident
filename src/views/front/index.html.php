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
    <script src="js/jquery-1.12.1.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
    <script>
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27 && $('.modal-iframe').is(":visible")) { // ESC
                $('.modal-iframe').fadeOut(400);
            }
        });
    </script>
    <style>
        .blurred
        {
            filter: blur(5px) grayscale(50%);
            -webkit-filter: blur(5px) grayscale(50%);
        }
        .modal-iframe
        {
            background-color: rgba(0,0,0,0.5);
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 1001;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        .modal-iframe-content
        {
            background-color: white;
            position: absolute;
            width: 512px;
            height: 512px;
            left: calc(50% - 256px);
            top: calc(50% - 256px);
            box-shadow: 0px 0px 50px rgba(0,0,0,0.5);
        }
        .modal-iframe-content.tall
        {
            width: 480px;
            height: 640px;
            left: calc(50% - 240px);
            top: calc(50% - 320px);
        }
        .modal-iframe-content.wide
        {
            width: 640px;
            height: 480px;
            left: calc(50% - 320px);
            top: calc(50% - 240px);
        }
        .modal-iframe-content iframe
        {
            position: absolute;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            border: 0px;
        }
    </style>
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
<div class="modal-iframe">
    <div class="modal-iframe-content wide">
        <iframe src=""></iframe>
    </div>
</div>
</body>
</html>

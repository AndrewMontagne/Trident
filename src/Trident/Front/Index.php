<?php
/**
 * Copyright 2016 Andrew O'Rourke
 */

namespace Trident\Front;

use \Flight, \Parsedown;

class Index
{
    public static function indexAction()
    {
        $markdownEngine = new Parsedown();
        $content = $markdownEngine->text(file_get_contents(ROOT_DIR . '/README.md'));
        \Flight::render('front/index.html', ['body_content' => $content]);
    }
}
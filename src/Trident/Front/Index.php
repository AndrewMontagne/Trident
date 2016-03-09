<?php
/**
 * Copyright 2016 Andrew O'Rourke
 */

namespace Trident\Front;


class Index
{
    public static function indexAction()
    {
        \Flight::render('front/index.html');
    }
}
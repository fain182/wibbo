<?php

namespace Wibbo\FunctionalTest;


use Silex\WebTestCase;

class WibboTestCase extends WebTestCase {

    public function createApplication()
    {
        $app = include __DIR__."/../../../web/app.php";
        return $app;
    }

}
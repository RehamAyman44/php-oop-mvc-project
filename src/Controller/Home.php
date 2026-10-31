<?php
namespace Aslam\Test\Controller;

use Aslam\Test\View;
class Home
{
    public function index()
    {
        View::Render('home.php');
    }
}
<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    public function index()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
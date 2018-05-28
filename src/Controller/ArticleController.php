<?php
namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index() {
//        $mg = $this->getDoctrine()->getManager();
//        $a = new Article();
//        $a->setTitle('news 1');
//        $a->setBody('news 1 body; news 1 body; news 1 body; news 1 body;');
//        $mg->persist($a);
//        $mg->flush();

        $articles = $this->getDoctrine()->
        getRepository(Article::class)->findAll();

        return $this->render('articles/index.html.twig', array('articles' => $articles));
    }
}
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
//        for ($i = 0; $i <= 25; $i ++) {
//            $a = new Article();
//            $a->setTitle("news $i title title title title");
//            $a->setBody("news $i body body body body body body body body body body body");
//            $mg->persist($a);
//        }
//        $mg->flush();

        $articles = $this->getDoctrine()->
        getRepository(Article::class)->findAll();

        return $this->render('articles/index.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('articles/show.html.twig', array('article' => $article));
    }
}
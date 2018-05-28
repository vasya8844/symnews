<?php
namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


class ArticleController extends Controller {
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index(Request $request) {
        $page = $request->query->get('page', 1);

        $qb = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAllQueryBuilder();

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(7);
        $pagerfanta->setCurrentPage($page);

        return $this->render('articles/index.html.twig', array('my_pager' => $pagerfanta));
    }

    /**
     * @Route("/article/import_from_file")
     */
    public function import_from_file() {
        $mg = $this->getDoctrine()->getManager();

        # use there anonymous function is difficult to understand an algorithm
        foreach ((function ($file) {
            $f = fopen($file, 'r');
            try {
                while ($line = fgets($f)) {
                    yield $line;
                }
            } finally {
                fclose($f);
            }
        })("../news.txt") as $line) {
            $article = explode('|', $line);

            $a = new Article();
            $a->setTitle($article[0]);
            $a->setBody($article[1]);
            $mg->persist($a);
        }
        $mg->flush();

        return new Response('Imported.');
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('articles/show.html.twig', array('article' => $article));
    }
}
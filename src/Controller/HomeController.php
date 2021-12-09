<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController {

    //Retourne la page d'accueil
    public function home(ArticleRepository $articles, CategoryRepository $category): Response
    {
        $liste_article = $articles->findLatest5();
        $articles_randoms = $articles->articleRandom();
        $liste_category = $category->findAllCategory();
        return $this->render('pages/home.html.twig', [
            'liste_article' => $liste_article,
            'articles_random' => $articles_randoms,
            'liste_category' => $liste_category
        ]);
    }

    public function index(ArticleRepository $articles, PaginatorInterface $paginator, Request $request, CategoryRepository $category) :Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class, $search);
        $form->handleRequest($request);
        $liste_category = $category->findAllCategory();

        $articles = $paginator->paginate(
            $articles->findAllArticleQuery($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('pages/index.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles,
            'liste_category' => $liste_category
        ]);
    }


    public function contact(CategoryRepository $category)
    {
        $liste_category = $category->findAllCategory();

        return $this->render('pages/contact.html.twig', [
            'liste_category' => $liste_category
        ]);
    }

    public function about(ArticleRepository $articles, CategoryRepository $category)
    {
        $liste_category = $category->findAllCategory();
        $liste_article = $articles->findLatest3();
        $numFollowers = 0;
        $url = "https://www.instagram.com/myespritzen";
        $response = file_get_contents($url.'/?__a=1');
        $data = json_decode($response, true);
        if (isset($data['graphql']['user']['edge_followed_by']['count'])) {
            $numFollowers = $data['graphql']['user']['edge_followed_by']['count'];
        }
        return $this->render('pages/about-us.html.twig', [
            'numFollowers' => $numFollowers,
            'liste_article' => $liste_article,
            'liste_category' => $liste_category
        ]);
    }

    public function show(Article $article, string $slug, CategoryRepository $category): Response
    {
        $liste_category = $category->findAllCategory();
        if ($article->getSlug() !== $slug)
        {
            $this-> redirectToRoute('show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301);
        }
        return $this->render('pages/show.html.twig', [
            'article' => $article,
            'liste_category' => $liste_category
        ]);
    }

}
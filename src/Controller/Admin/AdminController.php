<?php
namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\Common\Persistence\ObjectManager;

class AdminController extends AbstractController
{

    private $article;
    private $em;

    public function __construct(ArticleRepository $article, ObjectManager $em)
    {
        $this->article = $article;
        $this->em = $em;
    }


}
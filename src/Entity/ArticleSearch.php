<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class ArticleSearch {

    private $article;
    private $date;

    /**
     * @var ArrayCollection
     */
    private $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article): void
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategory(): ArrayCollection
    {
        return $this->category;
    }

    /**
     * @param ArrayCollection $category
     */
    public function setCategory(ArrayCollection $category): void
    {
        $this->category = $category;
    }



}
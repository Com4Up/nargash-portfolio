<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="/")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('base/index.html.twig');
    }

    /**
     * @Route("/projets", name="projets")
     */
    public function projets()
    {
        // replace this line with your own code!
        return $this->render('base/projets.html.twig');
    }

    /**
     * @Route("/hobbies", name="hobbies")
     */
    public function hobbies()
    {
        // replace this line with your own code!
        return $this->render('base/hobbies.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        // replace this line with your own code!
        return $this->render('base/blog.html.twig');
    }

    /**
     * @Route("/lecture", name="lecture")
     */
    public function lecture()
    {
        // replace this line with your own code!
        return $this->render('base/lecture.html.twig');
    }

    /**
     * @Route("/lecture-projet", name="lecture_projet")
     */
    public function lecture_projet()
    {
        // replace this line with your own code!
        return $this->render('base/lecture_projet.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        // replace this line with your own code!
        return $this->render('base/contact.html.twig');
    }
}

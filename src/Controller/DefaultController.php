<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Timeline;
use App\Entity\Skill;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;



class DefaultController extends Controller
{
    /**
     * @Route("/", name="/")
     */
    public function index(Request $request, RegistryInterface $doctrine)
    {
        $skills = $doctrine->getRepository(Skill::class)->findAll();
        // replace this line with your own code!
        // var_dump($timeline);
        return $this->render('base/index.html.twig', [
            "skills" => $skills,
        ]);
    }


    /**
     * @Route("/get-timeline",name="getTimeline")
     */

    public function getTimeline(Request $request, RegistryInterface $doctrine)
    {
        $timeline = $doctrine->getRepository(Timeline::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($timeline, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        return $response;
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

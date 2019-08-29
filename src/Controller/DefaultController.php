<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Timeline;
use App\Entity\Skill;
use App\Entity\Bio;
use App\Entity\Commentaire;
use App\Entity\Hobbie;
use App\Entity\Article;
use App\Form\HobbieType;
use App\Form\BioType;
use App\Repository\HobbieRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;




class DefaultController extends Controller
{
    /**
     * @Route("/", name="/")
     */
    public function index(Request $request, RegistryInterface $doctrine)
    {
        $bio = $doctrine->getRepository(Bio::class)->findFirst();
        $skills = $doctrine->getRepository(Skill::class)->findAll();
        $articles = $doctrine->getRepository(Article::class)->myLastArticle(3);
        // replace this line with your own code!
        // var_dump($timeline);
        return $this->render('base/index.html.twig', [
            "skills" => $skills,
            "articles" => $articles,
            "bio" => $bio,
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
     * @Route("/cms", name="cms")
     */
    public function cms(RegistryInterface $doctrine)
    {

        $skills = $doctrine->getRepository(Skill::class)->findAll();
        $hobbie = $doctrine->getRepository(Hobbie::class)->findAll();
        $articles = $doctrine->getRepository(Article::class)->findAll();
        $commentaires = $doctrine->getRepository(Commentaire::class)->findAll();
        $bio = $doctrine->getRepository(Bio::class)->findFirst();
        return $this->render('cms_base/CMS.html.twig', [
            "skills" => $skills,
            "hobbie" => $hobbie,
            "articles" => $articles,
            "bio" => $bio,
            "commentaires" => $commentaires,
        ]);
    }

    /**
     * @Route("/cms/edit-bio", name="edit-bio")
     */
    public function editBio(RegistryInterface $doctrine, Request $request)
    {
        $bio = $doctrine->getRepository(Bio::class)->findFirst();
        if ($bio == null) {
            $bio = new Bio();
        }
        $bio->getMiniature()->setFilename(new File($this->getParameter('uploadDirectory') . '/' . $bio->getMiniature()->getFilename()));
        $saveBio = $bio->getMiniature()->getFilename();
        $form = $this->createForm(BioType::class, $bio);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data->getMiniature()->getFilename() == null)
                $data->getMiniature()->setFilename($saveBio);
            #$projet->setType($type);
            $em->persist($bio);
            $em->flush();
            return $this->redirectToRoute('cms');
        }
        return $this->render('cms_base/editBio.html.twig', [
            "form" => $form->createView(),
        ]);
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
     * @Route("/get-hobbie",name="getHobbie")
     */

    public function gethobbie(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $page = $contentDecode->page;
        $biens = $doctrine->getRepository(hobbie::class)->myGetProjet($page);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($biens, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        // dump($response);

        return $response;
    }
    /**
     * @Route("/get-hobbie-selection",name="getHobbieSelection")
     */
    public function getHobbieBYType(Request $request, RegistryInterface $doctrine)
    {
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        $page = $contentDecode->page;
        if ($type != "All") {
            $selection = $doctrine->getRepository(Hobbie::class)->myGetProjetByType($type, intval($page));
        } else {
            $selection = $doctrine->getRepository(Hobbie::class)->myGetProjet(intval($page));
        }
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($selection, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        return $response;
    }

    /**
     * @Route("/count-hobbie",name="getCountHobbie")
     */

    public function countHobbie(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        if ($type != 'All')
            $count = $doctrine->getRepository(Hobbie::class)->myCountByTri($type);
        else
            $count = $doctrine->getRepository(Hobbie::class)->myCount();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($count, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        // dump($response);

        return $response;
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

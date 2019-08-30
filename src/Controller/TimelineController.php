<?php

namespace App\Controller;

use App\Entity\Timeline;
use App\Form\TimelineType;
use App\Repository\TimelineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimelineController extends AbstractController
{
    /**
     * @Route("/", name="timeline_index", methods={"GET"})
     */
    public function index(TimelineRepository $timelineRepository): Response
    {
        return $this->render('timeline/index.html.twig', [
            'timelines' => $timelineRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new-timeline", name="new-timeline", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $timeline = new Timeline();
        $form = $this->createForm(TimelineType::class, $timeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($timeline);
            $entityManager->flush();

            return $this->redirectToRoute('cms');
        }

        return $this->render('timeline/new.html.twig', [
            'timeline' => $timeline,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="timeline_show", methods={"GET"})
     */
    public function show(Timeline $timeline): Response
    {
        return $this->render('timeline/show.html.twig', [
            'timeline' => $timeline,
        ]);
    }

    /**
     * @Route("timeline/edit/{id}", name="edit-timeline", methods={"GET","POST"})
     */
    public function edit(Request $request, Timeline $timeline): Response
    {
        $timeline->getMiniature()->setFilename(new File($this->getParameter('uploadDirectory') . '/' . $timeline->getMiniature()->getFilename()));
        $saveMiniature = $timeline->getMiniature()->getFilename();

        $form = $this->createForm(TimelineType::class, $timeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data->getMiniature()->getFilename() == null)
                $data->getMiniature()->setFilename($saveMiniature);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cms');
        }

        return $this->render('timeline/edit.html.twig', [
            'timeline' => $timeline,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/delete-timeline/{id}",name="delete-timeline")
     */
    public function deleteTimeline($id)
    {
        $em = $this->getDoctrine()->getManager();
        $timeline = $em->getRepository(Timeline::class)->findOneBy(array('id' => $id));
        $em->remove($timeline);
        $em->flush();
        return $this->redirectToRoute('cms');
    }
}

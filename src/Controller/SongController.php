<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Song;
use App\Exception\FormException;
use App\Form\Type\SongType;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SongController extends AbstractController
{
    /**
     * @Route("/songs", name="song", methods={"GET"})
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $songs = $em->getRepository(Song::class)->findAll();

        return $this->json($songs);
    }

    /**
     * @Route("/songs", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(Request $request) {
        $data = $request->request->all();

        $form = $this->createForm(SongType::class);

        $form->submit($data);
        if (!$form->isValid()) {
            throw new FormException($form);
        }

        $em = $this->getDoctrine()->getManager();

        /** @var Song $song */
        $song = $form->getData();
        $song->setCreatedAt(new \DateTime());
        $song->setUpdatedAt(new \DateTime());

        $em->persist($song);
        $em->flush();

        return $this->json([
            "efef" => 1
        ]);
    }
}

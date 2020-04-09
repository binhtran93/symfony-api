<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Song;
use App\Exception\FormException;
use App\Form\Type\PlaylistType;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlaylistController extends AbstractController
{
    /**
     * @Route("/playlists", name="playlist", methods={"GET"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistController.php',
        ]);
    }

    /**
     * @Route("/playlists", methods={"POST"})
     * @param Request $request
     * @return ApiResponse
     */
    public function store(Request $request) {
        $data = $request->request->all();

        $form = $this->createForm(PlaylistType::class);
        $form->submit($data);

        if (!$form->isValid()) {
            throw new FormException($form);
        }

        $em = $this->getDoctrine()->getManager();
        /** @var Playlist $playlist */
        $playlist = $form->getData();

        $songs = $em->getRepository(Song::class)->findAll();
        foreach ($songs as $song) {
            $playlist->addSong($song);
        }

        $em->persist($playlist);
        $em->flush();

        return new ApiResponse();
    }
}

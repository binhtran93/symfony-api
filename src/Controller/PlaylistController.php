<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Song;
use App\Exception\FormException;
use App\Form\Type\PlaylistType;
use App\Repository\PlaylistRepository;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlaylistController extends AbstractController
{
    /**
     * @Route("/playlists", name="playlist", methods={"GET"})
     * @param PlaylistRepository $playlistRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(PlaylistRepository $playlistRepository)
    {
        $playlists = $playlistRepository->findAll();
        return $this->json($playlists);
    }

    /**
     * @Route("/playlists", methods={"POST"})
     * @param Request $request
     * @return ApiResponse
     */
    public function store(Request $request) {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $form = $this->createForm(PlaylistType::class);
        $form->submit($data);

        if (!$form->isValid()) {
            throw new FormException($form);
        }

        $em = $this->getDoctrine()->getManager();
        /** @var Playlist $playlist */
        $playlist = $form->getData();

        $songIds = $data['song_ids'] ?? [];
        foreach ($songIds as $songId) {
            /** @var Song $song */
            $song = $em->getRepository(Song::class)->find($songId);
            if (!$song) {
                continue;
            }

            $playlist->addSong($song);
        }

        $em->persist($playlist);
        $em->flush();

        return new ApiResponse();
    }
}


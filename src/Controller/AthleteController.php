<?php

namespace App\Controller;

use App\Entity\Athlete;
use App\Form\AthleteType;
use App\Repository\AthleteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/athlete')]
class AthleteController extends AbstractController
{
    #[Route('/', name: 'app_athlete_index', methods: ['GET'])]
    public function index(AthleteRepository $athleteRepository): Response
    {
        return $this->render('athlete/index.html.twig', [
            'athletes' => $athleteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_athlete_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AthleteRepository $athleteRepository): Response
    {
        $athlete = new Athlete();
        $form = $this->createForm(AthleteType::class, $athlete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $athleteRepository->save($athlete, true);

            return $this->redirectToRoute('app_athlete_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('athlete/new.html.twig', [
            'athlete' => $athlete,
            'form' => $form,
        ]);
    }
    #[Route('/team', name: 'app_athlete_team', methods: ['GET'])]
    public function team(Request $request, AthleteRepository $athleteRepository): Response
    {
        $team = $athleteRepository->findCompetitiveTeam('Tanya');

        return $this->render('athlete/team.html.twig', [
            'team' => $team,
        ]);
    }
    #[Route('/{id}', name: 'app_athlete_show', methods: ['GET'])]
    public function show(Athlete $athlete): Response
    {
        return $this->render('athlete/show.html.twig', [
            'athlete' => $athlete,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_athlete_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Athlete $athlete, AthleteRepository $athleteRepository): Response
    {
        $form = $this->createForm(AthleteType::class, $athlete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $athleteRepository->save($athlete, true);

            return $this->redirectToRoute('app_athlete_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('athlete/edit.html.twig', [
            'athlete' => $athlete,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_athlete_delete', methods: ['POST'])]
    public function delete(Request $request, Athlete $athlete, AthleteRepository $athleteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$athlete->getId(), $request->request->get('_token'))) {
            $athleteRepository->remove($athlete, true);
        }

        return $this->redirectToRoute('app_athlete_index', [], Response::HTTP_SEE_OTHER);
    }
}

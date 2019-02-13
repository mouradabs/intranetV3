<?php

namespace App\Controller\superAdministration;

use App\Controller\BaseController;
use App\Entity\CelcatCalendrier;
use App\Entity\Constantes;
use App\Form\CelcatCalendrierType;
use App\MesClasses\MyExport;
use App\Repository\CelcatCalendrierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("super-administration/emploi-du-temps/calendrier")
 */
class CelcatCalendrierController extends BaseController
{
    /**
     * @Route("/", name="sa_celcat_calendrier_index", methods="GET")
     * @param CelcatCalendrierRepository $celcatCalendrierRepository
     *
     * @return Response
     */
    public function index(CelcatCalendrierRepository $celcatCalendrierRepository): Response
    {
        return $this->render('super-administration/celcat_calendrier/index.html.twig', ['celcat_calendriers' => $celcatCalendrierRepository->findAll()]);
    }

    /**
     * @Route("/export.{_format}", name="sa_celcat_calendrier_export", methods="GET", requirements={"_format"="csv|xlsx|pdf"})
     * @param MyExport          $myExport
     * @param CelcatCalendrierRepository $celcatCalendrierRepository
     * @param                   $_format
     *
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function export(MyExport $myExport, CelcatCalendrierRepository $celcatCalendrierRepository, $_format): Response
    {
        $articles = $celcatCalendrierRepository->findAll();
        $response = $myExport->genereFichierGenerique(
            $_format,
            $articles,
            'articles',
            ['article_administration', 'utilisateur'],
            ['titre', 'texte', 'type', 'personnel' => ['nom', 'prenom']]
        );

        return $response;
    }

    /**
     * @Route("/new", name="sa_celcat_calendrier_new", methods="GET|POST")
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $celcatCalendrier = new CelcatCalendrier();
        $form = $this->createForm(CelcatCalendrierType::class, $celcatCalendrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($celcatCalendrier);
            $em->flush();

            return $this->redirectToRoute('sa_celcat_calendrier_index');
        }

        return $this->render('super-administration/celcat_calendrier/new.html.twig', [
            'celcat_calendrier' => $celcatCalendrier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/year", name="sa_celcat_calendrier_new_year", methods="GET|POST")
     * @param Request $request
     *
     * @return Response
     */
    public function createNewYear(Request $request): Response
    {
        return $this->render('super-administration/celcat_calendrier/create_new_year.html.twig');
    }

    /**
     * @Route("/{id}", name="sa_celcat_calendrier_show", methods="GET")
     * @param CelcatCalendrier $celcatCalendrier
     *
     * @return Response
     */
    public function show(CelcatCalendrier $celcatCalendrier): Response
    {
        return $this->render('super-administration/celcat_calendrier/show.html.twig', ['celcat_calendrier' => $celcatCalendrier]);
    }

    /**
     * @Route("/{id}/edit", name="sa_celcat_calendrier_edit", methods="GET|POST")
     * @param Request          $request
     * @param CelcatCalendrier $celcatCalendrier
     *
     * @return Response
     */
    public function edit(Request $request, CelcatCalendrier $celcatCalendrier): Response
    {
        $form = $this->createForm(CelcatCalendrierType::class, $celcatCalendrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sa_celcat_calendrier_edit', ['id' => $celcatCalendrier->getId()]);
        }

        return $this->render('super-administration/celcat_calendrier/edit.html.twig', [
            'celcat_calendrier' => $celcatCalendrier,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="sa_celcat_calendrier_delete", methods="DELETE")
     * @param Request          $request
     * @param CelcatCalendrier $celcatCalendrier
     *
     * @return Response
     */
    public function delete(Request $request, CelcatCalendrier $celcatCalendrier): Response
    {
        $id = $celcatCalendrier->getId();
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->entityManager->remove($celcatCalendrier);
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'celcat_calendrier.delete.success.flash');

            return $this->json($id, Response::HTTP_OK);
        }
        $this->addFlashBag(Constantes::FLASHBAG_ERROR, 'celcat_calendrier.delete.error.flash');

        return $this->json(false, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Route("/{id}/duplicate", name="sa_celcat_calendrier_duplicate", methods="GET|POST")
     * @param CelcatCalendrier $celcatCalendrier
     *
     * @return Response
     */
    public function duplicate(CelcatCalendrier $celcatCalendrier): Response
    {
        $newCelcatCalendrier = clone $celcatCalendrier;

        $this->entityManager->persist($newCelcatCalendrier);
        $this->entityManager->flush();
        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'celcat_calendrier.duplicate.success.flash');

        return $this->redirectToRoute('sa_celcat_calendrier_edit', ['id' => $newCelcatCalendrier->getId()]);
    }
}
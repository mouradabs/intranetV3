<?php

namespace App\Controller\administration;

use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EdtController
 * @package App\Controller\administration
 * @Route({"fr":"administration/emploi-du-temps",
 *         "en":"administration/timetable"}
 *)
 */
class EdtController extends BaseController
{
    /**
     * @Route("/", name="administration_edt_index")
     */
    public function index()
    {
        return $this->render('administration/edt/index.html.twig', [
            'controller_name' => 'EdtController',
        ]);
    }
}

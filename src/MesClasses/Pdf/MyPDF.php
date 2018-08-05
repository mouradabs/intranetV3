<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 26/07/2018
 * Time: 08:10
 */

namespace App\MesClasses\Pdf;


use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

abstract class MyPDF
{
    /** @var Dompdf */
    protected static $domPdf;

    protected static $options;

    /** @var EngineInterface */
    protected static $templating;

    /**
     * MyPDF constructor.
     *
     * @param Dompdf $domPdf
     */
    public function __construct(EngineInterface $templating)
    {
        self::$templating = $templating;
        self::$options = new Options();

        self::$options->set('isRemoteEnabled', true);
        self::$options->set('isPhpEnabled', true);
    }

    public static function addOptions(array $options) {

    }

    /**
     * @param $template
     * @param $data
     * @param $name
     *
     */
    public static function generePdf($template, $data, $name)
    {

        $html = self::$templating->render($template, $data);

        self::$domPdf = new Dompdf(self::$options);
        self::$domPdf->loadHtml($html);
        self::$domPdf->render();

        self::$domPdf->stream($name, array('Attachment' => 1));
    }
}
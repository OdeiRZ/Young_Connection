<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intercambio;
use Swift_Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TCPDF;

abstract class BaseController extends Controller
{
    /**
     * Genera un objeto documento PDF
     *
     * @param $titulo
     * @param $logos
     * @param $plantilla
     * @param $margen
     * @param $codigo
     * @return TCPDF
     */
    protected function generarPdf($titulo, $logos, $plantilla, $margen = 0, $codigo = null)
    {
        $pdf = $this->get('white_october.tcpdf')->create();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Young_Connection');
        $pdf->SetTitle($titulo);
        $pdf->SetKeywords('');
        $pdf->SetExtendedHeaderData(
            array(
                $logos['organizacion'],
                $logos['sello']
            ),
            array(
                $this->container->getParameter('centro'),
                $plantilla['descripcion'],
                $plantilla['revision']
            )
        );
        if ($codigo) {
            $pdf->setBarcode($codigo);
        }
        $pdf->setFooterData(array(0, 0, 128), array(0, 64, 128));
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER + $plantilla['margen']);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM - $margen);
        $pdf->SetFont('helvetica', '', 10, '', true);
        $pdf->AddPage();
        return $pdf;
    }

    protected function notificarIntercambio($grupos, Intercambio $intercambio)
    {
        $enviados = 0;
        $mailer = $this->get('mailer');
        $adjunto = null;
        foreach($grupos as $grupo) {
            if ($grupo->getCoordinador()->getCorreoElectronico()) {
                if (is_null($adjunto)) {
                    $plantilla = $this->container->getParameter('intercambio');
                    $logos = $this->container->getParameter('logos');
                    $pdf = $this->generarPdf('Intercambio #' . $intercambio->getId(), $logos, $plantilla, 0, 'P' . $intercambio->getId());
                    $html = $this->renderView('AppBundle:Intercambio:imprimir.html.twig',
                        array(
                            'intercambio' => $intercambio,
                            'usuario' => $grupo->getCoordinador()->getCorreoElectronico(),
                            'localidad' => $this->container->getParameter('localidad')
                        ));
                    $pdf->writeHTML($html);
                    $adjunto = Swift_Attachment::newInstance($pdf->getPDFData(), 'I' . $intercambio->getId() . '.pdf', 'application/pdf')->setDisposition('inline');
                }
                $mensaje = $mailer->createMessage()
                    ->setSubject($this->container->getParameter('prefijo_notificacion') . ' - Notificación de alta de Intercambio')
                    ->setFrom($this->container->getParameter('remite_notificacion'))
                    ->setTo(array($grupo->getCoordinador()->getCorreoElectronico() => $grupo->getCoordinador()->__toString()))
                    ->setBody('Los Coordinadores de los Grupos del Intercambio han sido notificados del documento adjunto inluido en el mensaje.')
                    ->attach($adjunto);
                $enviados++;
                $mailer->send($mensaje);
            }
        }
        return $enviados;
    }
}
<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Imagen;
use AppBundle\Form\Type\ImagenType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/imagen")
 */
class ImagenController extends Controller
{
    /**
     * @Route("/listar", name="imagenes_listar")
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $imagenes = $em->getRepository('AppBundle:Imagen')
            ->createQueryBuilder('d')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Imagen:listar.html.twig', [
            'imagenes' => $imagenes
        ]);
    }

    /**
     * @Route("/nuevo", name="imagen_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $imagen = new Imagen();
        $formulario = $this->createForm(new ImagenType(), $imagen);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagen);
            $em->flush();
            $this->addFlash('success', 'Imagen creada correctamente');
            return new RedirectResponse(
                $this->generateUrl('imagenes_listar')
            );
        }
        return $this->render('AppBundle:Imagen:nuevo.html.twig', [
            'imagen' => $imagen,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{imagen}", name="imagen_eliminar"), methods={'GET', 'POST'}
     */
    public function eliminarAction(Imagen $imagen, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($imagen);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('imagenes_listar')
        );
    }

}

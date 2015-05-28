<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Familia;
use AppBundle\Form\Type\FamiliaType;
use AppBundle\Form\Type\FiltroPaisType;
use AppBundle\Utils\Mensajes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Route("/familia")
 */
class FamiliaController extends Controller
{
    /**
     * @Route("/listar", name="familias_listar")
     */
    public function listarAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this,
            $this->container, $this->get('security.token_storage')->getToken()->getUser()));
        $em = $this->getDoctrine()->getManager();
        $auxPaises = $em->createQueryBuilder('f')
            ->select('f.pais')
            ->from('AppBundle:Familia', 'f')
            ->add('groupBy', 'f.pais')
            ->orderBy('f.pais', 'ASC')
            ->getQuery()
            ->getResult();
        $paises = [];
        foreach ($auxPaises as $i => $pais) {
            $paises[$auxPaises[$i]['pais']] = $auxPaises[$i]['pais'];
        }
        $form = $this->createForm(new FiltroPaisType(), $paises, [
            'paises' => $paises,
            'familia' => true
        ])->handleRequest($peticion);
        $pais = ($form->isValid()) ? $_POST['filtroPaises']['pais'] : null;
        $qb = $em->getRepository('AppBundle:Familia')
                 ->createQueryBuilder('f');
        if ($pais) {
            $qb->where('f.pais = :pais')
                ->setParameter('pais', $_POST['filtroPaises']['pais']);
        }
        $familias =  $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Familia:listar.html.twig', [
            'formulario_paises' => $form->createView(),
            'familias' => $familias
        ]);
    }

    /**
     * @Route("/modificar/{familia}", name="familia_modificar"), methods={'GET', 'POST'}
     */
    public function modificarAction(Familia $familia, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$familia) {
            throw $this->createNotFoundException('No hay familias disponibles'.$familia);
        }
        $miembros = new ArrayCollection();
        foreach ($familia->getMiembros() as $miembro) {
            $miembros->add($miembro);
        }
        $formulario = $this->createForm(new FamiliaType(), $familia);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Familia',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            foreach ($miembros as $miembro) {
                if (false === $familia->getMiembros()->contains($miembro)) {
                    $em->remove($miembro); //$miembro->setFamilia(null);
                    //$familia->removeElement($miembro); //$em->persist($miembro);
                }
            }
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($familia);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
            return new RedirectResponse(
                $this->generateUrl('familias_listar')
            );
        }
        return $this->render('AppBundle:Familia:modificar.html.twig', [
            'familia' => $familia,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="familia_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $familia = new Familia();
        $formulario = $this->createForm(new FamiliaType(), $familia);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($familia);
            $em->flush();
            $this->addFlash('success', 'Familia creada correctamente');
            return new RedirectResponse(
                $this->generateUrl('familias_listar')
            );
        }
        return $this->render('AppBundle:Familia:nuevo.html.twig', [
            'familia' => $familia,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{familia}", name="familia_eliminar"), methods={'GET', 'POST'}
     */
    public function eliminarAction(Familia $familia, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($familia);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('familias_listar')
        );
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Centro;
use AppBundle\Form\Type\CentroType;
use AppBundle\Form\Type\FiltroPaisType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/centro")
 */
class CentroController extends Controller
{
    /**
     * @Route("/listar", name="centros_listar")
     */
    public function listarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $auxPaises = $em->createQueryBuilder('c')
                ->select('c.pais')
                ->from('AppBundle:Centro', 'c')
                ->add('groupBy', 'c.pais')
                ->orderBy('c.pais', 'ASC')
                ->getQuery()
                ->getResult();
        $paises = [];
        foreach ($auxPaises as $i => $pais) {
            $paises[$auxPaises[$i]['pais']] = $auxPaises[$i]['pais'];
        }
        $form = $this->createForm(new FiltroPaisType(), $paises, [
            'paises' => $paises,
            'centro' => true
        ])->handleRequest($request);
        $pais = ($form->isValid()) ? $_POST['filtroPaises']['pais'] : null;
        $qb = $em->getRepository('AppBundle:Centro')
                 ->createQueryBuilder('c')
                 ->orderBy('c.nombre', 'ASC');
        if ($pais) {
            $qb->where('c.pais = :pais')
               ->setParameter('pais', $_POST['filtroPaises']['pais']);
        }
        $centros =  $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Centro:listar.html.twig', [
            'formulario_paises' => $form->createView(),
            'centros' => $centros
        ]);
    }

    /**
     * @Route("/modificar/{centro}", name="centro_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function modificarAction(Centro $centro, Request $peticion)
    {
        $formulario = $this->createForm(new CentroType(), $centro);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Centro',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($centro);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
            return new RedirectResponse(
                $this->generateUrl('centros_listar')
            );
        }
        return $this->render('AppBundle:Centro:modificar.html.twig', [
            'centro' => $centro,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="centro_nuevo"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function nuevoAction(Request $peticion)
    {
        $centro = new Centro();
        $formulario = $this->createForm(new CentroType(), $centro);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($centro);
            $em->flush();
            $this->addFlash('success', 'Centro creado correctamente');
            return new RedirectResponse(
                $this->generateUrl('centros_listar')
            );
        }
        return $this->render('AppBundle:Centro:nuevo.html.twig', [
            'centro' => $centro,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{centro}", name="centro_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarAction(Centro $centro, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($centro);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('centros_listar')
        );
    }
}

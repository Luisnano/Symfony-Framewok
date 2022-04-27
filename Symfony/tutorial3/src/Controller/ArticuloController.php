<?php
namespace App\Controller;
use App\Entity\Articulo;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticuloFormType;
use Twig\Environment;
class ArticuloController extends AbstractController{

    /** 
    * @Route("/articulo/index_form")
    */

    public function index_form(Environment $twig, Request $request, EntityManagerInterface $entityManager){
        
        $articulo = new Articulo();
        
        $form = $this->createForm(ArticuloFormType::class, $articulo);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($articulo);
            $entityManager->flush();

            return new Response('Articulo numero: '. $articulo->getId() . ' creado.');
        }

        return new Response($twig->render('articulo/form.html.twig', [
            'articulo_form' => $form->createView()
        ]));


    }

    /** 
    * @Route("/articulo/index_articulos")
    */

    public function index_articulos(PersistenceManagerRegistry $doctrine): Response{

        $articulos = $doctrine->getRepository(articulo::class)->findAll();
        return $this->render('articulo/index.html.twig', [
            'articulos' => $articulos
        ]);

    }



    /** 
    * @Route("/articulo/{nombre}", name="crea_articulo")
    */
    //CREATE
    
    // public function crearArticulo(string $nombre, PersistenceManagerRegistry $doctrine): Response{
    //     $entityManager = $doctrine->getManager();

    //     $articulo = new articulo();
    //     $articulo->setTitulo($titulo);
    //     $articulo->setPrice(1999);

    //     $entityManager->persist($articulo);

    //     $entityManager->flush();

    //     return new Response('Se ha creado nuevo articulo '.$articulo->getId());
    // }
    // //SHOW
    // /** 
    // * @Route("/articulo/{id}", name="ensenya_articulo")
    // */
    // //CREATE
    
    // public function ensenyaArticulo(int $id, PersistenceManagerRegistry $doctrine): Response{
    //     $articulo = $doctrine->getRepository(articulo::class)->find($id);
    //     if (!$articulo) {
    //         throw $this->createNotFoundException ('No articulo found for id '.$id);
    //         }
    //     return new Response ('Check out this great articulo: '.$articulo->getName());
    // }
    // //MODIFY
    // //SHOW
    // /** 
    // * @Route("/articulo/{id}", name="cambia_articulo")
    // */
    // public function cambia_articulo(int $id, PersistenceManagerRegistry $doctrine): Response{
    //     $entityManager = $doctrine->getManager();
    //     $articulo = $entityManager->getRepository(articulo::class)->find($id);

    //     if(!$articulo){
    //         throw $this->createNotFoundException(
    //             'No articulo found for: '. $id
    //         );
    //     }
    //     $articulo->setName('New articulo name!');
    //     $entityManager->flush();

    //     return $this->redirectToRoute('articulo_show', [
    //         'id' => $articulo->getId()
    //     ]);
    // }
    
    
}

?>

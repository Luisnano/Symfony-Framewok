<?php
namespace App\Controller;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ProductController extends AbstractController{
    /** 
    * @Route("/product", name="create_product")
    */
    //CREATE
    public function createProduct(PersistenceManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);

        $entityManager->persist($product);

        $entityManager->flush();

        return new Response('Se ha creado nuevo producto '.$product->getId());
    }
    //SHOW
    /** 
    * @Route("/product/{id}", name="product_show")
    */
    //CREATE
    public function show(int $id, PersistenceManagerRegistry $doctrine): Response{
        $product = $doctrine->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException ('No product found for id '.$id);
            }
        return new Response ('Check out this great product: '.$product->getName());
    }
    //MODIFY
    public function update(int $id, PersistenceManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if(!$product){
            throw $this->createNotFoundException(
                'No product found for: '. $id
            );
        }
        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }
}

?>

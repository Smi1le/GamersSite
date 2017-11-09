<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Product;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acme\StoreBundle\MongoDB\DAO\ProductDAO;

class DefaultController extends Controller
{
    /**
     * @Route("/default", name="default_action")
     */
    public function indexAction(Request $request)
    {
        // $product = new Product();
        // $product->setName('Yes baby');
        // $product->setPrice('19.99');
        // $product->setScale("1:10");
        // $product->setEquipment("2.4 GHz");
        // $manager = $this->get("doctrine_mongodb")->getManager();

        // $manager->persist($product);
        // $manager->flush();

        $string = "";
        foreach ($this->getRepository("AcmeStoreBundle:Product")->findAll() as $cursor){
            $string =$string . $cursor->toString() . "\n";
        }

        return $this->render($string);
    }

    protected function getRepository($namespace) {
        return $this
            ->get("doctrine_mongodb")
            ->getManager()
            ->getRepository($namespace);
    }

    /**
     * @Route("/", name="default_show")
     */
    public function createAction()
    {
         return $this->render('AcmeStoreBundle:Default:body.html.twig', array(
                "title_name" => "My New Page",
                "message" => "Hello World!!!!"
            ));
    }

    protected function save($object) {
        $manager = getRepository();
        $manager->persist($object);
        $manager->flush();
    }

    protected function update($id, $namespace) {
        $manager = getRepository($namespace);
        $product = $manager->getRepository("AcmeStoreBundle:Product")->find($id);

		if (!$product){
			throw $this->createNotFoundException('No product found for id '.$id);
		}

		$product = $object;
		$dataStore->flush();
    }

    protected function delete($id, $namespace) {
        $manager = getRepository($namespace);
        $manager->remove($product);
        $manager->flush();
    }
}

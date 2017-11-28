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
    protected function getRepository() {
        return $this
            ->get("doctrine_mongodb")
            ->getManager();
    }

    protected function save($object) {
        $manager = $this->getRepository();
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
        $manager = $this->getRepository($namespace);
        $manager->remove($product);
        $manager->flush();
    }

    protected function addHeaderLink($arrayResponse) {
        $arrayResponse["home_link"] = "/";
        $arrayResponse["catalog_link"] = "/catalog";
        $arrayResponse["lk_link"] = "/lk";
        return $arrayResponse;
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}

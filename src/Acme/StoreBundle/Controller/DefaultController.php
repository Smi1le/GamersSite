<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Product;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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


    protected function getUserById() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["user_id"])) {
            $id = $_SESSION["user_id"];
            $user = $this->get('doctrine_mongodb')
                ->getManager()
                ->getRepository("AcmeStoreBundle:User")
                ->findBy(['_id' => $id]);
            return count($user) > 0 ? $user[0] : null;
        }
        return null;
    }
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    protected function getProducts() {
        return $this
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeStoreBundle:Product')
            ->findSortedByDate();
    }

    protected function getCategories() {
        return $this
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeStoreBundle:Category')
            ->findSortedByName();
    }

    protected function getListCategories() {
        $categories = $this->getCategories();
        $newList = array();
        foreach ($categories as $category) {
            $newCategory = array(
                'name' => $category->getNameRu(),
                'href' => '/catalog/' . strtolower(str_replace(' ', '_', $category->getNameEn()))
            );
            array_push($newList, $newCategory);
        }
        return $newList;
    }
}

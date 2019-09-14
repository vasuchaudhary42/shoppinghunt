<?php

namespace App\Controller\ShoppingControllers;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createCategory(Request $request){
        $error = [];
        $response = [];
        $param = json_decode($request->getContent(), true);
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, ['validation_groups' => 'Category']);
        $form->submit($param);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $category->setStatus(true);
            $category->setRoot(true);
            $category->setCompany($this->getCompany());
            $em = $this->getEntityManager();
            $em->persist($category);
            $em->flush();
            $response = [
                'success' => 'true',
                'message' => 'category create successfully!',
            ];
        }else{
            $response = [
                'success' => 'false',
                'message' => 'category not created!',
                'errors'  => $this->getFormErrors($form)
            ];
        }
        return new JsonResponse($response);
    }

    /**
     * @param $path
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return JsonResponse
     */
    public function getCategory($path, Request $request, CategoryRepository $categoryRepository){
        $param = $request->query->all();
        $param['path'] = $path;
        $response = [];
        $category = $categoryRepository->getCategory($param);
        return new JsonResponse($category);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCategory(int $id, Request $request, CategoryRepository $categoryRepository){
        $params = json_decode($request->getContent(), true);
        $response = [];
        $category = $categoryRepository->findOneBy([
            'Company' => $this->getCompany()->getId(),
            'id'      => $id
        ]);
        if(isset($category) && $category){
            $form  = $this->createForm(CategoryType::class, $category, ['validation_groups' => 'Category']);
            $form->submit($params);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $this->getEntityManager()->flush();
                $response = [
                    'success' => 'true',
                    'message' => 'category update successfully!',
                ];
            }else{
                $response = [
                    'success' => 'false',
                    'message' => 'category not update!',
                    'errors'  => $this->getFormErrors($form)
                ];
            }
        }
        return new JsonResponse($response);
    }

    public function deleteCategory(int $id,Request $request, CategoryRepository $categoryRepository){
        $result = $categoryRepository->deleteCategory($id);
        $response = [];
        if($result){
            $response['status'] = true;
            $response['message'] = 'Category Successfully deleted';
        }else{
            $response['status'] = false;
            $response['message'] = 'Category deletion failed!';
            $response['error']  = [];
        }
        return new JsonResponse($response);
    }

    public function getAllCategory(Request $request){
        $param = $request->query->all();

        return new JsonResponse([]);
    }
    public function updateAllCategory(Request $request){
        $param = $request->request->all();

        return new JsonResponse([]);
    }
    public function deleteAllCategory(Request $request){
        $param = $request->request->all();

        return new JsonResponse([]);
    }

    public function deleteCategories(Request $request){
        $param = $request->request->all();

        return new JsonResponse([]);
    }
    public function updateCategories(Request $request){
        $param = $request->request->all();

        return new JsonResponse([]);
    }
}
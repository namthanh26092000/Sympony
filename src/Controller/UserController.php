<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MessageGenerator;
use App\Service\UserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
   public function createUser(MessageGenerator $messageGenerator):Response
   {
    //save objects and fetch objects from database
    $entityManager = $this->getDoctrine()->getManager();
    $user = new User();
    $user->setName('Phuoc');
    $user->setAge(18);
    $user->setAddress("Quang Ngai");
    $user->setJob("Student");
    $user->setPhone('0365421582');
    $user->setBirthday(date_create_from_format('d/m/Y','12/01/2004'));

    // $error = $validator->Validator($user);
    // if(count($error) >0){
    //     return new Response((string) $error,400);
    // }

    //Call Doctrine manage object $user 
    $entityManager->persist($user);
    //Executes the query(Insert)
    $entityManager->flush();
    $message = $messageGenerator->getHappyMeassage();
    $this->addFlash('success', $message);
    return new Response($message);
  //  return new Response(('Save new user with id'.$user->getId()));
   }
        public function getAll(int $id,LoggerInterface $logger):Response
        {
            $logger->info('Look, I just used a service!');
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);
            return $this->render('/user/getALL.html.twig',
            ['name'=> $user->getName(),
            'age'=> $user->getAge(),
            'address'=> $user->getAddress(),
            'phone'=> $user->getPhone()
            ]);
        }
        public function show(int $id,UserRepository $userRepository):Response
        {
            $user = $userRepository->find($id);
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);
            if(!$user){
                throw $this->createNotFoundException('No user found for id'.$id);
            }
            return new Response('Check out this greate user:'.$user->getName());
        }
        public function test():Response
        {
            return $this->render('user/test.html.twig');
        }
        public function update(int $id):Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);
            if(!$user){
                throw $this->createNotFoundException('No user found for id'.$id);
            }
          $user->setPhone('0123456789');
            $entityManager->flush();
           return $this->redirectToRoute('test');
        }
        public function remove(int $id):Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);
            if(!$user){
                throw $this->createNotFoundException('No user found for od'.$id);
            }
            $entityManager->remove($user);
            $entityManager->flush();
            return $this->redirectToRoute('test');
        }
}

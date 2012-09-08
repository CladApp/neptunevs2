<?php

namespace NeptuneVs\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use NeptuneVs\Bundle\UserBundle\Order\UsersOrder;
use NeptuneVs\Bundle\UserBundle\Form\Type\AdminEditUserType;

class AdminUserController extends Controller {

    public function showAction() {

        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $UsersOrder = new UsersOrder($users);

        return $this->render('NeptuneVsUserBundle:AdminUser:show.html.twig', array('users' => $UsersOrder));
    }

    public function LockedUserAction($id) {
        $repository = $this->getDoctrine()->getRepository('NeptuneVsUserBundle:User');
        $user = $repository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find user entity.');
        }

        if ($user->isLocked()) {
            $user->setLocked(false);
        } else {
            $user->setLocked(true);
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('NeptuneVsUserBundle_admin.show'));
    }

    public function showEditAction($id) {

        $repository = $this->getDoctrine()->getRepository('NeptuneVsUserBundle:User');
        $user = $repository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find user entity.');
        }

        $form = $this->createForm(new AdminEditUserType(), $user);

        return $this->render('NeptuneVsUserBundle:AdminUser:editUser.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView(),
                ));
    }

    public function editAction($id) {

        $repository = $this->getDoctrine()->getRepository('NeptuneVsUserBundle:User');
        $user = $repository->find($id);
        $roles = $user->getRoles();

        if (!$user) {
            throw $this->createNotFoundException('Unable to find user entity.');
        }

        $request = $this->getRequest();
        $form = $this->createForm(new AdminEditUserType(), $user);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $user->removeRoles($roles);
            $em->persist($user);
            $em->flush();

            $return = array('rep' => 'ok');
        } else {

            $engine = $this->container->get('templating');
            $content = $engine->render('NeptuneVsUserBundle:AdminUser:editUser.html.twig', array(
                'form' => $form->createView(),
                'user' => $user,
                    ));

            $return = array(
                'rep' => 'error',
                'data' => $content,
            );
        }

        $response = new Response(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function delUserAction($id) {
        $repository = $this->getDoctrine()->getRepository('NeptuneVsUserBundle:User');
        $user = $repository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find user entity.');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('NeptuneVsUserBundle_admin.show'));
    }

}
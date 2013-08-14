<?php

class AuthController extends Zend_Controller_Action
{

    public function authAction()
    {
        $this->view->form = new Application_Form_Login();
    }

    public function loginAction()
    {
        $this->_helper->viewRenderer('index');
        $form = new Application_Form_Login();
        if ($form->isValid($this->getRequest()->getPost())) {

            $adapter = new Zend_Auth_Adapter_DbTable(
                null,
                'user',
                'username',
                'password',
            );

            $adapter->setIdentity($form->getValue('username'));
            $adapter->setCredential($form->getValue('password'));

            $auth = Zend_Auth::getInstance();

            $result = $auth->authenticate($adapter);

            if ($result->isValid()) {
                return $this->_helper->redirector(
                    'index',
                    'index',
                    'default'
                );
            }
            $form->password->addError('BĹÄdna prĂłba logowania!');
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector(
            'auth',
            'index',
            'default'
        );
    }

}
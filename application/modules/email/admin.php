<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Image CMS
 * Email Module Admin
 * @property email_model $email_model
 */
class Admin extends BaseAdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('email_model');
    }

    public function index() {
        \CMSFactory\assetManager::create()
                ->renderAdmin('list');
    }

    public function settings() {
        \CMSFactory\assetManager::create()
                ->registerScript('script')
                ->registerStyle('style')
                ->setData('settings', $this->email_model->getSettings())
                ->renderAdmin('settings');
    }

    /**
     * updare settings for email
     */
    public function update_settings() {
        var_dumps($_POST['settings']);
        if ($_POST) {
            if ($this->email_model->setSettings($_POST['settings']))
                showMessage('Настройки сохранены', 'Сообщение');
        }
    }

    public function mailTest() {
        $email = new \email\classes\ParentEmail();
        $email->mailTest();
        
    }

}
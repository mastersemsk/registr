<?php
namespace Controllers;

use Models\OrgApi;
class OrgController extends AppController
{
	public function index()
	{
		echo $this->twig()->render('/org/index.twig'); die();
	}
	public function org_api() 
	{
		
		if (isset($_POST['token'])) {
			$obj = new OrgApi($_POST['token']);
			
			if (!empty($_POST['org_name'])) {
				$obj->org_name($_POST['org_name']);
			}
		
			if (!empty($_POST['id'])) {
				$obj->id_org($_POST['id']);
			}
		
			if (!empty($_POST['build'])) {
				$obj->list_org_build($_POST['build']);
			}
			
			if (!empty($_POST['activ'])) {
				$obj->list_org_activ($_POST['activ']);
			}
			if (!empty($_POST['address'])) {
				$obj->list_org_radius($_POST['address']);
			}
		} else {
			echo $this->twig()->render('/org/index.twig',['error' => 'Error token']); die();
		}
	}

}


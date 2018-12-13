<?php
class Auth {
	public function __construct(){
		global $CI;
		$this->ci = $CI;
	}
	
	function CheckAuth(){
		$uri = explode('/',$_SERVER['REQUEST_URI']);
		$this->RequestCheckAuth();
	}
	private function RequestCheckAuth(){
		$this->ci = &get_instance();
		if($this->ci->is_hookable){
			//
			$methods = $this->ci->router->fetch_method();
			$Words = preg_replace('/(?<!\ )[A-Z]/', ' $0', $methods);
			$name = strtolower($Words);
			$value = str_replace(' ', '_', $name);
			if(!empty($this->ci->session->userdata['role'])){
				$role_id = $this->ci->session->userdata['role'];
				$access_rules = $this->ci->ACL->GetAllAccessRulesByRoleID($role_id);
				$i=0;
				foreach($access_rules as $values)
				{
					$new_array[]=$values->permission;
					$i++;
				}
				if(!in_array($value, $new_array)){
					$this->ci->session->set_flashdata('access_msg', "Sorry, You don't have permission to access the requested page!");
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}
	
	private function RequestCheckSchoolAuth(){
		$this->ci = &get_instance();
		
		if($this->ci->is_hookable){
			//
			$methods = $this->ci->router->fetch_method();
			$Words = preg_replace('/(?<!\ )[A-Z]/', ' $0', $methods);
			$name = strtolower($Words);
			$value = str_replace(' ', '_', $name);
			
			
			if(!empty($this->ci->session->userdata['role'])){
				$role_id = $this->ci->session->userdata['role'];
				$access_rules = $this->ci->ACL->GetAllAccessRulesByRoleID($role_id);
				$i=0;
				foreach($access_rules as $values)
				{
					$new_array[]=$values->permissions;
					$i++;
				}
				if(!in_array($value, $new_array)){
					$this->ci->session->set_flashdata('access_msg', "Sorry, You don't have permission to access the requested page!");
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}
}

<?php  
class ControllerCommonLogin extends Controller { 
	private $error = array();

	public function index() { 
    	$this->load->language('common/login');

		$this->document->setTitle($this->language->get('heading_title'));

        $cookie_token = $this->user->getCookieToken();

		if ($this->user->isLogged() && $this->user->isTokenValid( $cookie_token) ) {
			$this->redirect($this->url->link('common/home', 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { 
			$this->session->data['token'] = $this->user->generateToken();
            setcookie("A_LOGIN", $this->user->generateToken(), time()+(24*3600), "/", "");
            //session_set_cookie_params(60*60*24, '/');

			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect'] );
			} else {
				$this->redirect($this->url->link('common/home', null, 'SSL'));
			}
		}
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
		
		$this->data['entry_username'] = $this->language->get('entry_username');
    	$this->data['entry_password'] = $this->language->get('entry_password');

    	$this->data['button_login'] = $this->language->get('button_login');
		
        if (!$this->user->isTokenValid($cookie_token)) {
			$this->error['warning'] = $this->language->get('error_token');
		}

        
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
    
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
				
    	$this->data['action'] = $this->url->link('common/login', '', 'SSL');

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} else {
			$this->data['username'] = '';
		}
		
		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
			
			unset($this->request->get['route']);
			
			if (isset($this->request->get['token'])) {
				unset($this->request->get['token']);
			}
			
			$url = '';
						
			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}
			
			$this->data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$this->data['redirect'] = '';	
		}
	
		$this->data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
	
		$this->template = 'common/login.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
		
	private function validate() {
		if (isset($this->request->post['username']) && isset($this->request->post['password']) && !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}  
?>
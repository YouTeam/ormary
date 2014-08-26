<?php

class ControllerInformationFooterforblog extends Controller {

    public function index() {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/footerforblog.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/information/footerforblog.tpl';
        } else {
            $this->template = 'default/template/information/footerforblog.tpl';
        }
        
        $this->children = array(
                           'common/htmlonlyheader',
            
				'common/footer'
				);
        
        
        $this->response->setOutput($this->render());
    }

}

?>
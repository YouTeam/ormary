<?php

class ControllerInformationHeaderforblog extends Controller {

    public function index() {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/headerforblog.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/information/headerforblog.tpl';
        } else {
            $this->template = 'default/template/information/headerforblog.tpl';
        }
        
            $this->children = array(
				'common/headerforblog'
				);
        $this->response->setOutput($this->render());
    }

}

?>
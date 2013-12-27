<?php

class sfFrontendSpacelessFilter extends sfFilter
{

    public function execute($filterChain)
    {
        $filterChain->execute();

        if(sfConfig::get('app_frontend_optimizer_plugin_use_spaceless_filter', false)){
            $response = $this->context->getResponse();
            $content = new Minify_HTML($response->getContent());
            //$content = $response->getContent();
            $response->setContent(trim($content->process()));            
        }
    }

}


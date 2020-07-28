<?php
/**
 * Class Page
 */
class Page {

    /**
     * Page constructor.
     * @param $comment Comments
     */
    public function __construct($comment)
    {
        $this->pageHeader();
        $comment->getComments();
        $this->pageForm();
        $this->pageFooter();
    }

    private function pageHeader(){
        $this->_page('header');
    }

    private function pageFooter(){
        $this->_page('footer');
    }

    private function pageForm(){
        $this->_page('form');
    }

    private function _page($name){
        include __DIR__.'/../pages/'.$name.'.php';
    }
}
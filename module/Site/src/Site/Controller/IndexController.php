<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    
    protected $menus;
    protected $articles;
    protected $is_blocks;
    protected $is_menus;
    protected $is_articles;
        
    //-->@important from DOCTRINE--->
    protected $em;
    
    public function getEntityManager() {
        if (null == $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }    
    //<--@important from DOCTRINE<---
    
    private function renderLayout(){
        
        $this->menus = $this->getEntityManager()
                ->getRepository('Xoperator\EntityTable\Menus')
                ->findBy(array('id'=>1),array('id'=> 'Asc'));
        $this->is_menus = count($this->menus) > 1 ? true : false;
        
        //show only 10 articles
        $this->articles = $this->getEntityManager()
                ->getRepository('Xoperator\EntityTable\Articles')
                ->findBy(array(),array('id'=> 'Desc'),10);
        $this->is_articles = count($this->articles) > 1 ? true : false;
    }

    
    public function indexAction()
    {   
        $this->renderLayout();
        return new ViewModel(array(
            'articles'  => $this->articles,
            'menus'     => $this->menus,
            'is_articles'  => $this->is_articles,
            'is_menus'     => $this->is_menus,
        ));
        
    }
    
    public function articleAction(){
        
        $message_error_articles = '';
        
        $article_param = $this->getEvent()->getRouteMatch()->getParam('article');
        
        //show only 8 articles
        $articles = $this->getEntityManager()->getRepository('Xoperator\EntityTable\Articles')
                ->findBy(array(),array('id'=> 'Desc'),8);
        $article_head = $this->getEntityManager()
                ->getRepository('Xoperator\EntityTable\Articles')
                ->findBy(array('url' => $article_param));
        
        if (!count($article_head) >= 1){
            $message_error_articles = 'Sorry, more this article dont exist';
        }
        
        $name_img = '';
        if(count($article_head) >= 1){            
            foreach($article_head as $art_head_array):
                $articles_id_image = $this->getEntityManager()
                        ->getRepository('Xoperator\EntityTable\Library')
                        ->findBy(array('id'=>$art_head_array->id_image));

                foreach($articles_id_image as $array_img):
                    $name_img = '../'.__xopUPLOADS__.'/'.$array_img->file_image;
                endforeach;
            endforeach;
        }
        
        return new ViewModel(array(
            'article_param' => $article_param,
            'articles' => $articles,
            'article_head' => $article_head,
            'message_error_articles' => $message_error_articles,
            'name_image' => $name_img,
        ));
    }
    
}

<?php
/**
 * User: T. Curran
 * Date: 3/6/13
 */


namespace NickyDigital\PhotoboothAdminBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;

class AdminMenu extends ContainerAware
{
    private $factory;

    /**
     * @param \Knp\Menu\FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     * @param Router $router
     */
    public function createAdminMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->setchildrenAttributes(array('id' => 'main_navigation', 'class'=>'menu'));

        //Propel demos
        $propel = $menu->addChild('Events', array('uri' => '/admin/event'));

        return $menu;
    }
}
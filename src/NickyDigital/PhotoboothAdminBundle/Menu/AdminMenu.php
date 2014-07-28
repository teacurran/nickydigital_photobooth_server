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

	public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $this->factory->createItem('root');

        $menu->setchildrenAttributes(array('id' => 'main_navigation', 'class'=>'nav'));

        $menu->addChild('Events', array('route' => 'NickyDigital_PhotoboothAdminBundle_event_list'));
		$menu->addChild('Logout', array('route' => 'fos_user_security_logout'));

        return $menu;
    }
}


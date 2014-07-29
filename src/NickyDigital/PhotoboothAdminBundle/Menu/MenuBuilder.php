<?php
/**
 * User: T. Curran
 * Date: 3/6/13
 */
namespace NickyDigital\PhotoboothAdminBundle\Menu;

use Admingenerator\GeneratorBundle\Menu\AdmingeneratorMenuBuilder;
use Knp\Menu\FactoryInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends AdmingeneratorMenuBuilder
{

	protected $translation_domain = 'Admin';

	public function navbarMenu(FactoryInterface $factory, array $options)
	{

		$menu = $factory->createItem('root');
		$menu->setChildrenAttributes(array('id' => 'main_navigation', 'class' => 'nav navbar-nav'));

		$menu->addChild('Events', array('route' => 'NickyDigital_PhotoboothAdminBundle_Event_list'));
		$menu->addChild('Logout', array('route' => 'fos_user_security_logout'));

		return $menu;
	}

}

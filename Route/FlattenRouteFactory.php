<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRoute;

class FlattenRouteFactory {

	protected $definition = array(
		'NestedRoute' => array(
			'flatten' => 'Uneak\AdminBundle\Route\FlattenRoute',
			'functions' => array(
				'NestedRoute', 'Id', 'Path', 'Host', 'MetaDatas', 'Icon', 'Label', 'Description', 'Controller', 'Action', 'Defaults', 'Requirements', 'Options', 'Schemes', 'Methods', 'Condition', 'ControllerAction', 'Parameters', 'CRUD'
			)
		),
		'NestedParameterRoute' => array(
			'flatten' => 'Uneak\AdminBundle\Route\FlattenParameterRoute',
			'functions' => array(
				'NestedRoute', 'Id', 'ParameterPath', 'Host', 'MetaDatas', 'Icon', 'Label', 'Description', 'Controller', 'Action', 'Defaults', 'Requirements', 'Options', 'Schemes', 'Methods', 'Condition', 'ControllerAction', 'Parameters', 'CRUD', 'Parameter'
			)
		),
		'NestedEntityRoute' => array(
			'flatten' => 'Uneak\AdminBundle\Route\FlattenEntityRoute',
			'functions' => array(
				'NestedRoute', 'Id', 'ParameterPath', 'Host', 'MetaDatas', 'Icon', 'Label', 'Description', 'Controller', 'Action', 'Defaults', 'Requirements', 'Options', 'Schemes', 'Methods', 'Condition', 'ControllerAction', 'Parameters', 'CRUD', 'Parameter', 'Entity'
			)
		),
		'NestedCRUDRoute' => array(
			'flatten' => 'Uneak\AdminBundle\Route\FlattenRoute',
			'functions' => array(
				'NestedRoute', 'Id', 'Path', 'Host', 'MetaDatas', 'Icon', 'Label', 'Description', 'Controller', 'Action', 'Defaults', 'Requirements', 'Options', 'Schemes', 'Methods', 'Condition', 'ControllerAction', 'Parameters', 'CrudCRUD', 'Entity'
			)
		),
		'NestedAdminRoute' => array(
			'flatten' => 'Uneak\AdminBundle\Route\FlattenAdminRoute',
			'functions' => array(
				'NestedRoute', 'Id', 'Path', 'Host', 'MetaDatas', 'Icon', 'Label', 'Description', 'Controller', 'Action', 'Defaults', 'Requirements', 'Options', 'Schemes', 'Methods', 'Condition', 'ControllerAction', 'Parameters', 'CRUD', 'Entity'
			)
		),
	);


	public function getRouteStruct(NestedRoute $nestedRoute, $data = array()) {
		$definition = $this->getDefinition($nestedRoute->getNestedType());
		foreach ($definition['functions'] as $function) {
			call_user_func_array(array($this, 'b' . $function), array($nestedRoute, &$data));
		}

		$struct = array_merge_recursive($data, array(
			'class' => $definition['flatten'],
			'enabled' => $nestedRoute->isEnabled(),
			'slug' => $nestedRoute->getId(),
			'children' => array(),
		));

		foreach ($nestedRoute->getChildren() as $nestedChild) {
			$struct['children'][] = $this->getRouteStruct($nestedChild, $data);
		}

		return $struct;
	}

	public function buildFlattenRoute($struct) {
		$class = $struct['class'];
		$flattenRoute = new $class($struct);
		foreach ($struct['children'] as $cStruct) {
			$cFlattenRoute = $this->buildFlattenRoute($cStruct);
			$flattenRoute->addChild($cFlattenRoute);
		}
		return $flattenRoute;
	}

	public function getRoutes($flattenRoute) {
		$routes = array();
		$routes[$flattenRoute->getId()] = $flattenRoute;
		foreach ($flattenRoute->getChildren() as $flattenChild) {
			$routes = array_merge($routes, $this->getRoutes($flattenChild));
		}
		return $routes;
	}

	public function getFlattenRoutes(NestedRoute $nestedRoute, $data = array()) {
		$struct = $this->getRouteStruct($nestedRoute, $data);
		$flattenRoute = $this->buildFlattenRoute($struct);
		return $this->getRoutes($flattenRoute);
	}


	public function OLD_getFlattenRoutes(NestedRoute $nestedRoute, $data = array()) {
		$definition = $this->getDefinition($nestedRoute->getNestedType());
		foreach ($definition['functions'] as $function) {
			call_user_func_array(array($this, 'b' . $function), array($nestedRoute, &$data));
		}

		$currentData = array_merge_recursive($data, array(
			'enabled' => $nestedRoute->isEnabled(),
			'slug' => $nestedRoute->getId(),
			'children' => array(),
		));


		$childData = $data;
		$childData['parent'] = $data["id"];

		$routes = array();

		foreach ($nestedRoute->getChildren() as $nestedChild) {
			$childRoutes = $this->getFlattenRoutes($nestedChild, $childData);
			foreach ($childRoutes as $cRoute) {
				$currentData['children'][$cRoute->getSlug()] = $cRoute->getId();
				$routes[$cRoute->getId()] = $cRoute;
			}
		}

		$class = $definition['flatten'];
		$instance = new $class($currentData);
		$routes[$currentData["id"]] = $instance;


		return $routes;
	}

	protected function getDefinition($nestedType) {
		return $this->definition[$nestedType];
	}

	/*
	 *
	 */

	protected function bNestedRoute($nestedRoute, &$data) {
		$data["nested_route"] = $nestedRoute;
//        $nestedRoute = (isset($data["nested_route"])) ? $data["nested_route"] : '';
//        $data["nested_route"] = $nestedRoute . '.' . $nestedRoute->getId();
	}

	protected function bId($nestedRoute, &$data) {
		$id = (isset($data["id"])) ? $data["id"] : 'uneak_admin';
		$data["id"] = $id . '.' . $nestedRoute->getId();
	}

	protected function bPath($nestedRoute, &$data) {
		$path = (isset($data["path"])) ? $data["path"] : '';
		$data["path"] = $path . $nestedRoute->getPath();
	}

	protected function bController($nestedRoute, &$data) {
		if ($nestedRoute->getController()) {
			if (isset($data["action"])) {
				if ($data["action"]) {
					$data["action"] .= ucfirst(strtolower($nestedRoute->getId()));
				} else {
					$data["action"] = strtolower($nestedRoute->getId());
				}
			} else {
				$data["action"] = '';
			}
			if (!isset($data["controller"])) {
				$data["controller"] = $nestedRoute->getController();
			}
		}
	}

	protected function bAction($nestedRoute, &$data) {
		$action = (isset($data["action"])) ? $data["action"] : '';
		if ($action) {
			$data["action"] = $action . ucfirst(strtolower($nestedRoute->getAction()));
		} else {
			$data["action"] = strtolower($nestedRoute->getAction());
		}
	}

	protected function bHost($nestedRoute, &$data) {
		$host = (isset($data["host"])) ? $data["host"] : '';
		$data["host"] = ($nestedRoute->getHost()) ? $nestedRoute->getHost() : $host;
	}

	protected function bIcon($nestedRoute, &$data) {
//        $icon = (isset($data["icon"])) ? $data["icon"] : '';
//        $data["icon"] = ($nestedRoute->getIcon()) ? $nestedRoute->getIcon() : $icon;
	}

	protected function bDefaults($nestedRoute, &$data) {
		$default = (isset($data["defaults"])) ? $data["defaults"] : array();
		$data["defaults"] = array_merge($default, $nestedRoute->getDefaults());
	}

	protected function bRequirements($nestedRoute, &$data) {
		$requirements = (isset($data["requirements"])) ? $data["requirements"] : array();
		$data["requirements"] = array_merge($requirements, $nestedRoute->getRequirements());
	}

	protected function bOptions($nestedRoute, &$data) {
		$options = (isset($data["options"])) ? $data["options"] : array();
		$data["options"] = array_merge($options, $nestedRoute->getOptions());
	}

	protected function bSchemes($nestedRoute, &$data) {
		$schemes = (isset($data["schemes"])) ? $data["schemes"] : array();
		$data["schemes"] = array_merge($schemes, $nestedRoute->getSchemes());
	}

	protected function bMethods($nestedRoute, &$data) {
		$methods = (isset($data["methods"])) ? $data["methods"] : array();
		$data["methods"] = array_merge($methods, $nestedRoute->getMethods());
	}

	protected function bCondition($nestedRoute, &$data) {
		$condition = (isset($data["condition"])) ? $data["condition"] : '';
		$data["condition"] = ($nestedRoute->getCondition()) ? $nestedRoute->getCondition() : $condition;
	}

	protected function bControllerAction($nestedRoute, &$data) {
		$data["defaults"]["_controller"] = $data['controller'] . '::' . $data['action'] . 'Action';
		$hasController = method_exists($data['controller'], $data['action'] . 'Action');
//        $nestedRoute->setEnabled($hasController);
	}

	protected function bParameters($nestedRoute, &$data) {
		$data['parameters'] = (isset($data["parameters"])) ? $data["parameters"] : array();
		if ($nestedRoute instanceof NestedParameterRoute) {
			$data["parameters"][$nestedRoute->getParameterName()] = $data['id'];
		}
	}

	protected function bMetaDatas($nestedRoute, &$data) {
		$metaDatas = (isset($data["meta_datas"])) ? $data["meta_datas"] : array();
//        $data["meta_datas"] = array_merge_recursive($metaDatas, $nestedRoute->getMetaDatas());
		$data["meta_datas"] = array_merge($metaDatas, $nestedRoute->getMetaDatas());
	}

	//
	//	FLATTEN CRUD
	//
	protected function bCRUD($nestedRoute, &$data) {
		$data["crud"] = (isset($data["crud"])) ? $data["crud"] : null;
	}

	protected function bCrudCRUD($nestedRoute, &$data) {
		$data["crud"] = $data["id"];
//		array_unshift($data["crud"], $data["id"]);
	}

	//
	//	FLATTEN PARAMETER
	//
    
	protected function bParameterPath($nestedRoute, &$data) {
		$path = (isset($data["path"])) ? $data["path"] : '';
		$data["path"] = $path . '/{' . $nestedRoute->getParameterName() . '}';
	}

	protected function bParameter($nestedRoute, &$data) {
		$data['parameter_name'] = $nestedRoute->getParameterName();
		if ($nestedRoute->getParameterDefault()) {
			$data['default'][$nestedRoute->getParameterName()] = $nestedRoute->getParameterDefault();
		}
		if ($nestedRoute->getParameterPattern()) {
			$data['requirements'][$nestedRoute->getParameterName()] = $nestedRoute->getParameterPattern();
		}
	}

	//
	//	FLATTEN ADMIN
	//
	
	protected function bLabel($nestedRoute, &$data) {
//        $label = (isset($data["label"])) ? $data["label"] : null;
//        $data["label"] = ($nestedRoute->getLabel()) ? $nestedRoute->getLabel() : $label;
	}

	protected function bDescription($nestedRoute, &$data) {
//        $description = (isset($data["description"])) ? $data["description"] : null;
//        $data["description"] = ($nestedRoute->getDescription()) ? $nestedRoute->getDescription() : $description;
	}

	protected function bEntity($nestedRoute, &$data) {
		$entity = (isset($data["entity"])) ? $data["entity"] : null;
		$data["entity"] = ($nestedRoute->getEntity()) ? $nestedRoute->getEntity() : $entity;
	}

}

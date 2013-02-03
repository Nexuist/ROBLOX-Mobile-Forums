<?php
# http://forrst.com/posts/PHP_getters_setters_and_lazy_properties-6yu
class EnhancedObject {
	#Store cached properties here
	private $lazyProperties = array();

	#Allow $object->prop to alias to $object->getProperty().
	#Also, allow caching of $object->loadProp() to $object->prop
	public function __get($property) {
		$getter = "get".ucfirst($property);
		$loader = "load".ucfirst($property);

		if(method_exists($this, $getter)) {
			return $this->$getter();
		}
		elseif(method_exists($this, $loader)) {
			if(!isset($this->lazyProperties[$property])) {
				$this->lazyProperties[$property] = $this->$loader();
			}
			return $this->lazyProperties[$property];
		}

		throw new Exception("Invalid property $property");
	}

	#Allow $object->prop = $value to alias to $object->setProperty($value).
	public function __set($property, $value) {
		$setter = "set".ucfirst($property);
		if (method_exists($this, $setter)) {
			return $this->$setter($value);
		}

		$loader = "load".ucfirst($property);
		if(method_exists($this, $loader)) {
			$this->lazyProperties[$property] = $value;
			return;
		}

		throw new Exception("Invalid property $property");
	}
}

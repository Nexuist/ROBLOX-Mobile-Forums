<?php
# http://forrst.com/posts/PHP_getters_setters_and_lazy_properties-6yu
class EnhancedObject {
	#Allow $object->prop to alias to $object->getProperty().
	public function __get($property) {
		$getter = "get".ucfirst($property);

		if(method_exists($this, $getter)) {
			return $this->$getter();
		}
		throw new Exception("Invalid property $property");
	}

	#Allow $object->prop = $value to alias to $object->setProperty($value).
	public function __set($property, $value) {
		$setter = "set".ucfirst($property);

		if (method_exists($this, $setter)) {
			return $this->$setter($value);
		}
		throw new Exception("Invalid property $property");
	}
}

class User extends EnhancedObject {
	public $name;
	public $joinDate;
	public $postCount;
	public $online;
	public $isMod;

	public function getUrl() {
		return "http://roblox.com/User.aspx?username=" . $this->name;
	}
	public function getImg() {
		return "http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&Format=Png&username=" . $this->name;
	}
}

class Post extends EnhancedObject {
	public $author;
	public $title;
	public $topic;
	public $content;
	public $date;
}

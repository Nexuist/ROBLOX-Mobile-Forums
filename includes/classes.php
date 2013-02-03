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

class Group extends EnhancedObject {
	public $name;
	public $id;
	public function getUrl() {
		return "http://www.roblox.com/Groups/Group.aspx?gid=" . $this->id;
	}
}

class Role extends EnhancedObject {
	public $name;
	public $rank;
}

class GroupInfo extends EnhancedObject {
	public $group;
	public $role;

	public static function fromJsonEntry($json) {
		$gi = new GroupInfo();
		$gi->group = new Group();
		$gi->group->name = $json->GroupName;
		$gi->group->id = $json->GroupId;
		$gi->role = new Role();
		$gi->role->name = $json->RoleSetName;
		$gi->role->rank = $json->RoleSetRank;
		return $gi;
	}
}

class User extends EnhancedObject {
	public $name;
	public $joinDate;
	public $postCount;
	public $online;
	public $isMod;
	public $groupInfo;

	public function getUrl() {
		return "http://roblox.com/User.aspx?username=" . $this->name;
	}
	public function getImg() {
		return "http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&Format=Png&username=" . $this->name;
	}

	public static function getGroupInfo($users) {
		$url = "http://www.roblox.com/Groups/GetPrimaryGroupInfo.ashx?users=".implode(',', $users);
		$data = file_get_contents($url);

		$parsed = array();
		foreach(json_decode($data) as $user => $entry) {
			$parsed[$user] = GroupInfo::fromJsonEntry($entry);
		}
		return $parsed;
	}
}

class Post extends EnhancedObject {
	public $author;
	public $title;
	public $topic;
	public $content;
	public $date;
}

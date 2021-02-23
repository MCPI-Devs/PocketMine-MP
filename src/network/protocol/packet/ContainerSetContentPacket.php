<?php

/**
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

class ContainerSetContentPacket extends RakNetDataPacket{
	public $windowid;
	public $slots = array();
	
	public function pid(){
		return ProtocolInfo::CONTAINER_SET_CONTENT_PACKET;
	}
	
	public function decode(){
		$this->windowid = $this->getByte();
		$count = $this->getShort();
		for($s = 0; $s < $count and !$this->feof(); ++$s){
			$this->slots[$s] = $this->getSlot();
		}
	}
	
	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
		$new_slots = array();
		foreach($this->slots as $slot){
			if($slot->getID() > 0 && $slot->count > 0){
				array_push($new_slots, $slot);
			}
		}
		$this->putShort(count($new_slots));
		foreach($new_slots as $slot){
			$this->putSlot($slot);
		}
	}

}
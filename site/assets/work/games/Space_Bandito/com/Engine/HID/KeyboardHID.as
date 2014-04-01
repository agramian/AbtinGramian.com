package com.Engine.HID 
{
	import flash.display.Sprite;
	import flash.events.KeyboardEvent;
	import flash.ui.Keyboard;
	import flash.display.DisplayObject;
	
	public class KeyboardHID extends Sprite
	{
		protected var _leftPressed:Boolean;
		protected var _rightPressed:Boolean;
		protected var _upPressed:Boolean;
		protected var _downPressed:Boolean;
		protected var _spacePressed:Boolean;
		protected var _pausePressed:Boolean;
		protected var _switchPlanePressed:Boolean;
		protected var _switchWeaponPressed:Boolean;
		
		public function KeyboardHID() 
		{
			
		}
		
		public function get leftPressed():Boolean { return _leftPressed; };
		public function get rightPressed():Boolean { return _rightPressed; };
		public function get upPressed():Boolean { return _upPressed; };
		public function get downPressed():Boolean { return _downPressed; };
		public function get spacePressed():Boolean { return _spacePressed; };
		public function get pausePressed():Boolean { return _pausePressed; };
		public function get switchPlanePressed():Boolean { return _switchPlanePressed; };
		public function get switchWeaponPressed():Boolean { return _switchWeaponPressed; };
		
		public function addKeyboardHIDListeners() {	
			stage.addEventListener(KeyboardEvent.KEY_DOWN, keyDown, false, 0, true);
			stage.addEventListener(KeyboardEvent.KEY_UP, keyUp, false, 0, true);
		}
		
		public function removeKeyboardHIDListeners() {
			stage.removeEventListener(KeyboardEvent.KEY_DOWN, keyDown);
			stage.removeEventListener(KeyboardEvent.KEY_UP, keyUp);
		}
		
		public function resetKeyboard() {
			_leftPressed = false;
			_rightPressed = false;
			_upPressed = false;
			_downPressed = false;
			_spacePressed = false;
			_pausePressed = false;
			_switchPlanePressed = false;
			_switchWeaponPressed = false;
		}
		
		protected function keyDown(e:KeyboardEvent):void {
			if (e.keyCode == Keyboard.F) _leftPressed = true;
			if (e.keyCode == Keyboard.H) _rightPressed = true;
			if (e.keyCode == Keyboard.T) _upPressed = true;
			if (e.keyCode == Keyboard.G) _downPressed = true;
			if (e.keyCode == Keyboard.SPACE) _spacePressed = true;
			if (e.keyCode == Keyboard.Q) _pausePressed = true;
			if (e.keyCode == Keyboard.R) _switchPlanePressed = true;
			if (e.keyCode == Keyboard.E) _switchWeaponPressed = true;
			
		}
		
		protected function keyUp(e:KeyboardEvent):void {
			if (e.keyCode == Keyboard.F) _leftPressed = false;
			if (e.keyCode == Keyboard.H) _rightPressed = false;
			if (e.keyCode == Keyboard.T) _upPressed = false;
			if (e.keyCode == Keyboard.G) _downPressed = false;
			if (e.keyCode == Keyboard.SPACE) _spacePressed = false;
			if (e.keyCode == Keyboard.Q) _pausePressed = false;
			if (e.keyCode == Keyboard.R) _switchPlanePressed = false;
			if (e.keyCode == Keyboard.E) _switchWeaponPressed = false;
		}
	}

}
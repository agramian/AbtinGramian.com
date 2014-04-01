package com.Engine.HID 
{
	import flash.display.Sprite;
	import flash.events.MouseEvent;
	import flash.display.DisplayObject;
	
	public class MouseHID extends Sprite
	{
		protected var _mousePressed:Boolean;
		public function MouseHID() 
		{
		}
		
		public function get mousePressed():Boolean { return _mousePressed; };
		
		public function addMouseHIDListeners() {
			stage.addEventListener(MouseEvent.MOUSE_DOWN, mouseDown, false, 0, true);
			stage.addEventListener(MouseEvent.MOUSE_UP, mouseUp, false, 0, true);
		}
		
		public function removeMouseHIDListeners() {
			stage.removeEventListener(MouseEvent.MOUSE_DOWN, mouseDown);
			stage.removeEventListener(MouseEvent.MOUSE_UP, mouseUp);
		}
		
		public function resetMouse() {
			_mousePressed = false;
		}
		
		protected function mouseDown(e:MouseEvent):void
		{
			_mousePressed = true;
		}
		
		protected function mouseUp(e:MouseEvent):void
		{
			_mousePressed = false;
		}
	}

}
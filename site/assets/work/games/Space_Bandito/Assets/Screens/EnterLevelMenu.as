﻿package Assets.Screens{		import com.Engine.events.APEvent;	import com.greensock.*;	import com.greensock.easing.*;	import flash.display.Sprite;	import flash.display.SimpleButton;	import flash.events.Event;	import flash.events.MouseEvent;	import flash.text.TextField;	import com.Engine.Sound.SoundEngine;		public class EnterLevelMenu extends Sprite {				public var closeButton:SimpleButton;		public var enterButton:SimpleButton;		public var levelNameText:TextField;		public var levelNumber:int;		protected var se:SoundEngine;				public function EnterLevelMenu() {			addEventListener(Event.ADDED_TO_STAGE, addedToStage, false, 0, true);			se = SoundEngine.getInstance();		}				public function setLevelInfo(name:String,number:int):void {			levelNameText.text = name;			levelNumber = number;		}				private function addedToStage(e:Event):void {			TweenLite.from(this, .4, { y : -height } );			closeButton.addEventListener(MouseEvent.CLICK, closeButtonClick, false, 0, true);			closeButton.addEventListener(MouseEvent.MOUSE_OVER, closeButtonOver, false, 0, true);			enterButton.addEventListener(MouseEvent.CLICK, enterButtonClick, false, 0, true);			enterButton.addEventListener(MouseEvent.MOUSE_OVER, enterButtonOver, false, 0, true);		}				private function closeButtonClick(e:MouseEvent):void {			se.playSound("menuDownSound");			parent.dispatchEvent(new APEvent(APEvent.HIDE_ENTER_LEVEL));			closeButton.removeEventListener(MouseEvent.CLICK, closeButtonClick);			closeButton.removeEventListener(MouseEvent.MOUSE_OVER, closeButtonOver);			enterButton.removeEventListener(MouseEvent.CLICK, enterButtonClick);			enterButton.removeEventListener(MouseEvent.MOUSE_OVER, enterButtonOver);			TweenLite.to(this, .4, { y : -height, onComplete:parent.removeChild, onCompleteParams:[this] } );		}				private function closeButtonOver(e:MouseEvent):void {			se.playSound("menuOverSound");		}				private function enterButtonClick(e:MouseEvent):void {			se.playSound("menuDownSound");			parent.dispatchEvent(new APEvent(APEvent.ENTER_LEVEL));			closeButton.removeEventListener(MouseEvent.CLICK, closeButtonClick);			closeButton.removeEventListener(MouseEvent.MOUSE_OVER, closeButtonOver);			enterButton.removeEventListener(MouseEvent.CLICK, enterButtonClick);			enterButton.removeEventListener(MouseEvent.MOUSE_OVER, enterButtonOver);			TweenLite.to(this, .4, { y : -height, onComplete:parent.removeChild, onCompleteParams:[this] } );		}				private function enterButtonOver(e:MouseEvent):void {			se.playSound("menuOverSound");		}			}}
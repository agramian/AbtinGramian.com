﻿package com.Engine.Core {		import flash.events.TimerEvent;	import flash.utils.getTimer;	import flash.utils.Timer;		public class Clock {				protected var _currentTime:int;		protected var _previousTime:int;		protected var _deltaTime:Number;		protected var _timeElapsed:int;				//SINGLETON INSTANCE		static private var _instance:Clock;				//CONSTRUCTOR - NOT ACCESSIBLE MORE THAN ONCE		public function Clock(validator:ClockSingleton) {			if (_instance) throw new Error("Clock is a Singleton class. Use getInstance() to retrieve the existing instance.");		}				static public function getInstance():Clock {			if (!_instance) _instance = new Clock(new ClockSingleton());			return _instance;		}				public function get currentTime():int { return _currentTime; }		public function get previousTime():int { return _previousTime; }		public function get deltaTime():Number { return _deltaTime; }				public function resetTime() {			_currentTime = getTimer();			_previousTime = _currentTime;			_deltaTime = 0;		}				public function get timeElapsed():String {			_timeElapsed = currentTime / 1000;			var timeString:String;			if (_timeElapsed < 60) {				timeString = "0:";			} else {				timeString = String(Math.floor(_timeElapsed / 60)) + ":";			}			var seconds:int = _timeElapsed % 60;			if (seconds < 10) {				timeString += "0" + String(seconds);			} else {				timeString += String(seconds);			}			return timeString; 		}				public function updateTime():void {			_currentTime += (getTimer() - _previousTime);			_deltaTime = (getTimer() - _previousTime)/1000;			_previousTime = getTimer();		}	}}class ClockSingleton {}
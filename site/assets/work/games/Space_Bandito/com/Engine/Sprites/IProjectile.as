﻿package com.Engine.Sprites {	import flash.geom.Vector3D;		public interface IProjectile extends ISprite {		function updatePosition():void;		function get tempX():Number;		function set tempX(value:Number):void;		function get tempY():Number;		function set tempY(value:Number):void;		function get tempRotation():Number;		function set tempRotation(value:Number):void;		function get speed():Number;		function set speed(value:Number):void; 		function get strength():int;		function get targetX():int;		function set targetX(value:int):void;		function get targetY():int;		function set targetY(value:int):void;		function get angle():Number;		function set angle(value:Number):void;		function get velocity():Vector3D;		function set velocity(value:Vector3D):void;		function get acceleration():Vector3D;		function set acceleration(value:Vector3D):void;		function get directionToTurn():int;		function get frontVector():Vector3D;		function get creationTime():int;		function set creationTime(value:int):void;	}	}
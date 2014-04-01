﻿package AbtinPat{	import com.Engine.Sprites.IProjectile;	import flash.display.Sprite;	import flash.geom.Vector3D;		public class Laser extends Sprite implements IProjectile {				static public var maxSpeed:Number; //PIXELS PER SECOND		static public var maxSteering:Number; // RADIANS PER SECOND;		static public var maxAcceleration:Number; //PIXELS PER SECOND		static public var minAcceleration:Number; //PIXELS PER SECOND		//static public const handBrakeFriction:Number = .75;		static public const stoppingThreshold:Number = 0.1; //THRESHOLD FOR ROUNDING DOWN TO 0		static public const friction:Number = .95; //COEFFICIENT OF FRICTION OF THE "ROAD"				private var _velocity:Vector3D = new Vector3D();		private var _acceleration:Vector3D = new Vector3D();		protected var _angle:Number = 0; //ANGLE IN RADIANS				protected var _speed:Number;		private var _tempX:Number = 0;		private var _tempY:Number = 0;		private var _tempRotation:Number = 0;		private var _strength:int = 1;		private var _targetX:int = -1;		private var _targetY:int = -1;		private var _creationTime:int;				public function Laser(speed:Number = 0) {			this.speed = speed;		}				public function get strength():int {			return _strength;		}				public function get speed():Number {			return _speed;		}				public function set speed(value:Number):void {			_speed = value;		}				public function get tempX():Number {			return _tempX;		}				public function set tempX(value:Number):void {			_tempX = value;		}				public function get tempY():Number {			return _tempY;		}				public function set tempY(value:Number):void {			_tempY = value;		}				public function get tempRotation():Number {			return _tempRotation;		}				public function set tempRotation(value:Number):void {			_tempRotation = value;		}				public function get targetX():int {			return _targetX;		}				public function set targetX(value:int):void {			_targetX = value;		}				public function get targetY():int {			return _targetY;		}				public function set targetY(value:int):void {			_targetY = value;		}				public function updatePosition():void {			/*var angle:Number = Math.atan2(mouseY - _tempY, mouseX - _tempX);			_tempRotation = angle * (180 / Math.PI);			var xSpeed:Number = Math.cos(angle) * speed;			var ySpeed:Number = Math.sin(angle) * speed;			if (Math.abs(mouseX - _tempX) > Math.abs(xSpeed)) _tempX += xSpeed;			if (Math.abs(mouseY - _tempY) > Math.abs(ySpeed)) _tempY += ySpeed;*/		}				public function get angle():Number {			return _angle;		}				public function set angle(value:Number):void {			_angle = value;			_angle %= 2*Math.PI;			_tempRotation = _angle * (180 / Math.PI);		}				public function get velocity():Vector3D {			return _velocity;		}				public function set velocity(value:Vector3D):void {			_velocity = value;			if (_velocity.length > maxSpeed) {				var overage:Number = (_velocity.length - maxSpeed) / maxSpeed;				_velocity.scaleBy(1 / (1 + overage));			}			if (_velocity.length < stoppingThreshold) {				_velocity.x = _velocity.y = 0;			}		}				public function get creationTime():int {			return _creationTime;		}				public function set creationTime(value:int):void {			_creationTime = value;		}				public function get frontVector():Vector3D {			return new Vector3D(Math.cos(angle),Math.sin(angle));		}				public function get acceleration():Vector3D {			return _acceleration;		}				public function set acceleration(value:Vector3D):void {			_acceleration = value;		}				public function get directionToTurn():int {			return 0;		}	}	}
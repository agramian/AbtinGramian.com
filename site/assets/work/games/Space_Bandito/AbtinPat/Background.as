package AbtinPat 
{
	import flash.display.DisplayObject;
	import flash.display.MovieClip;
	import flash.geom.Point;
	import flash.geom.Rectangle;
	import flash.text.TextField;

	public class Background extends MovieClip
	{
		private var _rect:Rectangle;
		private var _r_img:Rectangle;
		private var _x_pos:Number;
		private var _y_pos:Number;
		private var _moons:DisplayObject;
		private var _outsideClouds:DisplayObject;
		private var _insideClouds:DisplayObject;
		private var _rings:DisplayObject;
		//private var _asteroidFloater:DisplayObject;
		//private var _asteroidCluster:DisplayObject;
		private var _home:DisplayObject;
		private var _bottomLayer:DisplayObject;
		private var _middleLayer:DisplayObject;
		private var _topLayer:DisplayObject;
		private var _layerList:Vector.<DisplayObject>;
		
		public function get rect():Rectangle { return _rect; };
		public function set rect(value:Rectangle):void { _rect = value; };
		public function get r_img():Rectangle { return _r_img; };
		public function set r_img(value:Rectangle):void { _r_img = value; };
		public function get x_pos():Number { return _x_pos; };
		public function set x_pos(value:Number):void { _x_pos = value; };
		public function get y_pos():Number { return _y_pos; };
		public function set y_pos(value:Number):void { _y_pos = value; };
	
		public function getMoons():DisplayObject { return _moons; };
		public function getOutsideClouds():DisplayObject { return _outsideClouds; };
		public function getInsideClouds():DisplayObject { return _insideClouds; };
		public function getRings():DisplayObject { return _rings; };
		//public function getAsteroidFloater():DisplayObject { return _asteroidFloater; };
		//public function getAsteroidCluster():DisplayObject { return _asteroidCluster; };
		public function getHome():DisplayObject { return _home; };
		public function get layerList():Vector.<DisplayObject> { return _layerList; };
		
		public function setupBackground(w:int,h:int):void {
			this.cacheAsBitmap = true;
			_rect = new Rectangle(0, 0,w, h);
			_x_pos = 0;
			_y_pos = 0;
			_rect.x = 0;
			_rect.y = 0;
			_r_img  = new Rectangle(0, 0, this.width, this.height);

			this.scrollRect = _rect;
			
			_layerList = new Vector.<DisplayObject>();
			_bottomLayer = getChildByName("bottomLayer");
			_middleLayer = getChildByName("middleLayer");
			_topLayer = getChildByName("topLayer");
			_layerList.push(_bottomLayer);
			_layerList.push(_middleLayer);
			_layerList.push(_topLayer);
		}
		
		public function setOuterWorldLevelReferences() {
			_topLayer.x = -_topLayer.width;
			_moons = (_middleLayer as MovieClip).getChildByName("moons");
			_outsideClouds = (_middleLayer as MovieClip).getChildByName("outsideClouds");
			(_outsideClouds as MovieClip).getChildByName("enterLevelText").alpha = 0;
			_rings = (_middleLayer as MovieClip).getChildByName("rings");
			_insideClouds = (_middleLayer as MovieClip).getChildByName("insideClouds");
			(_insideClouds as MovieClip).getChildByName("enterLevelText").alpha = 0;
			//_asteroidFloater = getChildByName("asteroidFloater");
			//_asteroidCluster = getChildByName("asteroidCluster");
			_home = (_middleLayer as MovieClip).getChildByName("home");
			(_home as MovieClip).getChildByName("enterLevelText").alpha = 0;
		}
		
		//public function showClickLevelText(
		
	}

}
/*
 *   sorisoft jQuery Plugin v0.1(alpha)
 *   Last Update: 03/03/18  10:45 P.M.
 *   Coded by: Arijit Kundu FB/imari9
 *   Functions:  i> Gesture API
 *              ii> SideBar
 *
 */
(function($){
	
	$.fn.onSwipe = function( options , callback ) {
		var settings = $.extend({
            direction: 'left',
			distance: '150',
			time: '250',
			padding: '70',
			moving: function(){}
        }, options );
		var start_x=0,start_y=0,end_x=0,end_y=0,start_time=0,end_time=0;
		
		this.on('touchstart',function(e){
			//e.stopPropagation(); 
			//e.preventDefault();
			var touch = e.touches[0] ;
			//alert(e.touches[0].clientX);
			start_x = touch.clientX ;
			start_y = touch.clientY ;
			start_time = Date.now();
		});
		
		this.on('touchmove',function(e){
			var touch = e.touches[0] ;
			end_x = touch.clientX ;
			end_y = touch.clientY ;
			end_time = Date.now();
			
			switch(settings.direction){
				case 'left':{
					if( ((start_x - end_x) > settings.distance) && ((end_time-start_time) < settings.time) ){
						callback();
						//callback.call(this.get());
						e.stopPropagation(); 
						e.preventDefault();
					}
				} break;
				case 'right':{
					if( ((end_x - start_x) > settings.distance) && ((end_time-start_time) < settings.time) ){
						callback();
						//callback.call(this.get());
						e.stopPropagation(); 
						e.preventDefault();
					}
				} break;
				case 'top':{
					if( ((start_y - end_y) > settings.distance) && ((end_time-start_time) < settings.time) ){
						callback();
						//callback.call(this.get());
					}
						e.stopPropagation(); 
						e.preventDefault();
				} break;
				case 'bottom':{
					if( ((end_y - start_y) > settings.distance) && ((end_time-start_time) < settings.time) ){
						callback();
						//callback.call(this.get());
						e.stopPropagation(); 
						e.preventDefault();
					}
				} break;
				case 'left-edge':{
					if((start_x < settings.padding) && ((end_x - start_x) > settings.distance) && ((end_time-start_time) < settings.time) ){
						callback();
						//callback.call(this.get());
					}
					else if((end_time-start_time) > settings.time){
						settings.moving(end_x,end_y);
						e.stopPropagation(); 
						e.preventDefault();
					}
				} break;
			}
			
		});
		
		this.on('touchend',function(e){
			//e.stopPropagation(); 
			//e.preventDefault();
		});
		
		
	};
	
	$.fn.SideBar = function( args ) {
		switch(typeof args){
			case 'string':{
				switch(args){
					case 'open':{
						this.removeClass('barclose').addClass('baropen');
					} break;
					case 'close':{
						this.removeClass('baropen').addClass('barclose');
					} break;
					case 'toggle':{
						if(this.is('.baropen')){
							this.removeClass('baropen').addClass('barclose');
						}
						else{
							this.removeClass('barclose').addClass('baropen');
						}
					} break;
				}
			} break;
			
			case 'object':{
				var settings = $.extend({
					position: 'left',
					state: 'close',
					width: 'auto',
					height: 'auto'
				}, args );
				this.addClass('SideBar').addClass(settings.position).addClass('bar' + settings.state);
			} break;
		}
		
	};
	
}( jQuery ));

jQuery.extend({
    isValidSelector: function(selector) {
        if (typeof(selector) !== 'string') {
            return false;
        }
        try {
            var $element = $(selector);
        } catch(error) {
            return false;
        }
        return true;
    }
});
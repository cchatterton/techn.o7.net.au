jQuery(document).ready(function($){

	
	var x,y,top,left,down;

	$("#ascm-repost-relatedpostlist-items-cont").on('mousedown',function(e){
	    e.preventDefault();
	    down=true;
	    x=e.pageX;
	    y=e.pageY;
	    top=$(this).scrollTop();
	    left=$(this).scrollLeft();
	});

	$("body").on('mousemove',function(e){
	    if(down){
	        var newX=e.pageX;
	        var newY=e.pageY;
	        
	        //console.log(y+", "+newY+", "+top+", "+(top+(newY-y)));
	        
	        $("#ascm-repost-relatedpostlist-items-cont").scrollTop(top-newY+y);    
	        $("#ascm-repost-relatedpostlist-items-cont").scrollLeft(left-newX+x);    
	    }
	});

	$("body").on('mouseup',(function(e){down=false;}));
});	
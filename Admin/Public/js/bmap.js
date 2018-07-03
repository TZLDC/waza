// 百度地图API功能
   var marker;
   var label;
   var map = new BMap.Map("allmap");      
   var geoc = new BMap.Geocoder(); 
  	
  	function current_init(longitude, latitude, zoom) {  
  	    map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
  	    map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
  	    map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
  	    map.enableScrollWheelZoom();                            //启用滚轮放大缩小
  	    //map.addControl(new BMap.MapTypeControl());  //添加地图类型控件
  	    
  	    var lat = '28.88801';
  	  	var lng = '105.44419';
  	    
  	  	if (latitude && longitude) {
  	  		lat = latitude;
  	  		lng = longitude;
  	  	}
  	  	
  		var point = new BMap.Point(lng, lat);
  		setLocationPoint(point, zoom);
	   	
  	}
  
   //单击获取点击的经纬度
   map.addEventListener("click",function(e){
       $("#lat").val(e.point.lat);
       $("#lon").val(e.point.lng);
       //坐标解析为地址
       var point = e.point;
       setLocationPoint(point, 18); 
   });
   
   //定位
   // 将地址解析结果显示在地图上,并调整地图视野
   function setLocationPoint(pt, zoom) {
   	 geoc.getLocation(pt, function(rs){                      
            var addComp = rs.addressComponents;
            var message = addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber;
            
            var point = new BMap.Point(pt.lng, pt.lat);
            map.centerAndZoom(point, zoom);
            // 将图层添加到地图上
            map.removeOverlay(marker);
            // 创建标注
            marker = new BMap.Marker(point);
            // 将标注添加到地图中
        	map.addOverlay(marker);       
        	marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        	//加上文字
        	label = new BMap.Label(message,{offset:new BMap.Size(20,-10)});
        	marker.setLabel(label);  
        });        
   }
   
   $('#map_search').click(function() {
	   var address = $('#map_address').val();
		if (address == '') {
			alert('请输入地址');
			return false;
		}
		else {
			setLocationAddress(address);
		}
   });
   //通过地址找到坐标
   function setLocationAddress(address) {		
	   	geoc.getPoint(address, function(point){
	   		if (point) {
	   			//map.centerAndZoom(point, 16);
	   			$("input[name='roadstatus[lat]']").val(point.lat);
	   	        $("input[name='roadstatus[lon]']").val(point.lng);
	   			//setMarker(point);
	            //setLabel(point, address);
	            setLocationPoint(point, 18);
	   		}
	   		else {
	   			alert('抱歉，地址未找到。');
	   		}
	   	}, '泸州市');       	
   }
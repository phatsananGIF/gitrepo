
var json = [];
	
function PageReady(){
	LoaduserLogin();
	LoadMapLocation();
	ShowMenu();
}


/////////// Show and hide body /////////////
function ShowMenu(textMenu) {
	
  switch(textMenu) {
    case "HOME":
	  $("#HOME").show();
      $("#TimeAttendance").hide();
	  $("#CheckInOut").hide();
	  $("#Mileage").hide();
	  $("#Usermanagement").hide();
	  LoadMapLocation();
      break;
    case "TimeAttendance":
	  $("#HOME").hide();
      $("#TimeAttendance").show();
	  $("#CheckInOut").hide();
	  $("#Mileage").hide();
	  $("#Usermanagement").hide();
      break;
    case "CheckInOut":
	  $("#HOME").hide();
      $("#TimeAttendance").hide();
	  $("#CheckInOut").show();
	  $("#Mileage").hide();
	  $("#Usermanagement").hide();
	  CheckInOut();
	  datepickerCheckInOut();
      break;
    case "Mileage":
	  $("#HOME").hide();
      $("#TimeAttendance").hide();
	  $("#CheckInOut").hide();
	  $("#Mileage").show();
	  $("#Usermanagement").hide();
      break;
    case "Usermanagement":
	  $("#HOME").hide();
      $("#TimeAttendance").hide();
	  $("#CheckInOut").hide();
	  $("#Mileage").hide();
	  $("#Usermanagement").show();
      break;
    // add case here

    default:
      //alert("hi");
	  $("#HOME").show();
      $("#TimeAttendance").hide();
	  $("#CheckInOut").hide();
	  $("#Mileage").hide();
	  $("#Usermanagement").hide();
	  
  }

}

/////////// Show user Login /////////////
function LoaduserLogin() {
$("#menuManage").hide();
$("#menuManagesmall").hide();
$("#Usermanagement").hide();

	$.ajax({  
			type:"POST",
			url:"sessionLogin.php",
			}).done(function(text){
				//alert(text);
				
				if(text == ""){
					alert("กรุณาเข้าสู่ระบบ");
					window.location.href = "Login.html";
					return false;
				}else{
					json = $.parseJSON(text);
					var userNameLogin = '<span class="glyphicon glyphicon-user"></span> '+json[0].name;
						$("#userLogin").html(userNameLogin);
						$("#userLoginSmall").html(userNameLogin);

					if((json[0].userid) == "admin"){
						$("#menuManage").show();
						$("#menuManagesmall").show();
					}
					
						var optloop="<option value=''>Select User</option>";
						for(i=0; i<json.length; i++){
							optloop+="<option value="+json[i]["userid"]+">"+json[i]["name"]+"</option>"; 
						}
						$("#SelectUser").html(optloop);
				}	
			});
	
	$('#BTSelectUser').on('click',function() {
		SelectUserVal = $("#SelectUser").val();
			if( SelectUserVal == "" ){
					alert ("กรุณาเลือก User !");
					return false ;
				}
		alert(SelectUserVal);
		var dataI={"SelectUserVal":SelectUserVal};
		$.ajax({
            type:"POST",
            url:"find_TB_LatLngOnline_SelectUser.php",
            cache:true,
            dataType:"JSON",
            data:dataI,
            async:true,
            success:function(result){
				if(result == null){
					alert ("ยังไม่มีข้อมูลการใช้งานของวันนี้ !");
					return false ;
				}
				alert(result[1]["date"]);
				myOptions = {
				  center: new google.maps.LatLng("13.9187387","100.7330838"),
				  zoom: 12,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				map = new google.maps.Map(document.getElementById("MapLocation"),myOptions);
				infowindow = new google.maps.InfoWindow();
					
				//loop for marker //
				for(x=0; x<result.length; x++){
						
					if(result[x]["lat"] != null){
						if(x == (result.length)-1){
							var image = 'images/iconMarker/male-2.png';
							detail = "";
							detail+='Date : '+result[x]["date"]+'<br/>';
							detail+='Location : '+result[x]["location"];
								
							myCenter = new google.maps.LatLng(result[x]["lat"],result[x]["lng"]);	
							marker = new google.maps.Marker({
								map:map, 
								html:detail,
								position: myCenter,
								icon: image
							});		
								
								
							//Show detail on load map
							// infowindow = new google.maps.InfoWindow({ 
								 // map:map, 
								 // content:detail,  
								 // position: myCenter, 
							 // }); 
								 
							map.panTo(marker.getPosition());
								
							 //Show detailon click
							google.maps.event.addListener(marker,'click',function(e){
							infowindow.setContent(this.html);
							infowindow.open(map,this);
							});
							
						}else{
							var imagepoint = 'images/iconMarker/point.png';
							detail = "";
							detail+='Date : '+result[x]["date"]+'<br/>';
							detail+='Location : '+result[x]["location"];
								
							myCenter = new google.maps.LatLng(result[x]["lat"],result[x]["lng"]);	
							marker = new google.maps.Marker({
								map:map, 
								html:detail,
								position: myCenter,
								icon: imagepoint
							});		
								
								
							//Show detail on load map
							// infowindow = new google.maps.InfoWindow({ 
								 // map:map, 
								 // content:detail,  
								 // position: myCenter, 
							 // }); 
								 
							map.panTo(marker.getPosition());
								
							 //Show detailon click
							google.maps.event.addListener(marker,'click',function(e){
							infowindow.setContent(this.html);
							infowindow.open(map,this);
							});
						}						
					}
				}
			}//end success
		});//end $.ajax 
	});//end searchbtn
}

/////////// Show user map /////////////
function LoadMapLocation(){
				$.ajax({
				type:"POST",
				url:"find_TB_LatLngOnline_All_Staff.php",
				cache:true,
				dataType:"JSON",
				async:false,
				success:function(result){
					
					var image = 'images/iconMarker/male-2.png';
					myOptions = {
					  center: new google.maps.LatLng("13.9187387","100.7330838"),
					  zoom: 10,
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					map = new google.maps.Map(document.getElementById("MapLocation"),myOptions);
					infowindow = new google.maps.InfoWindow();
					
					//loop for marker //
					for(x=0; x<result.length; x++){
						
						if(result[x]["lat"] != null){
							detail = "";
							detail+='<b>'+result[x]["userid"]+' : '+result[x]["name"]+'</b><br/>';
							detail+='Date : '+result[x]["date"];
							
							myCenter = new google.maps.LatLng(result[x]["lat"],result[x]["lng"]);	
							marker = new google.maps.Marker({
								map:map, 
								html:detail,
								position: myCenter,
								icon: image
							});		
							
							
							//Show detail on load map
							// infowindow = new google.maps.InfoWindow({ 
								 // map:map, 
								 // content:detail,  
								 // position: myCenter, 
							 // }); 
							 
							map.panTo(marker.getPosition());
							
							 //Show detailon click
							google.maps.event.addListener(marker,'click',function(e){
							infowindow.setContent(this.html);
							infowindow.open(map,this);
							});
							
						}
					}
				}//end success
			});//end $.ajax 	
}

////////// Show data table CheckInOut ////////////

function CheckInOut(){
	
	$('#BTSearchCheckInOut').click(function() {
		alert(sendStart);
		alert(sendEnd);
	}); //end BTSearchCheckInOut
	
			dataUser = "590131";
			sendStart = "111" ;
			sendEnd = "111" ;
			dataII={"dataUser":dataUser,"sendStart":sendStart,"sendEnd":sendEnd};  
			DataCHK ='<tbody>';      
			$.ajax({
				type:"POST",
				url:"checkbox.php",
				cache:true,
				dataType:"JSON",
				data:dataII,
				async:false,
				success:function(result){
					
					//alert(result.length);
					for(i=0; i<result.length; i++)
					{                    
						DataCHK += '<tr>';
						DataCHK += '<td>'+i+'</td>';
						DataCHK += '<td>'+result[i]["userid"]+'</td>';
						DataCHK += '<td style="text-align:left">'+result[i]["customer"]+'</td>';
						DataCHK += '<td style="text-align:left">'+result[i]["dateCheckIn"]+'</td>';
						DataCHK += '<td style="text-align:left">'+result[i]["locationCheckIn"]+'</td>';
						DataCHK += '<td style="text-align:left">'+result[i]["dateCheckOut"]+'</td>';
						DataCHK += '<td style="text-align:left">'+result[i]["locationCheckOut"]+'</td>';
						DataCHK += '<td style="text-align:left">'+result[i]["OperatingTime"]+'</td>';
						DataCHK += '</tr>';
					}//end for
					
                    DataCHK += '</tbody>';
					$("#tableCheckInOut").append(DataCHK);

					tableCheckInOut = $("#tableCheckInOut").DataTable({
						//responsive: true,
						//paging : false,
						destroy: true,  //Clear table
						lengthChange: false,
						lengthMenu: [
							[ 10, 25, 50, -1 ],
							[ '10 rows', '25 rows', '50 rows', 'Show all' ]
						],
						buttons: [ 'pageLength','excelHtml5'],
					});
					tableCheckInOut.buttons().container()
						.appendTo( '#tableCheckInOut_wrapper .col-sm-6:eq(0)' );
				}//end success
			});//end $.ajax  
}

var start = (moment().subtract(0, 'day').startOf('today'));
var end = (moment().subtract(0, 'day').endOf('today'));

function datepickerCheckInOut(){
		function cb(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				sendStart = start.format('YYYY/MM/DD');
				sendEnd = end.format('YYYY/MM/DD');
				selfaculty="";  //clear faculty seclect
				lastselfaculty="";  //clear lastselfaculty seclect
	  
		}//end function cb

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			applyClass: 'down',
			cancelClass:'down'  /*,
			ranges: {
				[start.format('YYYY-MMM')]: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				[moment().subtract(2, 'month').startOf('month').format('YYYY-MMM')]: [moment().subtract(2, 'month').startOf('month'), moment().subtract(2, 'month').endOf('month')],
				[moment().subtract(3, 'month').startOf('month').format('YYYY-MMM')]: [moment().subtract(3, 'month').startOf('month'), moment().subtract(3, 'month').endOf('month')],
				[moment().subtract(4, 'month').startOf('month').format('YYYY-MMM')]: [moment().subtract(4, 'month').startOf('month'), moment().subtract(4, 'month').endOf('month')]
			}*/
		}, cb);
		
		cb(start, end);
}//end function datepickerCheckInOut







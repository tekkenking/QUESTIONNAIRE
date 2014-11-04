//Debuger
function _debug(msg){
	"use strict";
	if(window.console){
		console.log(msg);
	}else{
		bootbox.alert(msg);
	}
}


//This function is used to test " cast of a variable "
function typeString(o) {
	  if (typeof o != 'object')
	    return typeof o;

	  if (o === null)
	      return "null";
	  //object, array, function, date, regexp, string, number, boolean, error
	  var internalClass = Object.prototype.toString.call(o).match(/\[object\s(\w+)\]/)[1];
	  return internalClass.toLowerCase();
}

//To correct the problem of persistent content on remote modalbox call
$('#remoteModal').on('hidden.bs.modal', function (e) {
   $('#remoteModal').removeData('bs.modal'); 
   $('#remoteModal .modal-content').html('');
})
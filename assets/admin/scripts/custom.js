function tablesorter() {
	$.extend($.tablesorter.themes.bootstrap, {
		table      : 'table table-bordered',
		header     : 'bootstrap-header', // give the header a gradient background
		footerRow  : '',
		footerCells: '',
		icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
		sortNone   : 'fa fa-sort',
		sortAsc    : 'fa fa-chevron-up',
		sortDesc   : 'fa fa-chevron-down',
		active     : '', // applied when column is sorted
		hover      : '', // use custom css here - bootstrap class may not override it
		filterRow  : '', // filter row class
		even       : '', // odd row zebra striping
		odd        : ''  // even row zebra striping
	});
	
	$(".tablesorter").tablesorter({
		theme : "bootstrap",
		widthFixed: false,
		headerTemplate : '{content} {icon}', 
		widgets : [ "uitheme", "filter", "zebra" ],
		widgetOptions : {
			zebra : ["even", "odd"],
			filter_reset : ".reset"
		},
		headers: {
			50 : {
	        	sorter: false,
	        	filter: false
	      	}
	    }
	});

	$(".tablesorter_stats").tablesorter({
		theme : "bootstrap",
		widthFixed: false,
		headerTemplate : '{content} {icon}', 
		widgets : [ "uitheme", "filter", "zebra" ],
		widgetOptions : {
			zebra : ["even", "odd"],
			filter_reset : ".reset"
		},
		headers: {
			
	    }
	})
}

var editDiv = '';
var addDiv = '';
var count = '';


$(document).ready(function(e){
	// $(".datepicker").datepicker({'format':'dd-mm-yyyy'});
	$(".check_form").validate();
	$(".check_form_2").validate();
	$(".datepicker").datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat: "dd-mm-yy",
		yearRange: "1945:2050"
	})
	$(".dob-validate").validate({
	  groups: {
	    dob: "day month year"
	  },
	  errorPlacement: function(error, element) {
	     if (element.attr("name") == "day" 
	                 || element.attr("name") == "month"|| element.attr("name") == "year" )
	       error.insertAfter("#year");
	     else
	       error.insertAfter(element);
	   },
	   debug:true
	 });
	$( "#sortable1" ).sortable();
	$( "#sortable1" ).disableSelection();

	$( "#sortable2, #sortable3, #sortable4, #sortable5, #sortable6, #sortable7, #sortable8, #sortable9, #sortable10" ).sortable(
		{
            update: function(event, ui) {
              // var divIdSort = $(this);
              // var count = 1;
              // $('#sortable2 tr').each(function(){
              // 	$(this).find('td').eq(0).html(count);
              // 	count++;
              // });
            }
         }
	);

	$( "#sortable2" ).disableSelection();


	tablesorter();
    $("table.tableFixHeader").floatThead({});

});

$.validator.addMethod("date_en", function(value, element) {
    return this.optional(element) || /^\d{2}-\d{2}-\d{4}$/.test(value);
  }, "Please select a valid date");

$.validator.addMethod('pdf', function(value, element) {
	var extension = value.substr( (value.lastIndexOf('.') +1) ).toLowerCase();
	console.log(extension);
    return this.optional(element) || (extension == 'pdf') 
}, "Please select a valid pdf file");

$.validator.addMethod('jpg', function(value, element) {
	var extension = value.substr( (value.lastIndexOf('.') +1) ).toLowerCase();
	console.log(extension);
    return this.optional(element) || (extension == 'jpg' || extension=='jpeg') 
}, "Please select a valid jpg/jpeg file");

$.validator.addMethod('filesize', function(value, element) {
    return this.optional(element) || (element.files[0].size <= 4194304) 
}, "Please select a PDF file less than 4 MB");

$.validator.addMethod('filesize_img', function(value, element) {
    return this.optional(element) || (element.files[0].size <= 1048576) 
}, "Please select a JPEG file less than 1 MB");



$(document).on("click", ".approve-coach", function() {
    var btn = $(this);
	bootbox.prompt("Remarks", function(result) {
      if(result === null || result == ''){
      	alert('Please enter some remarks');
      } else {
      	
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var deleteDiv = btn.attr('div-id');
		var count = btn.attr('count');
		var formAction = base_url+'/'+btn.attr('action')+'/'+result+'/'+count;
		$.ajax({
		    type: "GET",
		    url : formAction,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(!data.success) bootbox.alert(data.message);
		    	else {
		    		$('#'+deleteDiv).replaceWith(data.message);

			    	
		    	}

		    }
		},"json");

      }
    });
});
$(document).on("change", "#document_id", function() {
    var btn = $(this);
    if(btn.val()==0){
    	var htmlelement = '<div class="col-md-4 form-group" id="added-div"><label>Document Name</label><input type="text" name="doc_name" class="form-control" required="true"></div>';
    	$('#document-div').after(htmlelement);
    	
    }
    else{
    	$('#added-div').remove();
    }
});

$(document).on("change", "select#coach_role", function() {
    var btn = $(this);

    if(btn.val()!=6){
    	$('#roleName').addClass('hidden');
    }
    else {
    	$('#roleName').removeClass('hidden');
    }
});

$(document).on("change", "#UserType", function() {
    var btn = $(this);
    if(btn.val()==3){
    	$('#instructor').addClass('hidden');
    }
    else if(btn.val()==2){
    	$('#instructor').removeClass('hidden');
    }
});

$(document).on("click", ".apply-course", function() {
    var btn = $(this);
	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var formAction = base_url+'/'+btn.attr('action');
		$.ajax({
		    type: "GET",
		    url : formAction,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(!data.success) bootbox.alert(data.message);
		    	else {
		    		bootbox.alert(data.message);

			    	btn.html(data.btn_title);
			    	btn.addClass(data.add_class);
			    	btn.removeClass(data.remove_class);
			    	
		    	}

		    }
		},"json");

      }
    });
});
// Save ajax form

$(document).on("click", ".delete-div", function() {
    var btn = $(this);
	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var deleteDiv = btn.attr('div-id');
		
		var formAction = base_url+'/'+btn.attr('action');
		$.ajax({
		    type: "DELETE",
		    url : formAction,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success==false){
		    		bootbox.alert(data.message);
		    		btn.html(initial_html);
		    	}
		    	else {
		    		$("#"+deleteDiv).hide('500', function(){
		    			$("#"+deleteDiv).remove();
			    	});
			    	
		    	}

		    }
		},"json");

      }
    });
});

$(document).on("click", ".add-div", function() {

    var btn = $(this);
	$(".modal-body").html('Loading');
    $(".modal").modal('show');
	var initial_html = btn.html();
	addDiv = btn.attr('div-id');
	count = btn.attr('count');
	var title = btn.attr('modal-title');
	var formAction = base_url+'/'+btn.attr('action');
	$(".modal-title").html(title);
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	$(".modal-body").html(data);
				initialize();
	    }
	},"json");
});


$(document).on('click','form.ajax_add_pop button[type=submit]', function(e){
    e.preventDefault();
    if($(".ajax_add_pop").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
    	var repeatForm = form.attr('repeat-form');
		var dataString = form.serialize();
		var formAction = form.attr('action');
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#"+addDiv).append(data.message);
		    			btn.html(initial_html);
			    		
		    	} else {
		    		bootbox.alert(data.message);
			   		 

		    	}
			    $(".modal").modal('hide');
		    }
		},"json");
    }
});
$(document).on('click','.showApprovals',function(e){
	e.preventDefault();
	var btn = $(this);
	var toggleDiv = btn.attr('div-id');
	$('#'+toggleDiv).toggle();
	
});
$(document).on('click','form.ajax_add_payment button[type=submit]', function(e){
    e.preventDefault();
    if($(".ajax_add_payment").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
    	var repeatForm = form.attr('repeat-form');
		var dataString = form.serialize();
		dataString = dataString +'&count=' +count;
		var formAction = form.attr('action');
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#"+addDiv).replaceWith(data.row);
		    		$(".modal").modal('hide');
		    		bootbox.alert(data.message);
		    		btn.html(initial_html);

		    	} else {
		    		bootbox.alert(data.message);
		    		btn.html(initial_html);
			   		 

		    	}
		    		

			    
		    }
		},"json");
    }
});

$(document).on("click", ".edit-div", function() {
    var btn = $(this);
    $(".modal").modal('show');
	$(".modal-body").html('Loading');
	var initial_html = btn.html();
	editDiv = btn.attr('div-id');
	count = btn.attr('count');
	var title = btn.attr('modal-title');
	var formAction = base_url+'/'+btn.attr('action');
	$(".modal-title").html(title);
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	$(".modal-body").html(data);
	    	initialize();
	    }
	},"json");

});

$(document).on('click','form.ajax_edit_pop button[type=submit]', function(e){
    e.preventDefault();
    if($(".ajax_edit_pop").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		dataString = dataString + "&count=" + count;
		var formAction = form.attr('action');
		$.ajax({
		    type: "PUT",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);

		    	if(data.success){

		    		$("#"+editDiv).replaceWith(data.message);
			    	$(".modal").modal("hide");
					if(data.confirm){bootbox.alert(data.message);}
		    	} else {
		    		bootbox.alert(data.message);
		    	}
			    btn.html(initial_html);
		    }
		},"json");
    }
});

// $(document).on('click','form.update-marks button[type=submit]', function(e){
//     e.preventDefault();
//     if($(".update-marks").valid()){
//     	var btn = $(this);
//     	var initial_html = btn.html();
//     	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
//     	var form = jQuery(this).parents("form:first");
// 		var dataString = form.serialize();
// 		var setPrice =form.attr('set-price');
// 		dataString = dataString + "&count=" + count;
// 		var formAction = form.attr('action');
// 		$.ajax({
// 		    type: "PUT",
// 		    url : formAction,
// 		    data : dataString,
// 		    success : function(data){
// 			    btn.html(initial_html);
// 			    $(".modal").modal("hide");
// 			    alert('MarkSheet Updated!');
// 		    }
// 		},"json");
//     };
// });

$(document).on('click','.mark-application', function(e){
    e.preventDefault();
  
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var rmvDiv = btn.attr('div-id');
		var count1 = btn.attr('count');
		
		var formAction = base_url + '/'+ btn.attr('action') + '/'+count1;
		$.ajax({
		    type: "GET",
		    url : formAction,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#"+rmvDiv).replaceWith(data.message);
			    	$(".modal").modal("hide");
		    	} else {
		    		bootbox.alert(data.message);
		    	}
			    btn.html(initial_html);
		    }
		},"json");
});

$(document).on("click", ".details", function() {
    var btn = $(this);
    $(".modal").modal('show');
	$(".modal-body").html('Loading');
	var initial_html = btn.html();
	
	var title = btn.attr('modal-title');
	var formAction = btn.attr('action');
	
	$(".modal-title").html(title);
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	if(data.success){
	    		$(".modal-body").modal("hide");
	    	}
	    	else{
	    		$(".modal-body").html(data);
	    	}
	    }
	},"json");

});


function initialize(){
	$(".check_form").validate();

	$(".datepicker").datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat: "dd-mm-yy",
		yearRange: "1970:2018"
	})
	tablesorter();
	$('.dropzone').dropzone({
		addRemoveLinks: true, 
	});

	$('.select').select2();
}


$('.select').select2();

$(document).on("submit", ".ajax_check_form", function(e) {
	e.preventDefault();
});

$(document).on("click", ".payment-radio", function() {
	var btn = $(this);
	$('.payment_details').attr('required',true);


});
$(document).on('click','#cash',function(){
	$('.payment_details').removeAttr('required');
})
$('.dropzone').dropzone();


$(document).on("click", "#addRow", function(e) {
	var sn = $('#applicant_list tr:last').attr('idv');

	sn = parseFloat(sn) + parseFloat(1);
	
	var div = '<tr idv='+sn+'><td style="width:50px;">'+sn+'</td><td><input type="text" name="applicant_name_'+sn+'" class="form-control" placeholder="Applicant name"></td><td>		<input type="text" name="issue_date_'+sn+'" class="form-control datepicker"  placeholder="license issue date"  date_en = "date_en">	</td>	<td>		<input type="text" name="license_number_'+sn+'" class="form-control" placeholder="license number">	</td>	<td>		<input type="text" name="remarks_'+sn+'" class="form-control" placeholder="remarks">	</td></tr>';

	$('#applicant_list').append(div);	

	initialize();

});

$(document).on("change","#coach-license",function(){
	if($(this).val() == "21"){
		$("#div-recc").show(300);
		$("#recc").attr('checked',false);

	}else{
		$("#div-recc").hide(300);
		$("#recc").attr('checked',false);
	}

});

$(document).on("change","#recc",function(){
	if(this.checked){
		$("#equivalent-license-div").show(300);
		$("#recc_document").prop('required', true);
	}else{
		$("#equivalent-license-div").hide(300);

	}

});


$(document).on("change","#emp_status",function(){
	var btnVal = $(this).val();
	if(btnVal == 3){
		$(".emp_validate ").parent().hide();
		$(".emp_validate ").parent().addClass('hiddenDiv');
		initialize();
		
	}else{
		$(".emp_validate").parent().show();
		$(".emp_validate").parent().removeClass('hiddenDiv');
		initialize();

	}

});

$(document).on("change","#designation_id",function(){
	var btnVal = $(this).val();
	if(btnVal == 0){
		$("#designation_name").show();
		
	}else{
		$("#designation_name").hide();
	}

});


$(document).on("change","#organization_type",function(){
	var btn = $(this).val();
	if(btn == 0){
		$("#organization_name").removeClass('hiddenDiv');
		$("#clubs").addClass('hiddenDiv');
		$("#associations").addClass('hiddenDiv');
		$("#schools").addClass('hiddenDiv');
	}else if(btn == 1){
		$("#organization_name").addClass('hiddenDiv');
		$("#clubs").addClass('hiddenDiv');
		$("#associations").removeClass('hiddenDiv');
		$("#schools").addClass('hiddenDiv');
	}else if(btn == 2){
		$("#organization_name").addClass('hiddenDiv');
		$("#clubs").removeClass('hiddenDiv');
		$("#associations").addClass('hiddenDiv');
		$("#schools").addClass('hiddenDiv');
	}else if(btn == 3){
		$("#organization_name").addClass('hiddenDiv');
		$("#clubs").addClass('hiddenDiv');
		$("#associations").addClass('hiddenDiv');
		$("#schools").removeClass('hiddenDiv');
	}
	initialize();
});

$(document).on("change","#domicile_state",function(){
	var btnVal = $(this).val();
	if(btnVal == 37){
		$(".domicile_state ").show();
		
	}else{
		$(".domicile_state").hide();

	}

});

$(document).on("change","#address_state",function(){
	var btnVal = $(this).val();
	if(btnVal == 37){
		$(".address_state ").show();
		
	}else{
		$(".address_state").hide();

	}

});

$(document).on("change","#registration_for",function(){
	var btnVal = $(this).val();
	if(btnVal == 1){
		$("#license_data ").show();
		$("#official_degree ").hide();
		
	}else{
		$("#license_data").hide();
		$("#official_degree").show();

	}

});

$(document).on("change","#is_doctor",function(){
	var btnVal = $(this).val();
	if(btnVal == 1){
		$("#upload_degree ").show();
		
	}else{
		$("#upload_degree").hide();

	}

});
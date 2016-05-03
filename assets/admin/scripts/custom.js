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


$(document).ready(function(e){
	$(".datepicker").datepicker({'format':'yyyy-mm-dd'});
	$(".check_form").validate();
	$(".check_form_2").validate();
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
	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var deleteDiv = btn.attr('div-id');
		
		var formAction = base_url+'/'+btn.attr('action');
		$.ajax({
		    type: "GET",
		    url : formAction,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(!data.success) bootbox.alert(data.message);
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


$(document).on("click", ".apply-course", function() {
    var btn = $(this);
	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var deleteDiv = btn.attr('div-id');
		
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
		    	if(!data.success) bootbox.alert(data.message);
		    	else {
		    		$("#"+deleteDiv).hide('500', function(){
		    			$("#"+deleteDiv).remove();
			    	});
			    	// $("#"+editDiv).html(data.message);
			    	// $("#"+showDiv).show();
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
		var setPrice =form.attr('set-price');
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
		    	} else {
		    		bootbox.alert(data.message);
		    	}
			    btn.html(initial_html);
		    }
		},"json");
    }
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
	    	$(".modal-body").html(data);
	    }
	},"json");

});

function initialize(){
	$(".datepicker").datepicker({'format':'yyyy-mm-dd'});
	tablesorter();
}



$(document).on("submit", ".ajax_check_form", function(e) {
	e.preventDefault();
});

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
	$(".datepicker").datepicker({'format':'dd-mm-yyyy'});
	$(".check_form").validate();
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

// Save ajax form
$(document).on('click','form.ajax_update button[type=submit]', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		var formAction = form.attr('action');
		$.ajax({
		    type: "PUT",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){

		    	} else {
		    		bootbox.alert(data.message);
		    	}
		    	btn.html(initial_html);
		    }
		},"json");
    }
});

$(document).on("click", ".delete-div", function() {
    var btn = $(this);
	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var deleteDiv = btn.attr('div-id');
		var editDiv = btn.attr('edit-div-id');
		var showDiv = btn.attr('show-div-id');
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
			    	$("#"+editDiv).html(data.message);
			    	$("#"+showDiv).show();
		    	}

		    }
		},"json");

      }
    });
});

$(document).on("click", ".edit-div", function() {
    var btn = $(this);
    $(".modal").modal('show');
	$(".modal-body").html('Loading');
	var initial_html = btn.html();
	editDiv = btn.attr('div-id');
	var title = btn.attr('modal-title');
	var formAction = base_url+'/'+btn.attr('action');
	$(".modal-title").html(title);
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	$(".modal-body").html(data);
	    }
	},"json");

});

$(document).on('click','form.ajax_update_pop button[type=submit]', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
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

$(document).on('click','form.ajax_add_pop button[type=submit]', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		var formAction = form.attr('action');
		var modalHide = form.attr('modal-hide');
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#"+addDiv).append(data.message);
		    		if(!modalHide) $(".modal").modal("hide");
		    	} else {
		    		bootbox.alert(data.message);
		    	}
			    btn.html(initial_html);
		    }
		},"json");
    }
});

$(document).on('click','form.ajax_add button[type=submit]', function(e){
    e.preventDefault();
    var btn = $(this);
	var addDiv = $(this).attr("div-id");
	var initial_html = btn.html();
	var form = $(this).parents("form:first");

	//if events
	// if(addDiv == 'events_1' || addDiv == 'events_2'){
	// 	var type = form.find('select[name=type]').eq(0);
	// 	if(type){
	// 		addDiv = addDiv + '_' + type.val();
	// 	}
	// }
	
	var dataString = form.serialize();
	var formAction = form.attr('action');
    if(form.valid()){
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#"+addDiv).append(data.message);
		    		form.trigger('reset');
		    	} else {
		    		bootbox.alert(data.message);
		    	}
			    btn.html(initial_html);
		    }
		},"json");
    }
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

$(document).on('click','#search_team', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		var formAction = base_url + '/search_teams';
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	$("#teamSearchResults").html(data);
    			btn.html(initial_html);
		    }
		},"json");
    }
});

function initialize(){
	$(".datepicker").datepicker({'format':'dd-mm-yyyy'});
	tablesorter();
}

$(document).on('click','.add_team', function(e){
	e.preventDefault();
	var btn = $(this);
	var initial_html = btn.html();
	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
	var team_id = $(this).attr('team-id');
	var tournament_id = $(this).attr('tournament-id');
	var email = $(this).parent().parent().find("input.form-control").val();
	if (email.match(/([\w\-]+\@[\w\-]+\.[\w\-]+)/) == null){
		bootbox.alert('Please provide a valid email');
		btn.html(initial_html);
	} else {
		var formAction = base_url + '/tournaments/teams/add/'+tournament_id;
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : {team_id:team_id, email:email},
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#sortable1").append(data.message);
		    		$(".modal").modal("hide");
		    	} else {
		    		bootbox.alert(data.message);
					btn.html('Add Team');
		    	}
		    }
		},"json");
	}
	
});

$(document).on('click','#search_player', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		var formAction = base_url + '/search_player';
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	$("#PlayerSearchResults").html(data);
    			btn.html(initial_html);
		    }
		},"json");
    }
});

$(document).on('click','.add_player', function(e){
    e.preventDefault();
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var player_id = $(this).attr('player-id');
    	var tournament_id = $(this).attr('tournament-id');
    	var initial_html = btn.html();
		var formAction = base_url + '/teams/players/add/'+tournament_id;
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : {player_id:player_id},
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#players").append(data.message);
		    		$("input[name=player_name]").val('');
		    		btn.html('Add to Tournament');
		    	} else {
		    		bootbox.alert(data.message);
    				btn.html('Add to Tournament');
		    	}
		    }
		},"json");
});

$(document).on('click','.doc_toggle', function(e){
	$('.document_box').slideUp();
	if(!$(this).hasClass('opened')){
		$(this).parent().find('.document_box').slideToggle()
		$(".doc_toggle").removeClass('opened');
		$(this).addClass('opened');
	} else {
		$(this).removeClass('opened');
	}
});

$(document).on('click','.upload', function(e){
    e.preventDefault();
	var btn = $(this);
	var initial_html = btn.html();
    var form = jQuery(this).parents("form:first");
    if($(form).valid()){
		btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		form.submit();
    }

    // var form = jQuery(this).parents("form:first");
    // form.submit();	
});

$(document).on('click','#add_official', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		var formAction = base_url + '/teams/officials/add';
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#officials").append(data.message);
		    		$(".modal").modal("hide");
		    	} else {
		    		bootbox.alet(data.message);
		    	}
    			btn.html(initial_html);
		    }
		},"json");
    }
});

$(document).on('click','#search_official', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		var formAction = base_url + '/teams/officials/search';
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#OfficialSearchResults").html(data.message);
		    	} else {
		    		bootbox.alet(data.message);
		    	}
    			btn.html(initial_html);
		    }
		},"json");
    }
});

$(document).on('click','.add_official', function(e){
    e.preventDefault();
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var official_id = $(this).attr('official-id');
    	var tournament_id = $(this).attr('tournament-id');
    	var initial_html = btn.html();
		var formAction = base_url + '/teams/officials/add/search/'+tournament_id;
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : {official_id:official_id},
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		$("#officials").append(data.message);
		    		$("input[name=official_name]").val('');
		    		btn.html('Add to Tournament');
		    	} else {
		    		bootbox.alert(data.message);
    				btn.html('Add to Tournament');
		    	}
		    }
		},"json");
});

$(document).on("click", ".verify_toggle", function() {
    var btn = $(this);
	var initial_html = btn.html();
    btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
	addDiv = btn.attr('div-id');
	var formAction = base_url+'/'+btn.attr('action');
	$.ajax({
	    type: "PUT",
	    url : formAction,
	    success : function(data){
	    	data = JSON.parse(data);
	    	if(data.success){
	    		$("#"+addDiv).find('.verify_text').html(data.message);
	    		btn.addClass(data.color).removeClass(data.colorrem);
	    		btn.html(data.text);
	    	} else {
	    		bootbox.alert(data.message);
	    	}
	    }
	},"json");
});

$(document).on('click','#search_referee', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		var formAction = base_url + '/search_referees';
		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	$("#refereeSearchResults").html(data);
    			btn.html(initial_html);
		    }
		},"json");
    }
});

$(document).on('click','.add_referee', function(e){
    e.preventDefault();
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var referee_id = $(this).attr('referee-id');
    	var tournament_id = $(this).attr('tournament-id');
    	var email = $(this).parent().parent().find("input.form-control").val();

    	var priv = [];
		$("input[name='type_"+referee_id+"[]']:checked").each(function(){priv.push($(this).val());});
		priv = priv.join();
    	
    	if(priv != ''){
    		if (email.match(/([\w\-]+\@[\w\-]+\.[\w\-]+)/) == null){
				bootbox.alert('Please provide a valid email');
				btn.html(initial_html);
			} else {
				var formAction = base_url + '/tournaments/referees/add/'+tournament_id;
				$.ajax({
				    type: "POST",
				    url : formAction,
				    data : {referee_id:referee_id,email:email,priv:priv},
				    success : function(data){
				    	data = JSON.parse(data);
				    	if(data.success){
				    		$("#div_referee").append(data.message);
		    				btn.html(initial_html);
				    		
				    		// $(".modal").modal("hide");
				    	} else {
				    		bootbox.alert(data.message);
		    				btn.html(initial_html);
				    	}
				    }
				},"json");
			}
    	} else {
    		bootbox.alert('Please select match official type');
			btn.html(initial_html);
    	}
});

$(document).on('change','.main_reason', function(e){
    e.preventDefault();
	var select = $(this);
	var event_id = $(this).attr('event-id');
	var main_reason = $(this).val();
	var formAction = base_url + '/referee/sub_reasons/'+main_reason;
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	data = JSON.parse(data);
	    	if(data.success){
	    		$("select[name=sub_reason_" + event_id+"]").html(data.message);
	    	} else {
	    		bootbox.alert(data.message);
	    	}
	    }
	},"json");
});

$(document).on('change','.sentoff_main_reason', function(e){
    e.preventDefault();
	var select = $(this);
	var event_id = $(this).attr('event-id');
	var main_reason = $(this).val();
	var formAction = base_url + '/referee/sentoff_sub_reasons/'+main_reason;
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	data = JSON.parse(data);
	    	if(data.success){
	    		$("select[name=sub_reason_" + event_id+"]").html(data.message);
	    	} else {
	    		bootbox.alert(data.message);
	    	}
	    }
	},"json");
});

$(document).on("click", ".reset-password", function() {
    var btn = $(this);
	var initial_html = btn.html();
    btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
	var data = btn.attr('data-id');
	var formAction = base_url+'/reset-password/'+data;
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
    		btn.html(initial_html);
	    }
	},"json");

});

$(document).on("submit", ".ajax_check_form", function(e) {
	e.preventDefault();
});

$(document).on("change", ".official-type", function(e) {
	var val = $(this).find("option:selected").val();

	if( val == 3 ){
		$(this).parent().find("input.official-role").show().attr("required","true");
	} else {
		$(this).parent().find("input.official-role").hide().removeAttr("required");
		$(this).parent().find("input.official-role").val('');
	}
});

$(document).on("keyup", ".minute", function(e) {
	var val = $(this).val();

	if( val == 45 || val == 90 || val == 105 || val == 120 ){
		$(this).parent().find(".plus_sign").show();
		$(this).parent().find(".plus_time").css('display','inline');
	} else {
		$(this).parent().find(".plus_sign").hide();
		$(this).parent().find(".plus_time").css('display','none');
	}
});
$(document).on("change","#playerAssociationId",function(e){
	e.preventDefault();
	var datatosend = $("#playerAssociationId").serialize();
	$.ajax({
	    type: "POST",
	    url : base_url+'/crs_admin/players/getClub',
	    data : datatosend,
	    success : function(data){
	    	data = JSON.parse(data);

	    	if(data.success==true){
	    		var club = data.message;

		    		console.log(club);
		    		var str = '';
		    		for (var i = club.length - 1; i >= 0; i--) {
		    			str += '<option value="'+club[i].id+'">'+club[i].value+'</option>'; 
		    		};
		    		
	    		 $("#playerClubId").html(str);
		    	
	    	} else {
	    		bootbox.alert(data.message);
	    	}
	    }
	});
});
$(document).on("change","#playerAssociationId",function(e){
	e.preventDefault();
	var datatosend = $("#playerAssociationId").serialize();
	$.ajax({
	    type: "POST",
	    url : base_url+'/teams/teamClub/players/getClub',
	    data : datatosend,
	    success : function(data){
	    	data = JSON.parse(data);

	    	if(data.success==true){
	    		var club = data.message;

		    		console.log(club);
		    		var str = '';
		    		for (var i = club.length - 1; i >= 0; i--) {
		    			str += '<option value="'+club[i].id+'">'+club[i].value+'</option>'; 
		    		};
		    		
	    		 $("#playerClubId").html(str);
		    	
	    	} else {
	    		bootbox.alert(data.message);
	    	}
	    }
	});
});
$(document).on("click", ".details", function() {
    var btn = $(this);
    $(".modal").modal('show');
	$(".modal-body").html('Loading');
	var initial_html = btn.html();
	
	var title = btn.attr('modal-title');
	var formAction = base_url+'/'+btn.attr('action');
	
	$(".modal-title").html(title);
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	$(".modal-body").html(data);
	    }
	},"json");

});

$(document).on("click", ".approve-div", function() {
    var btn = $(this);
	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
		var divId = btn.attr('div-id');
		var divEmptyId = btn.attr('div-empty-id');
		var formAction = base_url+'/'+btn.attr('action');
		$.ajax({
		    type: "PUT",
		    url : formAction,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(!data.success) bootbox.alert(data.message);
		    	else {
		    		$("#"+divId).html(data.message);
		    		if(divEmptyId){
		    			$("#"+divEmptyId).html('');
		    		}
		    	}

		    }
		},"json");

      }
    });
});
$(document).on("click", ".create-report", function() {
    $(this).html('Creating Report...');

});

$(document).on("click", ".refresh-div", function() {
    var btn = $(this);
	var initial_html = btn.html();
    btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
	addDiv = btn.attr('div-id');
	var formAction = base_url+'/'+btn.attr('action');
	var replace = btn.attr('replace');
	var btnDiv = btn.attr('btn-div');
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	// alert(data);
	    	data = JSON.parse(data);
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		if(replace == 1){
	    			$("#"+addDiv).replaceWith(data.message);
	    		} else {
	    			$("#"+addDiv).html(data.message);	    			
	    		}
	    	}
	    	if(btnDiv == 1){

	    	} else{
	    		btn.html(initial_html);
	    	}
	    }
	},"json");

});

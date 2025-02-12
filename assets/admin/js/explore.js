/** Search Box Change **/
$(document).ready(function() {
	$("#explore_search").change(function(){
		$("#form_explore").submit();
	});
});
/** Search Box Change **/

/** Click on Suggestions **/
$(document).ready(function() {
	$('.suggest_clickable').click(function() {
		var thisid = $(this).data('id');
		$("#explore_search").val(thisid);
		$("#form_explore").submit();
	});
});
/** Click on Suggestions **/

/** Search Box Inner Change **/
$(document).ready(function() {
	$("#explore_details_search").change(function(e){
		var selectionid = $("#explore_details_search").val();
		var strfrdp = $("#exploresearch_selection").val();
		//Check if already added in the field or not
		if( strfrdp.match(new RegExp("(?:^|,)"+selectionid+"(?:,|$)")))
		{
			alert(validationmsg43);
			$("#explore_details_search").val('');
			return false;
		}
		else
		{
			//Add in field
			var dynval = $("#exploresearch_selection").val();
			if(dynval != '') {
				dynval += ',' + selectionid;
			}
			else {
				dynval = selectionid;
			}
			$("#exploresearch_selection").val(dynval);
			//Display in list
			$(".searchlists").append('<li id="'+selectionid+'" onclick="remove_selection(this.id)"><a href="javascript:void(0)" class="closex">X</a> <a href="javascript:void(0)">'+$("#explore_details_search option:selected").text()+'</a></li>');
			$("#explore_details_search").val('');
			jloadpage();
		}
	});
});
/** Search Box Inner Change **/

/** Remove Selection **/
function remove_selection(selection)
{
	var dynval = $("#exploresearch_selection").val();
	var list = dynval;
	var value = selection;
	var separator = ",";
	var values = list.split(separator);
	for(var i = 0 ; i < values.length ; i++) {
		if(values[i] == value) {
			values.splice(i, 1);
			dynval=values.join(separator);
		}
	}
	$("#exploresearch_selection").val(dynval);
	$("#"+selection).remove();
	var noof_li = $('#ullists ul li').length;
	if(noof_li == 0) {
		location.href=location.href;
	}
	else {
		jloadpage();
	}
}
/** Remove Selection **/

/** Sidebar Select Preferences / Job Levels **/
jQuery(document).ready(function() {
	jQuery('input[name="preferences"]').click(function(e) {
		var thisid = $(this).attr('id');
		var preferid = $(this).val();
		if(thisid != "all_preference") {
			var totcheck = $('input[name="preferences"]:checked').length;
			if(totcheck == 0) {
				$("#all_preference").prop('checked', true);
			}
			else {
				$('#all_preference').prop('checked', false);
			}
		}
		else {
			if( $("#all_preference").is(":checked")){
				$('.preferences_chk').prop('checked', false);
			}
			else {
				e.preventDefault();
        		return false;
			}
		}
		jloadpage();
	});
});
/** Sidebar Select Preferences / Job Levels **/

/** Sidebar Select Hours **/
jQuery(document).ready(function() {
	jQuery('input[name="hours"]').click(function(e) {
		var thisid = $(this).attr('id');
		var preferid = $(this).val();
		if(thisid != "all_hours") {
			var totcheck = $('input[name="hours"]:checked').length;
			if(totcheck == 0) {
				$("#all_hours").prop('checked', true);
			}
			else {
				$('#all_hours').prop('checked', false);
			}
		}
		else {
			if( $("#all_hours").is(":checked")){
				$('.hours_chk').prop('checked', false);
			}
			else {
				e.preventDefault();
        		return false;
			}
		}
		jloadpage();
	});
});
/** Sidebar Select Hours **/

/** Sidebar Select Contract Type **/
jQuery(document).ready(function() {
	jQuery('input[name="contracttype"]').click(function(e) {
		var thisid = $(this).attr('id');
		var preferid = $(this).val();
		if(thisid != "all_contracttype") {
			var totcheck = $('input[name="contracttype"]:checked').length;
			if(totcheck == 0) {
				$("#all_contracttype").prop('checked', true);
			}
			else {
				$('#all_contracttype').prop('checked', false);
			}
		}
		else {
			if( $("#all_contracttype").is(":checked")){
				$('.contracttype_chk').prop('checked', false);
			}
			else {
				e.preventDefault();
        		return false;
			}
		}
		jloadpage();
	});
});
/** Sidebar Select Contract Type **/


/**
	Change explore search criteria based on selection
	Call Ajax
**/
function jloadpage()
{
	$("#filtered_rec").prepend('<div class="sspinner"><i style="color:#377b9e" class="fa fa-spinner fa-spin fa-2x"></i> <span style="color:#377b9e">'+validationmsg16+'...</span></div>');
	var ex_sel = $("#exploresearch_selection").val();
	var preferences = new Array(); var hours = new Array(); var contracttype = new Array();
	$('input[name="preferences"]:checked').each(function() {
		preferences.push($(this).val());
	});
	$('input[name="hours"]:checked').each(function() {
		hours.push($(this).val());
	});
	$('input[name="contracttype"]:checked').each(function() {
		contracttype.push($(this).val());
	});
	
	$.ajax({
		type: "POST",
		url: base_url+"explore/search/?exploresearch_selection="+ex_sel+'&preferences='+preferences+'&hours='+hours+'&contracttype='+contracttype,
		cache: false,
		processData: false,
		success: function(response) {
			var resval = jQuery.parseJSON(response);
			$("#filtered_rec").html(resval['details']);
			$(".totjobs").html(resval['tot_no_jobs'] + " JOBS");
			$(".sspinner").remove();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
		}
	});
}
/** End Call Ajax **/
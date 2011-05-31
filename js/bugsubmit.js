/**********************************************************************
 * General-purpose functions for switching between slides on the
 * LibreOffice Bug Submitter. With a little work, it could be used for
 * other presentation-style branching web pages.
 * 
 * Copyright 2011 Samuel Atkins <sam@samatkins.co.uk>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

// Global variable holding the ID of the currently visible slide
var currentSlide = "slide_introduction";

/**
 * Disable prev/next buttons on the slide with the given id
 */
function disableButtonsOnSlide(id) {
	$("div#" + id).find('div.buttons button').attr('disabled', 'disabled');
}

/**
 * Enable prev/next buttons on the slide with the given id
 */
function enableButtonsOnSlide(id) {
	$("div#" + id).find('div.buttons button').attr('disabled', false);
}

/**
 * Display, and go to the specified slide ID
 */
function scrollToId(id) {
	disableButtonsOnSlide(currentSlide);
	$("div#" + id).removeClass('hide');
	$("div#slides").scrollTo("div#" + id, {speed:1000, easing:"swing"});
	currentSlide = id;
	enableButtonsOnSlide(currentSlide);
}

/**
 * Go back to the previous visible slide
 */
function scrollBack(id) {
	disableButtonsOnSlide(currentSlide);
	$("div#slides").scrollTo("-=780px", {speed:1000, easing:"swing", onAfter: function(){
		$("div#" + currentSlide).addClass('hide');
		currentSlide = id;
		enableButtonsOnSlide(currentSlide);
	}});
}

/**
 * Go to the given slide if the specified radio list input has
 * a value selected.
 */
function scrollToIdIfRadioSelected(id, inputName) {
	var selected = $('input[name="' + inputName + '"]:checked');
	if (selected.length >= 1) {
		disableButtonsOnSlide(currentSlide);
		$("div#" + currentSlide + "_novalue").addClass('hide');
		$("div#" + id).removeClass('hide');
		$("div#slides").scrollTo("div#" + id, {speed:1000, easing:"swing"});
		currentSlide = id;
		enableButtonsOnSlide(currentSlide);
	} else {
		$("div#" + currentSlide + "_novalue").removeClass('hide');
	}
}

/**
 * Go to a slide based on the option selected in the given input.
 */
function scrollToIdFromValue(idBase, inputName) {
	var selected = $('input[name="' + inputName + '"]:checked');
	if (selected.length == 1) {
		disableButtonsOnSlide(currentSlide);
		var id = idBase + '_' + $('input[name="' + inputName + '"]:checked').val();
		$("div#" + id).removeClass('hide');
		$("div#slides").scrollTo("div#" + id, {speed:1000, easing:"swing"});
		$("div#" + idBase + "_novalue").addClass('hide');
		currentSlide = id;
		enableButtonsOnSlide(currentSlide);
	} else {
		$("div#" + idBase + "_novalue").removeClass('hide');
	}
}

/**
 * Show or hide a series of divs, so that the only one visible, out of a group,
 * is the one relevant to the selection.
 * groupName is the id used for that group (without the _option or _div suffix)
 * choice is the wanted div's id suffix
 */
function showDivFromGroup(groupName, choice) {
    // Iterate through the children of the container
    var children = $("div#"+groupName+"_container div");
    $.each(children, function(index,value) {
		if (value.id == groupName + "_" + choice + "_div") {
			$(this).slideDown("slow");
		} else {
			$(this).slideUp("slow");
		}
	});
}

/**
 * Display a help blurb in the sidebar, hiding the others.
 * topic is the name of the div without the "help_" prefix.
 */
function showHelp(topic) {
	$("div#help_"+topic).css({width:0}).prependTo("div#"+currentSlide).animate({width: "45%"});
}

function hideHelp() {
	$("div.help_content").animate({width: 0}, function() {
		$(this).appendTo("div#help");
	});
}

/**
 * Show or hide the element with the given id, based on a checkbox value.
 */
function showFromCheckbox(checkbox, id) {
	if (checkbox.checked) {
		$("#"+id).slideDown("slow");
	} else {
		$("#"+id).slideUp("slow");
	}
}

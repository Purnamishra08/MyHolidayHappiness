jQuery(document).ready(function () {
	var base_url = "<?php echo base_url(); ?>";
	jQuery.validator.addMethod("alphanumeric", function (value, element) {
		return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
	}, "String must contain only letters, numbers, or dashes.");

	jQuery.validator.addMethod("regex", function (value, element, regexp) {
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	}, "Remove Special Chars");

	jQuery.validator.addMethod('selectcheck', function (value) {
		return (value != '0');
	}, "Select");

	jQuery.validator.addMethod('decimal', function (value, element) {
		return this.optional(element) || /^(\d+\.)?\d+$/.test(value);
	}, "Invalid Number");

	$.validator.addMethod('reCaptchaMethod', function (value, element, param) {
		if (grecaptcha.getResponse() == '') {
			return false;
		} else {
			// I would like also to check server side if the recaptcha response is good
			return true
		}
	}, 'You must complete the antispam verification');

	jQuery("#loginform").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				regex: "^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$",
				rangelength: [6, 12]
			}
		},
		messages: {
			email: {
				required: "Enter email id",
				email: "Enter valid email"
			},
			password: {
				required: "Enter password",
				rangelength: "Password length must be between {0} to {1}"
			}

		}
	});

	jQuery("#form_packagereply").validate({
		rules: {
			reply: {
				required: true
			}
		},
		messages: {
			reply: {
				required: "Enter reply message"
			}
		}
	});

	jQuery("#form_season_dest").validate({
		ignore: [],
		rules: {
			destination_id: {
				required: true
			}
		},
		messages: {
			destination_id: {
				required: "Choose destination"
			}
		},

	});






	jQuery("#add_discussion").validate({
		ignore: [],
		rules: {
			title: {
				required: true
			},
			dis_image: {
				required: true,
				extension: "png|jpg|jpeg|gif|bmp"
			},
			blog_url: {
				required: true
			},
			contents: {
				required: function () {
					CKEDITOR.instances.contents.updateElement();
				}
			}

		},
		messages: {
			title: {
				required: "Enter title."
			},
			dis_image: {
				required: "Upload Blog image",
				extension: "Uploaded file should be a png / jpg / jpeg / gif / bmp file."
			},
			blog_url: {
				required: "Enter Blog Url."
			},
			contents: {
				required: "Enter Contents"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "contents")
				$error.insertAfter("#chkediter");
			else if ($element.attr("name") === "dis_image")
				$error.insertAfter("#imo_err");
			else
				$error.insertAfter($element);
		}
	});

	jQuery("#edit_form_discussion").validate({
		ignore: [],
		rules: {
			title: {
				required: true
			},
			dis_image: {
				extension: "png|jpg|jpeg|gif|bmp"
			},
			blog_url: {
				required: true,
				regex: "^[a-zA-Z0-9-]*$"

			},
			contents: {
				required: function () {
					CKEDITOR.instances.contents.updateElement();
				}
			}

		},
		messages: {
			title: {
				required: "Enter title."
			},
			dis_image: {
				extension: "Uploaded file should be a png / jpg / jpeg / gif / bmp file."
			},
			blog_url: {
				required: "Enter Blog Url.",
				regex: "Special characters or whitespace not allowed",
				remote: "Blog url already exists."
			},
			contents: {
				required: "Enter Contents"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "contents")
				$error.insertAfter("#chkediter");
			else
				$error.insertAfter($element);
		}
	});


	jQuery("#form_reply").validate({
		rules: {
			reply: {
				required: true

			}

		},
		messages: {
			reply: {
				required: "Enter reply message"

			}

		}
	});


	jQuery("#form_faqs").validate({
		ignore: [],
		debug: false,
		rules: {
			faq_question: {
				required: true
			},
			faq_answer: {
				required: function () {
					CKEDITOR.instances.faq_answer.updateElement();
				}
			}
		},
		messages: {
			faq_question: {
				required: "Enter Question."
			},
			faq_answer: {
				required: "Enter Answer."
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "faq_answer")
				$error.insertAfter("#chkediter");
			else
				$error.insertAfter($element);
		}
	});


	jQuery("#form_packagefaqs").validate({
		ignore: [],
		debug: false,
		rules: {
			tag_name: {
				required: true
			},
			faq_question: {
				required: true
			},
			faq_answer: {
				required: function () {
					CKEDITOR.instances.faq_answer.updateElement();
				}
			}
		},
		messages: {
			tag_name: {
				required: "Select Package."
			},
			faq_question: {
				required: "Enter Question."
			},
			faq_answer: {
				required: "Enter Answer."
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "faq_answer")
				$error.insertAfter("#chkediter");
			else
				$error.insertAfter($element);
		}
	});


	jQuery("#form_country").validate({
		rules: {
			country_name: {
				required: true

			}

		},
		messages: {
			country_name: {
				required: "Enter country"

			}

		}
	});

	jQuery("#form_state").validate({
		rules: {

			state_name: {
				required: true

			},
			state_url: {
				required: true

			}
		},
		messages: {

			state_name: {
				required: "Enter state"
			},

			state_url: {
				required: "Enter url"
			}
		}
	});

	jQuery("#form_menutags").validate({
		rules: {
			tag_name: {
				required: true
			},
			tag_url: {
				required: true
			},
			menuid: {
				required: true
			},
			menutag_img: {
				required: true
			},
			catId: {
				required: true
			}
		},
		messages: {
			tag_name: {
				required: "Enter tag name"
			},
			tag_url: {
				required: "Tag URL can not be empty"
			},
			menutag_img: {
				required: "Upload banner image."
			},
			menuid: {
				required: "Choose menu."
			},
			catId: {
				required: "Choose category"
			}
		}
	});

	jQuery("#form_cats").validate({
		rules: {
			menuid: {
				required: true
			},
			cat_name: {
				required: true
			}
		},
		messages: {
			menuid: {
				required: "Choose menu"
			},
			cat_name: {
				required: "Enter category"
			}
		}
	});

	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_states").validate({
			ignore: [],
			rules: {
				state_names: {
					required: true

				},
				state_urls: {
					required: true
				}
			},
			messages: {
				state_names: {
					required: "Enter State Name"
				},
				state_urls: {
					required: "Enter url"
				}
			}
		});
	});

	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_editmenutabs").validate({
			ignore: [],
			rules: {
				menuid: {
					required: true
				},
				cat_name: {
					required: true
				}
			},
			messages: {
				menuid: {
					required: "Choose menu"
				},

				cat_name: {
					required: "Enter category"
				}
			}
		});
	});

	$(document.body).on('click', '#btnUpdatetag', function () {
		$("#form_editmenutags").validate({
			ignore: [],
			rules: {
				menuid1: {
					required: true
				},
				catId1: {
					required: true
				},
				tag_name: {
					required: true
				}
			},
			messages: {
				menuid1: {
					required: "Choose menu"
				},
				catId1: {
					required: "Choose menu"
				},
				tag_name: {
					required: "Enter tag name"
				}
			}
		});
	});

	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_destination_types").validate({
			ignore: [],
			rules: {
				destination_type_name: {
					required: true
				}
			},
			messages: {
				destination_type_name: {
					required: "Enter destination type"
				}
			}
		});
	});

	jQuery("#form_pduration").validate({
		rules: {
			duration_name: {
				required: true
			},
			no_ofdays: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			no_ofnights: {
				required: true,
				regex: "^[0-9 \+-]+$"
			}

		},
		messages: {
			duration_name: {
				required: "Enter duration name"
			},
			no_ofdays: {
				required: "Enter no of day",
				regex: "numbers only."
			},
			no_ofnights: {
				required: "Enter no of night",
				regex: "numbers only."
			}
		}
	});

	jQuery("#form_packageiternary").validate({
		rules: {
			'destination_id[]': {
				required: true
			},
			'no_ofdays[]': {
				required: true
			},
			'no_ofnight[]': {
				required: true
			},
			'iternary_title[]': {
				required: true
			} /*,
            'iternary_detais[]': {
				required: true       
            }*/
		},
		messages: {
			'destination_id[]': {
				required: "Choose destination."
			},
			'no_ofdays[]': {
				required: "Choose no of days."
			},
			'no_ofnight[]': {
				required: "Choose no of nights."
			},
			'iternary_title[]': {
				required: "Enter iternary title"
			} /*, 
           'iternary_detais[]': {
             required: "Enter the details"      
           } */
		}
	});

	jQuery("#form_editpackageiternary").validate({
		rules: {
			'destination_id[]': {
				required: true
			},
			'no_ofdays[]': {
				required: true
			},
			'no_ofnight[]': {
				required: true
			},
			'iternary_title[]': {
				required: true
			}/*,
            'iternary_detais[]': {
				required: true       
            }*/
		},
		messages: {
			'destination_id[]': {
				required: "Choose destination."
			},
			'no_ofdays[]': {
				required: "Choose no of days."
			},
			'no_ofnight[]': {
				required: "Choose no of nights."
			},
			'iternary_title[]': {
				required: "Enter iternary title."
			}/*, 
           'iternary_detais[]': {
				required: "Enter the details."      
           }*/
		}
	});

	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_editpduration").validate({
			ignore: [],
			rules: {
				duration_name: {
					required: true
				},
				no_ofdays: {
					required: true,
					regex: "^[0-9 \+-]+$"
				},
				no_ofnights: {
					required: true,
					regex: "^[0-9 \+-]+$"
				}
			},
			messages: {
				duration_name: {
					required: "Enter duration name"
				},
				no_ofdays: {
					required: "Enter no of day",
					regex: "numbers only."
				},
				no_ofnights: {
					required: "Enter no of night",
					regex: "numbers only."
				}
			}
		});
	});

	////////////////for hotel type/////////////////
	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_hotel_types").validate({
			ignore: [],
			rules: {
				hotel_type_name: {
					required: true
				}
			},
			messages: {
				hotel_type_name: {
					required: "Enter hotel type"
				}
			}
		});
	});

	jQuery("#form_hotel_type").validate({
		rules: {

			hotel_type_name: {
				required: true

			}
		},
		messages: {

			hotel_type_name: {
				required: "Enter Hotel type"
			}
		}
	});

	////////////////for season type/////////////////

	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_season_types").validate({
			ignore: [],
			rules: {
				season_type_name: {
					required: true

				}

			},
			messages: {
				season_type_name: {
					required: "Enter Season type"
				}
			}
		});
	});



	jQuery("#form_season_type").validate({
		rules: {

			season_type_name: {
				required: true

			}
		},
		messages: {

			season_type_name: {
				required: "Enter Season type"
			}
		}
	});



	/////////////////////////////for hotel//////////////////////////////////////////////

	jQuery("#form_hotel").validate({
		ignore: [],
		debug: false,
		rules: {
			hotel_name: {
				required: true
			},
			destination_name: {
				required: true
			},
			hotel_type: {
				required: true
			},
			default_price: {
				required: true,
				decimal: true
			},
			trip_url: {
				url: true
			},
			star_ratings: {
				decimal: true
			},
			'season_type[]': {
				required: true
			},
			'from_startmonth[]': {
				required: true
			},
			'from_startdate[]': {
				required: true
			},
			'from_endmonth[]': {
				required: true
			},
			'from_enddate[]': {
				required: true
			},
			'adult_price[]': {
				required: true,
				decimal: true
			},
			'couple_price[]': {
				required: true,
				decimal: true
			},
			'kid_price[]': {
				required: true,
				decimal: true
			},
			'adult_extra[]': {
				required: true,
				decimal: true
			}
		},
		messages: {
			hotel_name: {
				required: "Enter hotel Name"
			},
			destination_name: {
				required: "Enter destination "
			},
			hotel_type: {
				required: "Select hotel type"
			},
			default_price: {
				required: "Enter default price"
			},
			trip_url: {
				url: "Enter valid trip advisor URL"
			},
			star_ratings: {
				decimal: "Enter numeric value only"
			},
			'season_type[]': {
				required: "Select season type"
			},


			'from_startmonth[]': {
				required: "Select start month"
			},

			'from_startdate[]': {
				required: "Select start date"
			},

			'from_endmonth[]': {
				required: "Select end month"
			},

			'from_enddate[]': {
				required: "Select end date"
			},

			'adult_price[]': {
				required: "Enter price for adult",
				decimal: "only number"
			},

			'couple_price[]': {
				required: "Enter price for couple",
				decimal: "only number"
			},

			'kid_price[]': {
				required: "Enter price for Kid",
				decimal: "only number"
			},

			'adult_extra[]': {
				required: "Enter extra bed for adult",
				decimal: "only number"
			}
		},

		errorPlacement: function ($error, $element) {
			if ($element.attr("id") === "season_type") {
				$error.insertAfter("#seasontype_err");
			} else if ($element.attr("id") === "from_startmonth") {
				$error.insertAfter("#fromstartmonth_err");
			} else if ($element.attr("id") === "from_startdate") {
				$error.insertAfter("#fromstartdate_err");
			} else if ($element.attr("id") === "from_endmonth") {
				$error.insertAfter("#fromendmonth_err");
			} else if ($element.attr("id") === "from_enddate") {
				$error.insertAfter("#fromenddate_err");
			} else if ($element.attr("id") === "adult_price") {
				$error.insertAfter("#adultprice_err");
			} else if ($element.attr("id") === "couple_price") {
				$error.insertAfter("#coupleprice_err");
			} else if ($element.attr("id") === "kid_price") {
				$error.insertAfter("#kidprice_err");
			} else if ($element.attr("id") === "adult_extra") {
				$error.insertAfter("#adultextra_err");
			} else {
				$error.insertAfter($element);
			}
		}
	});

	//////////////for edit hotel////////////////////

	jQuery("#form_edithotel").validate({
		ignore: [],
		debug: false,
		rules:
		{
			hotel_name: {
				required: true
			},
			destination_name: {
				required: true
			},
			hotel_type: {
				required: true
			},
			default_price: {
				required: true,
				decimal: true
			},
			trip_url: {
				url: true
			},
			star_ratings: {
				decimal: true
			}
		},
		messages: {
			hotel_name: {
				required: "Enter hotel Name"
			},
			destination_name: {
				required: "Enter destination "
			},
			hotel_type: {
				required: "Select hotel type"
			},
			default_price: {
				required: "Enter default price"
			},
			trip_url: {
				url: "Enter valid trip advisor URL"
			},
			star_ratings: {
				decimal: "Enter numeric value only"
			}
		},
	});

	jQuery("#form_itinerary").validate({
		ignore: [],
		debug: false,
		rules:
		{
			itinerary_name: {
				required: true
			},
			itinerary_url: {
				required: true
			},
			'getplacetypeid[]': {
				required: true
			},
			duration: {
				required: true
			},
			rating: {
				selectcheck: true
			},
			itineraryimg: {
				required: true
			},
			itinerarythumbimg: {
				required: true
			},
			starting_city: {
				required: true
			},
			'destination_id[]': {
				required: true
			},
			'no_ofdays[]': {
				required: true
			},
			'no_ofnight[]': {
				required: true
			},
			'title[]': {
				required: true
			},
			'getplaceid[]': {
				required: true
			}
		},
		messages:
		{
			itinerary_name: {
				required: "Enter Itinerary Name"
			},
			itinerary_url: {
				required: "Enter Itinerary url"
			},
			'getplacetypeid[]': {
				required: "Select Place type"
			},
			duration: {
				required: "Select Duration"
			},
			rating: {
				selectcheck: "Select rating"
			},
			itineraryimg: {
				required: "Upload banner image"
			},
			itinerarythumbimg: {
				required: "Upload itinerary image"
			},
			starting_city: {
				required: "Select Starting City"
			},
			'destination_id[]': {
				required: "Select Destination"
			},
			'no_ofdays[]': {
				required: "Select No of days"
			},
			'no_ofnight[]': {
				required: "Enter No of night"
			},
			'title[]': {
				required: "Enter Title"
			},
			'getplaceid[]': {
				required: "Select Place"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("id") === "getplacetypeid") {
				$error.insertAfter("#getplacetype_err");
			} else {
				$error.insertAfter($element);
			}
		}
	});

	jQuery("#form_edititinerary").validate({
		ignore: [],
		debug: false,
		rules: {
			itinerary_name: {
				required: true
			},
			itinerary_url: {
				required: true
			},
			'getplacetypeid[]': {
				required: true
			},
			duration: {
				required: true
			},
			rating: {
				selectcheck: true
			},
			starting_city: {
				required: true
			},
			'destination_id[]': {
				required: true
			},
			'no_ofdays[]': {
				required: true
			},
			'no_ofnight[]': {
				required: true
			},
			'title[]': {
				required: true
			},
			'getplaceid[]': {
				required: true
			}
		},

		messages: {
			itinerary_name: {
				required: "Enter Itinerary Name"
			},
			itinerary_url: {
				required: "Enter Itinerary url"
			},
			'getplacetypeid[]': {
				required: "Select Place type"
			},
			duration: {
				required: "Select Duration"
			},
			rating: {
				selectcheck: "Select rating"
			},
			starting_city: {
				required: "Select Starting City"
			},
			'destination_id[]': {
				required: "Select Destination"
			},
			'no_ofdays[]': {
				required: "Select No of days"
			},
			'no_ofnight[]': {
				required: "Enter No of night"
			},
			'title[]': {
				required: "Enter Title"
			},
			'getplaceid[]': {
				required: "Select Place"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("id") === "getplacetypeid") {
				$error.insertAfter("#getplacetype_err");
			} else {
				$error.insertAfter($element);
			}
		}

	});

	//////////////for edit season////////////////////

	jQuery("#form_season").validate({
		ignore: [],
		debug: false,
		rules: {

			season_type: {
				required: true

			},

			from_startmonth: {
				required: true

			},

			from_endmonth: {
				required: true

			},

			from_startdate: {
				required: true

			},

			from_enddate: {
				required: true

			},

			adult_price: {
				required: true,
				decimal: true
			},

			couple_price: {
				required: true,
				decimal: true
			},

			kid_price: {
				required: true,
				decimal: true
			},

			adult_extra: {
				required: true,
				decimal: true
			}

		},


		messages: {


			season_type: {
				required: "Select season type"
			},


			from_startmonth: {
				required: "Select start month"
			},

			from_endmonth: {
				required: "Select end date"
			},



			from_enddate: {
				required: "Select end date"
			},

			adult_price: {
				required: "Enter price for adult",
				decimal: "only number"
			},

			couple_price: {
				required: "Enter price for couple",
				decimal: "only number"
			},

			kid_price: {
				required: "Enter price for Kid",
				decimal: "only number"
			},

			adult_extra: {
				required: "Enter extra bed for adult",
				decimal: "only number"
			}



		},


		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "season_type[]") {
				$error.insertAfter("#seasontype_err");
			} else if ($element.attr("name") === "from_startmonth[]") {
				$error.insertAfter("#fromstartmonth_err");
			} else if ($element.attr("name") === "from_startdate[]") {
				$error.insertAfter("#fromstartdate_err");
			} else if ($element.attr("name") === "from_endmonth[]") {
				$error.insertAfter("#fromendmonth_err");
			} else if ($element.attr("name") === "from_enddate[]") {
				$error.insertAfter("#fromenddate_err");
			} else if ($element.attr("name") === "adult_price[]") {
				$error.insertAfter("#adultprice_err");
			} else if ($element.attr("name") === "couple_price[]") {
				$error.insertAfter("#coupleprice_err");
			} else if ($element.attr("name") === "kid_price[]") {
				$error.insertAfter("#kidprice_err");
			} else if ($element.attr("name") === "adult_extra[]") {
				$error.insertAfter("#adultextra_err");
			} else {
				$error.insertAfter($element);
			}

		}


	});

	///////////////////package////////////

	jQuery("#form_edit_tpackages").validate({
		ignore: [],
		debug: false,
		rules: {
			tpackage_name: {
				required: true
			},
			tpackage_url: {
				required: true
			},
			tpackage_code: {
				required: true
			},
			pduration: {
				required: true
			},
			price: {
				required: true
			},
			fakeprice: {
				required: true
			},
			pmargin_perctage: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			rating: {
				required: true
			},
			'getatagid[]': {
				required: true
			},
			alttag_banner: {
				required: true
			},
			alttag_thumb: {
				required: true
			},
			dest_name: {
				required: true
			},
			no_ofdays: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			no_ofnights: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			itinerary: {
				required: true
			},
			starting_city: {
				required: true
			},
			inclusion: {
				required: function () {
					CKEDITOR.instances.inclusion.updateElement();
				}
			},
			'destination_id[]': {
				required: true
			},
			'no_ofdays[]': {
				required: true
			}
		},
		messages: {
			tpackage_name: {
				required: "Enter package Name."
			},
			tpackage_url: {
				required: "Enter package url."
			},
			tpackage_code: {
				required: "Enter package code."
			},
			pduration: {
				required: "Enter package duration."
			},
			price: {
				required: "Enter price."
			},
			fakeprice: {
				required: "Enter fakeprice."
			},
			pmargin_perctage: {
				required: "Enter margin percentage.",
				regex: "Numbers only"
			},
			rating: {
				required: "Select rating."
			},
			'getatagid[]': {
				required: "Select tag."
			},
			alttag_banner: {
				required: "Enter alt tag"
			},
			alttag_thumb: {
				required: "Enter alt tag"
			},
			dest_name: {
				required: "Enter destination"
			},
			no_ofdays: {
				required: "Enter no of days",
				regex: "Numbers only"
			},
			no_ofnights: {
				required: "Enter no of nights",
				regex: "Numbers only"
			},
			itinerary: {
				required: "Select Itinerary"
			},
			starting_city: {
				required: "Select Starting City"
			},
			inclusion: {
				required: "Enter inclusions / exclusion."
			},
			'destination_id[]': {
				required: "Select Destination"
			},
			'no_ofdays[]': {
				required: "Select No of days"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "getatagid[]") {
				$error.insertAfter("#gettourtag_err");
			} else if ($element.attr("name") === "inclusion") {
				$error.insertAfter("#inclusion_err");
			} else
				$error.insertAfter($element);
		}
	});

	jQuery("#form_tpackages").validate({
		ignore: [],
		debug: false,
		rules: {
			tpackage_name: {
				required: true
			},
			tpackage_url: {
				required: true
			},
			tpackage_code: {
				required: true
			},
			pduration: {
				required: true
			},
			price: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			fakeprice: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			pmargin_perctage: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			rating: {
				required: true
			},
			'getatagid[]': {
				required: true
			},
			tourimo: {
				required: true
			},
			tourthumb: {
				required: true
			},
			alttag_banner: {
				required: true
			},
			alttag_thumb: {
				required: true
			},
			dest_name: {
				required: true
			},
			no_ofdays: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			no_ofnights: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			itinerary: {
				required: true
			},
			starting_city: {
				required: true
			},
			inclusion: {
				required: function () {
					CKEDITOR.instances.inclusion.updateElement();
				}
			},
			'destination_id[]': {
				required: true
			},
			'no_ofdays[]': {
				required: true
			}
		},
		messages: {
			tpackage_name: {
				required: "Enter package Name."
			},
			tpackage_url: {
				required: "Enter package url."
			},
			tpackage_code: {
				required: "Enter package code."
			},
			pduration: {
				required: "Select package duration."
			},
			price: {
				required: "Enter price.",
				regex: "Numbers only"
			},
			fakeprice: {
				required: "Enter fakeprice.",
				regex: "Numbers only"
			},
			pmargin_perctage: {
				required: "Enter margin percentage.",
				regex: "Numbers only"
			},
			rating: {
				required: "Select rating."
			},
			'getatagid[]': {
				required: "Select tag."
			},
			tourimo: {
				required: "Browse file."
			},
			tourthumb: {
				required: "Browse file."
			},
			alttag_banner: {
				required: "Enter alt tag"
			},
			alttag_thumb: {
				required: "Enter alt tag"
			},
			dest_name: {
				required: "Enter destination"
			},
			no_ofdays: {
				required: "Enter no of days",
				regex: "Numbers only"
			},
			no_ofnights: {
				required: "Enter no of nights",
				regex: "Numbers only"
			},
			itinerary: {
				required: "Select Itinerary"
			},
			starting_city: {
				required: "Select Starting City"
			},
			inclusion: {
				required: "Enter inclusions / exclusion."
			},
			'destination_id[]': {
				required: "Select Destination"
			},
			'no_ofdays[]': {
				required: "Select No of days"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "getatagid[]") {
				$error.insertAfter("#gettourtag_err");
			} else if ($element.attr("name") === "inclusion") {
				$error.insertAfter("#inclusion_err");
			} else
				$error.insertAfter($element);
		}
	});



	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_editvehicleprice").validate({
			ignore: [],
			rules: {
				vehicle_name: {
					required: true
				},
				destination: {
					required: true
				},
				price: {
					required: true,
					regex: "^[0-9 \+-]+$"
				},


			},
			messages: {
				vehicle_name: {
					required: "Choose vehicle."
				},
				destination: {
					required: "Choose destination. "
				},
				price: {
					required: "Enter price.",
					regex: "Numbers only."
				}
			}
		});
	});


	$(document.body).on('click', '#btnUpdate', function () {
		jQuery("#form_editvehicle").validate({
			ignore: [],
			rules: {
				vehicle_name: {
					required: true
				},
				capacity: {
					required: true
				}
			},
			messages: {
				vehicle_name: {
					required: "Enter vehicle name."
				},
				capacity: {
					required: "Enter vehicle capacity."
				}
			}
		});
	});


	jQuery("#form_destination_type").validate({
		rules: {

			destination_type_name: {
				required: true

			}
		},
		messages: {

			destination_type_name: {
				required: "Enter Destination type"
			}
		}
	});




	jQuery("#form_cms").validate({
		ignore: [],
		debug: false,
		rules: {
			editor: {
				required: function () {
					CKEDITOR.instances.editor.updateElement();
				}
			}
		},
		messages: {
			editor: {
				required: "Enter Description"
			}

		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "editor")
				$error.insertAfter("#chkediter");
			else
				$error.insertAfter($element);
		}
	});




	jQuery("#form_cmnstng").validate({
		ignore: [],
		debug: false,
		rules: {
			par_value: {
				required: true

			},

			text_area: {
				required: true

			},


			short_desc: {
				required: function () {
					CKEDITOR.instances.short_desc.updateElement();
				}
			}



		},
		messages: {
			par_value: {
				required: "Enter value"

			},

			text_area: {
				required: "Enter Value"

			},

			short_desc: {
				required: "Enter Value"
			}

		}
	});



	jQuery("#change_password").validate({
		rules: {
			new_pwd: {
				required: true,
				regex: "^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$",
				rangelength: [6, 12]
			},
			cnf_pwd: {
				required: true,
				equalTo: "#new_pwd"
			}
		},
		messages: {
			new_pwd: {
				required: "Enter new password.",
				rangelength: "Password length must be between {0} to {1}"
			},
			cnf_pwd: {
				required: "Enter confirm password.",
				equalTo: "Enter same password again."
			}
		}
	});


	jQuery("#form_vehicletype").validate({
		rules: {
			vehicle_name: {
				required: true
			},
			capacity: {
				required: true,
				regex: "^[0-9 \+-]+$"

			}
		},
		messages: {
			vehicle_name: {
				required: "Enter vehicle name."
			},
			capacity: {
				required: "Enter vehicle capacity.",
				regex: "Only numbers"
			}
		}
	});


	jQuery("#form_editvehicle").validate({
		rules: {
			vehicle_name: {
				required: true
			},
			capacity: {
				required: true,
				regex: "^[0-9 \+-]+$"

			}
		},
		messages: {
			vehicle_name: {
				required: "Enter vehicle name."
			},
			capacity: {
				required: "Enter vehicle capacity.",
				regex: "Only numbers"
			}
		}
	});


	jQuery("#form_vehicleprice").validate({
		rules: {
			price: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			destination: {
				required: true
			},
			vehicle_name: {
				required: true
			}
		},
		messages: {
			price: {
				required: "Enter price.",
				regex: "Only numbers"
			},
			destination: {
				required: "Choose destination."
			},
			vehicle_name: {
				required: "Choose vehicle."
			}
		}
	});


	jQuery("#form_destination").validate({
		ignore: [],
		debug: false,
		rules: {
			destination_name: {
				required: true
			},
			destination_url: {
				required: true
			},
			state: {
				required: true
			},
			destismallimg: {
				required: true
			},
			destiimg: {
				required: true
			},
			pick_drop_price: {
				required: true,
				decimal: true
			},
			accomodation_price: {
				required: true,
				decimal: true
			},
			latitude: {
				required: true
			},
			longitude: {
				required: true
			},
			short_desc: {
				required: true
			},
		},
		messages: {
			destination_name: {
				required: "Enter destination Name"
			},
			destination_url: {
				required: "Enter destination url"
			},
			state: {
				required: "Select state"
			},
			destismallimg: {
				required: "Upload destination image"
			},
			destiimg: {
				required: "Upload banner image"
			},
			pick_drop_price: {
				required: "Enter pick / drop price.",
				decimal: "Only numbers"
			},
			accomodation_price: {
				required: "Enter minimum accomodation price.",
				decimal: "Only numbers"
			},
			latitude: {
				required: "Enter destination latitude."
			},
			longitude: {
				required: "Enter destination longitude."
			},
			short_desc: {
				required: "Enter description"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "destination_type[]") {
				$error.insertAfter("#destinationtype_err");
			} else if ($element.attr("name") === "destination_id") {
				$error.insertAfter("#placedestin_err");
			} else if ($element.attr("name") === "short_desc") {
				$error.insertAfter("#aboutdest_err");
			} else if ($element.attr("name") === "getatagid[]") {
				$error.insertAfter("#getatagid_err");
			} else if ($element.attr("name") === "edesti[]") {
				$error.insertAfter("#edesti_err");
			} else {
				$error.insertAfter($element);
			}
		}
	});

	jQuery("#form_editdestination").validate({
		ignore: [],
		debug: false,
		rules: {
			destination_name: {
				required: true
			},
			destination_url: {
				required: true
			},
			state: {
				required: true
			},
			pick_drop_price: {
				required: true,
				decimal: true
			},
			accomodation_price: {
				required: true,
				decimal: true
			},
			latitude: {
				required: true
			},
			longitude: {
				required: true
			},
			short_desc: {
				required: true
			},
		},
		messages: {
			destination_name: {
				required: "Enter destination Name"
			},
			destination_url: {
				required: "Enter destination url"
			},
			state: {
				required: "Select state"
			},
			pick_drop_price: {
				required: "Enter pick / drop price.",
				decimal: "Only numbers"
			},
			accomodation_price: {
				required: "Enter minimum accomodation price.",
				decimal: "Only numbers"
			},
			latitude: {
				required: "Enter destination latitude."
			},
			longitude: {
				required: "Enter destination longitude."
			},
			short_desc: {
				required: "Enter description"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "short_desc") {
				$error.insertAfter("#aboutdest_err");
			} else {
				$error.insertAfter($element);
			}
		}
	});


	/*For form Place*/
	jQuery("#form_places").validate({
		ignore: [],
		debug: false,
		rules: {
			place_name: {
				required: true
			},
			place_url: {
				required: true
			},
			destination_id: {
				required: true
			},
			placeimg: {
				required: true
			},
			placethumbimg: {
				required: true
			},
			latitude: {
				required: true
			},
			longitude: {
				required: true
			},
			short_desc: {
				required: true
			}
		},
		messages: {
			place_name: {
				required: "Enter place Name"
			},
			place_url: {
				required: "Enter place url"
			},
			destination_id: {
				required: "Select destination"
			},
			visit_time: {
				required: "Enter visit time"
			},
			placeimg: {
				required: "Upload banner image"
			},
			placethumbimg: {
				required: "Upload place image"
			},
			latitude: {
				required: "Enter place latitude."
			},
			longitude: {
				required: "Enter place longitude."
			},
			short_desc: {
				required: "About place"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "short_desc") {
				$error.insertAfter("#aboutplace_err");
			} else if ($element.attr("name") === "placeimg") {
				$error.insertAfter("#placeimo_err");
			} else if ($element.attr("name") === "placethumbimg") {
				$error.insertAfter("#placethumbimo_err");
			} else {
				$error.insertAfter($element);
			}
		}
	});
	/*For form Place*/


	/*For Editform Place*/
	jQuery("#form_editplaces").validate({
		ignore: [],
		debug: false,
		rules: {
			place_name: {
				required: true
			},
			place_url: {
				required: true
			},
			destination_id: {
				required: true
			},
			latitude: {
				required: true
			},
			longitude: {
				required: true
			},
			short_desc: {
				required: true
			}
		},
		messages: {
			place_name: {
				required: "Enter place Name"
			},
			place_url: {
				required: "Enter place url"
			},
			destination_id: {
				required: "Select destination"
			},
			latitude: {
				required: "Enter place latitude."
			},
			longitude: {
				required: "Enter place longitude."
			},
			short_desc: {
				required: "About place"
			}
		},
		errorPlacement: function ($error, $element) {
			if ($element.attr("name") === "destination_id") {
				$error.insertAfter("#placedestin_err");
			} else if ($element.attr("name") === "short_desc") {
				$error.insertAfter("#aboutplace_err");
			} else {
				$error.insertAfter($element);
			}
		}
	});


	/*Add review*/
	jQuery("#form_review").validate({
		rules: {
            getassocid:{
                required: true
            },
			reviewer_name: {
				required: true
			},
			reviewer_loc: {
				required: true
			},
			no_of_star: {
				required: true
			},
			feedback_msg: {
				required: true
			},
		},
		messages: {
            getassocid:{
                required: "Choose associated categories tag"
            },
			reviewer_name: {
				required: "Enter name"
			},
			reviewer_loc: {
				required: "Enter location"
			},
			no_of_star: {
				required: "Choose rating"
			},
			feedback_msg: {
				required: "Enter feedback"
			},
		}
	});


	/*Add review*/

	/*For form Place*/

	jQuery("#userform").validate({
		rules: {
			uname: {
				required: true,
				regex: "^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$"
			},
			utype: {
				required: true
			},
			contact: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				regex: "^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$",
				rangelength: [6, 12]
			},
			cpassword: {
				required: true,
				equalTo: "#password"
			},
			'modules[]': {
				required: true
			}
		},
		messages: {
			uname: {
				required: "Enter user name."
			},
			utype: {
				required: "Select user type."
			},
			contact: {
				required: "Enter contact no.",
				regex: "Enter only number."
			},
			email: {
				required: "Enter email id.",
				email: "Enter a valid email id."
			},
			password: {
				required: "Enter password.",
				rangelength: "Password length must be between {0} to {1}"
			},
			cpassword: {
				required: "Enter confirm password.",
				equalTo: "Enter same password again."
			},
			'modules[]': {
				required: "Select module category"
			}
		},
		errorPlacement: function (error, element) {
			if (element.attr("name") === "modules[]")
				error.appendTo("#modules_errorloc");
			else if (element.attr("name") === "utype")
				error.appendTo("#utype_errorloc");
			else
				error.insertAfter(element);
		}
	});

	$('input:radio[name="utype"]').change(function () {
		if ($(this).val() == '2') {
			$('input:checkbox[name="modules[]"]').prop('checked', this.checked).attr("disabled", true);
		} else {
			$('input:checkbox[name="modules[]"]').prop('checked', false).removeAttr('disabled');
		}
	});


	////////////////for Follow Up Enquiries/////////////////
	jQuery("#form_source").validate({
		rules: {
			source_name: {
				required: true
			}
		},
		messages: {
			source_name: {
				required: "Enter Source"
			}
		}
	});

	jQuery("#form_sources").validate({
		rules: {
			source_name: {
				required: true
			}
		},
		messages: {
			source_name: {
				required: "Enter Source"
			}
		}
	});

	jQuery("#form_statuslist").validate({
		rules: {
			status_name: {
				required: true
			}
		},
		messages: {
			status_name: {
				required: "Enter Status Name"
			}
		}
	});

	jQuery("#form_enquiry_entry").validate({
		ignore: [],
		debug: false,
		rules: {
			customer_name: {
				required: true
			},
			email_address: {
				required: true,
				email: true
			},
			phone_number: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			source_id: {
				required: true,
			},
			status_id: {
				required: true
			},
			trip_name: {
				required: true
			},
			trip_start_date: {
				required: true
			},
			follow_up_date: {
				required: true
			},
			no_of_travellers: {
				required: true
			},
			comment: {
				required: true
			},
		},
		messages: {
			customer_name: {
				required: "Enter customer name"
			},
			email_address: {
				required: "Enter email address ",
				email: "Enter a valid email address."
			},
			phone_number: {
				required: "Enter Phone Number",
				regex: "Enter only number"
			},
			source_id: {
				required: "Select source"
			},
			status_id: {
				required: "Select status"
			},
			trip_name: {
				required: "Enter trip name"
			},
			trip_start_date: {
				required: "Enter trip start date"
			},
			follow_up_date: {
				required: "Enter follow up date"
			},
			no_of_travellers: {
				required: "Enter no. of travellers"
			},
			comment: {
				required: "Enter comment"
			},
		}
	});

	jQuery("#form_edit_enquiry_entry").validate({
		ignore: [],
		debug: false,
		rules: {
			customer_name: {
				required: true
			},
			email_address: {
				required: true,
				email: true
			},
			phone_number: {
				required: true,
				regex: "^[0-9 \+-]+$"
			},
			source_id: {
				required: true,
			},
			status_id: {
				required: true
			},
			trip_name: {
				required: true
			},
			trip_start_date: {
				required: true
			},
			follow_up_date: {
				required: true
			},
			no_of_travellers: {
				required: true
			},
			comment: {
				required: true
			},
		},
		messages: {
			customer_name: {
				required: "Enter customer name"
			},
			email_address: {
				required: "Enter email address ",
				email: "Enter a valid email address."
			},
			phone_number: {
				required: "Enter Phone Number",
				regex: "Enter only number"
			},
			source_id: {
				required: "Select source"
			},
			status_id: {
				required: "Select status"
			},
			trip_name: {
				required: "Enter trip name"
			},
			trip_start_date: {
				required: "Enter trip start date"
			},
			follow_up_date: {
				required: "Enter follow up date"
			},
			no_of_travellers: {
				required: "Enter no. of travellers"
			},
			comment: {
				required: "Enter comment"
			},
		}
	});

	$(document.body).on('click', '#btnSubmit', function () {
		jQuery("#form_edit_enquiry_report").validate({
			ignore: [],
			debug: false,
			rules: {
				status_id: {
					required: true
				},
				trip_start_date: {
					required: true
				},
				follow_up_date: {
					required: true
				},
				no_of_travellers: {
					required: true
				},
				comment: {
					required: true
				},
			},
			messages: {
				status_id: {
					required: "Select status"
				},
				trip_start_date: {
					required: "Enter trip start date"
				},
				follow_up_date: {
					required: "Enter follow up date"
				},
				no_of_travellers: {
					required: "Enter no. of travellers"
				},
				comment: {
					required: "Enter comment"
				},
			}
		});
	});

	$(document.body).on('click', '#btnSubmitAssignTo', function () {
		jQuery("#form_edit_assign_to").validate({
			ignore: [],
			debug: false,
			rules: {
				assign_to: {
					required: true
				}
			},
			messages: {
				assign_to: {
					required: "Select assign to"
				}
			}
		});
	});
});


/* Start - Add and/or Delete Row in jQuery */
$(document.body).on('click', '.addrowbtn', function () {
	var rowindex = $(this).closest("tr")[0].rowIndex;
	var clone = $("#addRowTable tr:last").clone();
	var i = $("#addRowTable > tbody > tr").length;

	a = new Array();
	$('a[name="del[]"]').each(function () {
		var thisidsplt = this.id.split("_");
		a.push(thisidsplt[1]);
	});
	if (!(i >= 1)) { a.push(-1); }
	var max_of_array = Math.max.apply(null, a);
	i = parseInt(max_of_array) + 1;

	clone.find("td").each(function () {
		$(this).find('input, select, img, a').each(function () {
			var id = $(this).attr('id') || null;
			if (id) {
				var alsplt = id.split("_");
				var prefix = alsplt[0];

				$(this).attr('id', prefix + '_' + (+i));

				//if((prefix == "taxname") || (prefix == "cdepartment") || (prefix == "cdesignation")) { $(this).val('0'); }
				//else if(prefix == "taxtype") { }
				//else { $(this).val(''); }
				$(this).val('');

				$(this).removeAttr('value');
				$(this).removeAttr("disabled");

				/* Start-Rename the error elements */
				clone.find("td").find('label').each(function () {
					if ($(this).attr('for') === id) {
						$(this).attr('for', prefix + '_' + (+t));
						$(this).html("");
					}
				});
				/* End-Rename the error elements */
			}
		});
	});
	$("#addRowTable tr:eq(" + rowindex + ")").after(clone);
	//$("#addRowTable").append(clone);
});

$(document.body).on('click', '.delrowbtn', function () {
	var getid = $(this).attr('id');
	var j = $("#addRowTable > tbody > tr").length;
	if (j <= 1) {
		alert("There should be at least one row");
	}
	else {
		var cnf = confirm("Are you sure to delete the row ?");
		if (cnf) {
			$("#" + getid).closest('tr').remove();
		}
	}
});


/* End - Add and/or Delete Row in jQuery */











jQuery(document).ready(function() {
	// var base_url = $("#base_url").val();
	// alert(base_url);
	jQuery.validator.addMethod("regex",function(value,element,regexp){
		var re= new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},"Remove Special Chars");
	
	jQuery.validator.addMethod('selectcheck', function (value) {
		return (value != '0');
	}, "Select");

	jQuery.validator.addMethod("greaterThan", function(value, element, params) {
		if (!/Invalid|NaN/.test(new Date(value))) {
			if(value != "" && $(params).val() != "") {
				return new Date(value) >= new Date($(params).val());
			}
		}
		return true; 
	},'Must be greater than {0}.');

    $.validator.addMethod("recaptcha", function(value, element, param) {
        if (grecaptcha.getResponse().length === 0) {
          return false;
        } else {
          return true;
        }
    }, "Please complete the reCAPTCHA");
	
	$.validator.addMethod("phoneUS", function(value, element) {
        phone_number = value.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && 
        phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");

	/* Contact Form */
	jQuery("#form_contact").validate({
        rules: {
            cont_name: {
                required: true                
            },
            cont_email: {
                required: true,
                email: true
            },           
            cont_phone: {
				required: true,
                regex: "^[0-9 \+-]+$"
            },
            cont_details: {
                required: true                
            },
            recaptcha: {
                recaptcha: true
            }
        },
        messages: {
            cont_name: {
                required: "Enter name."
            },
            cont_email: {
                required: "Enter email id",
                email: "Enter valid email"
            },
            cont_phone: {
				required: "Enter phone no.",
                regex: "Numbers only"
            },            
            cont_details: {
                required: "Enter enquiry details"
            },
            recaptcha: {
                recaptcha: "Please verify the reCAPTCHA"                
            }
        },
        submitHandler: function(form) {
            $('#errMessage').html('<div style="text-align:center"><i style="color:#377b9e" class="fa fa-spinner fa-spin fa-lg"></i> <span style="color:#377b9e">Processing...</span></div>');
           		
            $.ajax({
                url: base_url + "contactus/send_enquiry",
                type: 'post',
                cache: false,
                processData: false,
                data: $('#form_contact').serialize(),
                success: function(data) {
                    grecaptcha.reset();
                    data = jQuery.parseJSON(data);                  
                    if (data.status == "success") {                        
                        $('#form_contact')[0].reset();
                        $('#errMessage').html('<div class="successmsg"><i class="fa fa-check"></i> '+data.message+' </div>');
                    } 
					else {
                        $('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> '+data.message+' </div>');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    grecaptcha.reset();
                    alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    $('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> Your enquiry could not submitted. Please try again.</div>');
                }
            });
            return false;
        }
    });
    
    
    	/* form_itinerary_popup Form */
	jQuery("#form_itinerary_popup").validate({
        rules: {           
            email: {
                required: true,
                email: true
            },           
            phone: {
				required: true,
                regex: "^[0-9 \+-]+$"
            },
            tsdate: {
				required: true
            },
            duration: {
				required: true
            },
            tnote: {
                required: true                
            }
        },
        messages: {            
            email: {
                required: "Enter email id",
                email: "Enter valid email."
            },
            phone: {
				required: "Enter phone no.",
                regex: "Numbers only"
            },            
            tsdate: {
				required: "Choose date."
            },            
            duration: {
				required: "Choose duration."
            },            
            tnote: {
                required: "Enter trip details."
            }
        },
        submitHandler: function(form) {
            $('#errMessage').html('<div style="text-align:center"><i style="color:#377b9e" class="fa fa-spinner fa-spin fa-lg"></i> <span style="color:#377b9e">Processing...</span></div>');	
            $.ajax({
                url: base_url + "home/send_customization",
                type: 'post',
                cache: false,
                processData: false,
                data: $('#form_itinerary_popup').serialize(),
               // data: dataJson,
                success: function(data) {
                    grecaptcha.reset();
                    data = jQuery.parseJSON(data); 
                    if (data.status == "success") {                         
                        $('#form_itinerary_popup')[0].reset();
                        $('#errMessage').html('<div class="successmsg"><i class="fa fa-check"></i> '+data.message+' </div>');
                    } else {
                        $('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> '+data.message+' </div>');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    grecaptcha.reset();
                    alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    $('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> Your request for trip customize could not submitted. Please try again.</div>');
                }
            });
            return false;
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
	
	
	jQuery("#form_login").validate({
		rules: {
			login_email: {
				required: true,
				email: true
			},
			login_password: {
				required: true,
				regex:"^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$",
				rangelength: [6, 12]
			}
		},
		messages: {
			login_email: {
				required: "Enter email id",
				email: "Enter valid email"
			},
			login_password: {
				required: "Enter password",
				rangelength: "Password length must be between {0} to {1}"
			}
		}
	});

    jQuery("#change_password").validate({
		rules: {
			new_pwd: {
				required: true,
				regex:"^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$",
				rangelength: [6, 12]
			},
			cnf_pwd: {
				required: true,
				equalTo: "#new_pwd"
			}
		},
		messages:{
			new_pwd: {
				required:"Enter new password.",
				rangelength:"Password length must be between {0} to {1}"
			},
			cnf_pwd: {
				required:"Enter confirm password.",
				equalTo: "Enter same password again."
			}			
		}
	});
	
});

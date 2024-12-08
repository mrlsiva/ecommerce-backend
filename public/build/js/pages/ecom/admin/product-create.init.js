/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Ecommerce product create Js File
*/

// Form Event
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // date & time
    var date = new Date().toUTCString().slice(5, 16);
    function currentTime() {
        var ampm = new Date().getHours() >= 12 ? "PM" : "AM";
        var hour =
            new Date().getHours() > 12
                ? new Date().getHours() % 12
                : new Date().getHours();
        var minute =
            new Date().getMinutes() < 10
                ? "0" + new Date().getMinutes()
                : new Date().getMinutes();
        if (hour < 10) {
            return "0" + hour + ":" + minute + " " + ampm;
        } else {
            return hour + ":" + minute + " " + ampm;
        }
    }
    setInterval(currentTime, 1000); 

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
					
					initLoadingButton();
					var formData = new FormData(form);
					var formAction = formData.get('formAction');
					var actionUrl = "/admin/products/store";
					if(formAction == 'edit'){
						actionUrl = "/admin/products/update";
					}
					
					$.each(dropzone.getAcceptedFiles(),function(a,b){
						formData.append('image-gallery[]', dropzone.getAcceptedFiles()[a]);
					});			
					
					$.ajax({
						type: 'POST',
						url: actionUrl,
						data: formData,					
						cache: false,
						processData: false,
						contentType: false,
						success: function(response) {						
							if(response.success) {
								if(formAction !== 'edit'){
									resetForm(form);
									dropzone.removeAllFiles();
								}								
								initSweetalert('success', response.message);	
								resetLoadingButton();
							} else {
								initSweetalert('error', response.message);
								resetLoadingButton();
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							initSweetalert('error', textStatus+'. '+errorThrown);
							resetLoadingButton();
						}
					});
				
                    return false;
                }

                form.classList.add('was-validated');

            }, false)
        })
})()
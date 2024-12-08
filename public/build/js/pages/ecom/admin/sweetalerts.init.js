function initSweetalert(type, message){
	if(type == 'success'){ 
		Swal.fire({
            title: 'Success',
            text: message,
            icon: 'success',
            showCancelButton: true,            
            buttonsStyling: false,
            showCloseButton: true,
			customClass: {
				confirmButton: 'btn btn-primary w-xs me-2 mt-2',
				cancelButton: 'btn btn-danger w-xs mt-2',
			}
        });
	} else if(type == 'error'){		
		Swal.fire({
            title: 'Oops...',
            text: message,
            icon: 'error',            
            buttonsStyling: false,
            showCloseButton: true,
			customClass: {
				confirmButton: 'btn btn-primary w-xs me-2 mt-2',
				cancelButton: 'btn btn-danger w-xs mt-2',
			}
        });
	} else if(type == 'warning'){ 
		Swal.fire({
            title: 'Oops...',
            text: message,
            icon: 'warning',
            buttonsStyling: false,
            showCloseButton: true,
			customClass: {
				confirmButton: 'btn btn-primary w-xs me-2 mt-2',
				cancelButton: 'btn btn-danger w-xs mt-2',
			}
        });
	} else {
		Swal.fire({
            title: message,
            buttonsStyling: false,
            showCloseButton: true,
			customClass: {
				confirmButton: 'btn btn-primary w-xs me-2 mt-2',
				cancelButton: 'btn btn-danger w-xs mt-2',
			}			
        });
	}	
}


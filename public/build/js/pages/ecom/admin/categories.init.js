/* Category Listing Page */
var categoriesTable = document.getElementById("table-category-list-all");
if(categoriesTable) {
	var categoriesListAll = new gridjs.Grid({
		columns:
			[
				{
					name: '#',
					width: '40px',
					sort: {
						enabled: false
					},
					data: (function (row) {
						return gridjs.html('<div class="form-check checkbox-product-list">\
						<input class="form-check-input" type="checkbox" value="'+ row.id + '" id="checkbox-' + row.id + '">\
						<label class="form-check-label" for="checkbox-'+ row.id + '"></label>\
					  </div>');
					})
				},
				{
					name: 'Category',
					width: '360px',
					data: (function (row) {
						let imageUrl = row.media && row.media[0] && row.media[0].original_url;        
						// Check if the image URL exists
						if (!imageUrl || imageUrl === '') {
							// Use the default thumbnail if the image URL is missing
							imageUrl = BASE_URL+'/public/build/images/products/thumbnail.jpg'; // Replace with the actual path
						}
						return gridjs.html('<div class="d-flex align-items-center">' +
							'<div class="flex-shrink-0 me-3">' +
							'<div class="avatar-sm bg-light rounded p-1"><img src="' + imageUrl + '" alt="" class="img-fluid d-block"></div>' +
							'</div>' +
							'<div class="flex-grow-1">' +
							'<h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details" class="text-body">' + row.name + '</a></h5>' +
							'</div>' +
							'</div>');
					})
				},
				{
					name: "Action",
					width: '80px',
					sort: {
						enabled: false
					},
					formatter: (function (cell, row) {
						var x = new DOMParser().parseFromString(row._cells[0].data.props.content, "text/html").body.querySelector(".checkbox-product-list .form-check-input").value
						return gridjs.html('<div class="dropdown">' +
							'<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
							'<i class="ri-more-fill"></i>' +
							'</button>' +
							'<ul class="dropdown-menu dropdown-menu-end">' +
							'<li><a class="dropdown-item edit-list" data-edit-id=' + x + ' href="'+BASE_URL+'/admin/categories/edit/'+x+'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>' +
							'<li class="dropdown-divider"></li>' +
							'<li><a class="dropdown-item remove-list" href="#" data-id=' + x + ' data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>' +
							'</ul>' +
							'</div>');
					})
				}
			],
		className: {
			th: 'text-muted',
		},
		pagination: {
			limit: 10
		},
		sort: true,
		server: {
		url: BASE_URL+'/api/admin/categories/get',
		then: data => data.data,
		handle: (res) => {
		  // no matching records found
		  if (res.status === 404) return {data: []};
		  if (res.ok) return res.json();
		  
		  throw Error('oh no :(');
		},
	  } 	
	}).render(categoriesTable);
}

// Form Event
$(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation'); 
   
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
					
					var actionUrl = BASE_URL+"/api/admin/categories/store";
					if(formAction == 'edit'){
						actionUrl = BASE_URL+"/api/admin/categories/update";
					} 					
					$.ajax({
						type: 'POST',
						url: actionUrl,
						data: formData, 
						processData: false,
						contentType: false,
						success: function(response) {
							if(response.success) {
								if(formAction !== 'edit'){
									resetForm(form);
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

        });	
		
		
		const deleteModal = document.getElementById('removeItemModal');
		if(deleteModal){
			const deleteCategory = document.getElementById('deleteCategory');		
			let deleteButton; // To keep track of the button that triggered the modal
			deleteModal.addEventListener('show.bs.modal', function (event) {
				deleteButton  = event.relatedTarget; // Button that triggered the modal
				const id = deleteButton.getAttribute('data-id'); // Extract the ID from data-id attribute
				deleteCategory.setAttribute('data-id', id); // Set the form action dynamically		
			});
			
			deleteCategory.addEventListener('submit', function (event) {
				
				event.preventDefault();
				
				//initLoadingButton();
				
				const id = deleteCategory.getAttribute('data-id');
				
				const bootstrapModal = bootstrap.Modal.getInstance(deleteModal);
				bootstrapModal.hide();
				
				var actionUrl = BASE_URL+`/api/admin/categories/delete/${id}`;							
				$.ajax({
					type: 'DELETE',
					url: actionUrl,
					//data: formData, 
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					processData: false,
					contentType: false,
					success: function(response) {
						if(response.success) {		
							categoriesListAll.updateConfig({
								data: fetch(BASE_URL+'/api/admin/categories/get') // Update with your data-fetching URL
									.then(res => res.json()),
							}).forceRender();		
							
							initSweetalert('success', response.message);	
							//resetLoadingButton();
						} else {
							initSweetalert('error', response.message);
							//resetLoadingButton();
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						initSweetalert('error', textStatus+'. '+errorThrown);
						//resetLoadingButton();
					}
				});
				return false;
			}, false)
		}
})			

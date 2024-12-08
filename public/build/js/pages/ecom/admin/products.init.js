/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Ecommerce product list Js File
*/

/* New Code */
var productListAll = new gridjs.Grid({
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
				name: 'Product',
				width: '250px',
				data: (function (row) {
					
					let imageUrl = row.media.map(media => {						
						return media.collection_name === 'product_image' ? media.original_url : null;
					}).filter(url => url !== null);
									
					// Check if the image URL exists
					if (imageUrl === '' || imageUrl.length === 0 ) {
						// Use the default thumbnail if the image URL is missing
						imageUrl = BASE_URL+'/build/images/products/thumbnail.jpg'; // Replace with the actual path
					}
					return gridjs.html('<div class="d-flex align-items-center">' +
						'<div class="flex-shrink-0 me-3">' +
						'<div class="avatar-sm bg-light rounded p-1"><img src="' + imageUrl + '" alt="" class="img-fluid d-block"></div>' +
						'</div>' +
						'<div class="flex-grow-1">' +
						'<h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details" class="text-body">' + row.name + '</a></h5>' +
						'<p class="text-muted mb-0">Category : <span class="fw-medium">' + '' + '</span></p>' +
						'</div>' +
						'</div>');
				})
			},			
			{
				name: 'Price',
				width: '100px',
				data: (function (row) {
					return gridjs.html('$' + row.price);
				})
			},
			{
				name: 'Stocks',
				width: '100px',
				data: (function (row) {					
					let stocks = row.stocks !== null ? row.stocks : '0';
					return gridjs.html(stocks);
				})
			},
			{
				name: 'Status',
				width: '100px',
				data: (function (row) {
					return gridjs.html(row.status);
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
						'<li><a class="dropdown-item" href="#"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>' +
						'<li><a class="dropdown-item edit-list" data-edit-id=' + x + ' href="/admin/products/edit/'+x+'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>' +
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
	url: '/api/admin/products/get',
    then: data => data.data
  } 	
}).render(document.getElementById("table-product-list-all"));

const deleteModal = document.getElementById('removeItemModal');
if(deleteModal){
	const deleteProduct = document.getElementById('deleteProduct');		
	let deleteButton; // To keep track of the button that triggered the modal
	deleteModal.addEventListener('show.bs.modal', function (event) {
		deleteButton  = event.relatedTarget; // Button that triggered the modal
		const id = deleteButton.getAttribute('data-id'); // Extract the ID from data-id attribute
		deleteProduct.setAttribute('data-id', id); // Set the form action dynamically		
	});
	
	deleteProduct.addEventListener('submit', function (event) {		
		event.preventDefault();
		
		const id = deleteProduct.getAttribute('data-id');		
		const bootstrapModal = bootstrap.Modal.getInstance(deleteModal);
		bootstrapModal.hide();
		
		var actionUrl = `/api/admin/products/delete/${id}`;							
		$.ajax({
			type: 'DELETE',
			url: actionUrl,			 
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			processData: false,
			contentType: false,
			success: function(response) {
				if(response.success) {		
					productListAll.updateConfig({
						data: fetch('/api/admin/products/get') // Update with your data-fetching URL
							.then(res => res.json()),
					}).forceRender();		
					
					initSweetalert('success', response.message);
				} else {
					initSweetalert('error', response.message);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				initSweetalert('error', textStatus+'. '+errorThrown);
			}
		});
		return false;
	}, false)
}



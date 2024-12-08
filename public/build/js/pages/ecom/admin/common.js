var ckeditor = document.querySelector("#ckeditor-classic");
if(ckeditor) {
	ClassicEditor
		.create(document.querySelector('#ckeditor-classic'))
		.then(function (editor) {
			editor.ui.view.editable.element.style.height = '200px';
		})
		.catch(function (error) {
			console.error(error);
		});
}

function resetForm(form){
	form.reset();
	var preview = document.getElementById("image-preview-thumb");	
	if(preview){
		preview.src = '';
	}
}

function initLoadingButton(){		
	document.querySelector(".spinner-border").classList.remove("d-none");
}	

function resetLoadingButton(){		
	document.querySelector(".spinner-border").classList.add("d-none");
}	

var imageFileInput = document.getElementById("image-upload-input");
if(imageFileInput){
	document.querySelector("#image-upload-input").addEventListener("change", function () {
		var preview = document.querySelector("#image-preview-thumb");
		var file = document.querySelector("#image-upload-input").files[0];
		var reader = new FileReader();
		reader.addEventListener("load",function () {
			preview.src = reader.result;
		},false);
		if (file) {
			reader.readAsDataURL(file);
		}
	});
}

// Dropzone
var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
if(dropzonePreviewNode) {
	dropzonePreviewNode.itemid = "";
	var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
	dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
	var attachment = [];
	var dropzone = new Dropzone(".dropzone", {
		url: 'https://httpbin.org/post',
		method: "post",
		previewTemplate: previewTemplate,
		previewsContainer: "#dropzone-preview"
	});
}
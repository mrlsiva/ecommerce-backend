@extends('layouts.master')
@section('title')
    @lang('translation.create-product')
@endsection
@section('css')
	<link rel="stylesheet" href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" type="text/css" />
@endsection
@php
$pageType = $action == 'add' ? 'Add' : 'Edit';            
@endphp
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Ecommerce
        @endslot
        @slot('title')			
            {{$pageType == 'Edit' ? $pageType : 'Create' }} Product
        @endslot
    @endcomponent

    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
		@csrf
        <div class="row">
            <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Product Title</label>
                                    <input type="hidden" class="form-control" id="formAction" name="formAction" value="{{$action}}">
                                    <input type="text" class="form-control d-none" id="product-id-input" name="product_id" value="{{ old('id', $product[0]->id ?? '') }}">
                                    <input type="text" class="form-control" id="product-title-input" name="product-name" value="{{ old('name', $product[0]->name ?? '') }}" placeholder="Enter product title" required>
                                    <div class="invalid-feedback">Please Enter a product title.</div>
                                </div>
                            </div>
                            <div>
                                <label>Product Description</label>

								<textarea id="ckeditor-classic"name="description" >
									{{ old('description', $product[0]->description ?? '') }}
								</textarea>		                                
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Gallery</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h5 class="fs-14 mb-1">Product Image</h5>
                                <p class="text-muted">{{$pageType}} Product main Image.</p>
                                <div class="text-center">
                                    <div class="position-relative d-inline-block">
                                        <div class="position-absolute top-100 start-100 translate-middle">
                                            <label for="image-upload-input" class="mb-0"  data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                            <input class="form-control d-none" name="image-thumb" value="" id="image-upload-input" type="file"
                                                accept="image/png, image/gif, image/jpeg">
                                        </div>
										@php $media = null; @endphp
										@if($product[0] && $product[0]->hasMedia('product_image')) 
											@php $media = $product[0]->getFirstMedia('product_image'); @endphp
										@endif	
                                        <div class="avatar-lg">
                                            <div class="avatar-title bg-light rounded">
                                                 <img src="{{ $media ? $media->getUrl() : '' }}" id="image-preview-thumb" class="preview-thumb avatar-md h-auto" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h5 class="fs-14 mb-1">Product Gallery</h5>
                                <p class="text-muted">{{$pageType}} Product Gallery Images.</p>

                                <div class="dropzone">
                                    <div class="fallback">
                                        <input name="file" name="image-gallery" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                        </div>

                                        <h5>Drop files here or click to upload.</h5>
                                    </div>
                                </div>							
                                <ul class="list-unstyled mb-0" id="dropzone-preview">
									<li class="mt-2" id="dropzone-preview-list">
										<!-- This is used as the file preview template -->
										<div class="border rounded">
											<div class="d-flex p-2">
												<div class="flex-shrink-0 me-3">
													<div class="avatar-sm bg-light rounded">
														<img data-dz-thumbnail name="product-gallery" src="" class="img-fluid rounded d-block" src="#" alt="Product-Image" />
													</div>
												</div>
												<div class="flex-grow-1">
													<div class="pt-1">
														<h5 class="fs-14 mb-1" data-dz-name></h5>
														<p class="fs-13 text-muted mb-0" data-dz-size></p>
														<strong class="error text-danger" data-dz-errormessage></strong>
													</div>
												</div>
												<div class="flex-shrink-0 ms-3">
													<button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
												</div>
											</div>
										</div>
									</li>
										
                                </ul>
								
								

                                <!-- end dropzon-preview -->
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-header">
							<h5 class="card-title mb-0">General Info</h5>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                             <div class="row">								
								<div class="col-lg-3 col-sm-6">
									<div class="mb-3">
										<label class="form-label" for="product-price-input">Price</label>
										<div class="input-group has-validation mb-3">
											<span class="input-group-text" id="product-price-addon">$</span>
											<input type="text" class="form-control" name="price" id="product-price-input" placeholder="Enter price" aria-label="Price" aria-describedby="product-price-addon" value="{{ old('price', $product[0]->price ?? '') }}" required>
											<div class="invalid-feedback">Please Enter a product price.</div>
										</div>

									</div>
								</div>
								<div class="col-lg-3 col-sm-6">
									<div class="mb-3">
										<label class="form-label" for="product-discount-input">Discount</label>
										<div class="input-group mb-3">
											<span class="input-group-text" id="product-discount-addon">%</span>
											<input type="text" class="form-control" name="discount" id="product-discount-input" placeholder="Enter discount" aria-label="discount" aria-describedby="product-discount-addon" value="{{ old('discount', $product[0]->discount ?? '') }}">
										</div>
									</div>
								</div>	
								<div class="col-lg-3 col-sm-6">
									<div class="mb-3">
										<label class="form-label" for="stocks-input">Stocks</label>
										<input type="text" class="form-control" name="stocks" id="stocks-input" value="{{ old('stocks', $product[0]->stocks ?? '') }}" placeholder="Stocks" required>
										<div class="invalid-feedback">Please Enter a product stocks.</div>
									</div>
								</div>								
								<!-- end col -->
							</div>
							<!-- end row -->
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm btn-load">
							<span class="d-flex align-items-center">
								<span class="flex-grow-1 me-2">
									 {{$pageType == 'Edit' ? 'Update' : 'Create' }}  Product
								</span>
								<span class="spinner-border flex-shrink-0 d-none" role="status">
									<span class="visually-hidden">Loading...</span>
								</span>
							</span>	
						
						</button>
                    </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
							<label for="product-status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="product-status">
                                <option value="published" {{ old('status', $product[0]->status ?? '') == 'published' ? 'selected' : ''}}>Published</option>
                                <option value="draft" {{ old('status', $product[0]->status ?? '') == 'draft' ? 'selected' : ''}}>Draft</option>
                            </select>
                        </div>

                        <div>
                            <label for="visibility" class="form-label">Visibility</label>
                            <select class="form-select" name="visibility" id="visibility">
                                <option value="public" {{ old('visibility', $product[0]->visibility ?? '') == 'public' ? 'selected' : ''}}>Public</option>
                                <option value="hidden" {{ old('visibility', $product[0]->visibility ?? '') == 'hidden' ? 'selected' : ''}}>Hidden</option>
                            </select>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->                

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Categories</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"> Select product category</p>
                            <select class="form-select" id="category_id" name="category_id" required>
								<option selected disabled>Select Category</option>	
                                @if(!empty($categories))
									@foreach($categories as $i => $cate)										 
										<option value="{{$cate->id}}" {{ old('category_id', $product[0]->category_id ?? '') == $cate->id ? 'selected' : ''}}>{{$cate->name}}</option>
									@endforeach 
								@endif
                            </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            
				<div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Short Description</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">{{$pageType}} short description for product</p>
                        <textarea class="form-control" name="short-description" placeholder="Must enter minimum of a 100 characters" rows="3">{{ old('short_description', $product[0]->short_description ?? '') }}</textarea>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
        </div>
        <!-- end row -->
    </form>
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/ecom/admin/sweetalerts.init.js') }}"></script>
<script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/ecom/admin/common.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/ecom/admin/product-actions.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

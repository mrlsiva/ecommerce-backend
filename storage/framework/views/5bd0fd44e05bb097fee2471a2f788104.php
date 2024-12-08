<?php $__env->startSection('title'); ?>
    Categories
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/nouislider/nouislider.min.css')); ?>" >
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/gridjs/theme/mermaid.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Ecommerce
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Create Category
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <form id="createcategory-form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
        <?php echo csrf_field(); ?>
		<div class="row">
            <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label" for="category-title-input">Category Title</label>
                                    <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                    <input type="text" class="form-control d-none" id="category-id-input">
                                    <input type="text" class="form-control" name="name" id="category-title-input" value="" placeholder="Enter category title" required>
                                    <div class="invalid-feedback">Please Enter a category title.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Category Image</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h5 class="fs-14 mb-1">Category Image</h5>
                                <p class="text-muted">Add Category main Image.</p>
                                <div class="text-center">
                                    <div class="position-relative d-inline-block">
                                        <div class="position-absolute top-100 start-100 translate-middle">
                                            <label for="image-upload-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                            <input class="form-control d-none" name="image-thumb" value="" id="image-upload-input" type="file"
                                                accept="image/png, image/gif, image/jpeg" required>
                                        </div>
                                        <div class="avatar-lg">
                                            <div class="avatar-title bg-light rounded">
                                                <img src="" id="image-preview-thumb" class="preview-thumb avatar-md h-auto" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								
                            </div>
                           
                        </div>
                    </div>
                    <!-- end card -->

                 
                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm btn-load">
							<span class="d-flex align-items-center">
								<span class="flex-grow-1 me-2">
									Submit
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
                        <h5 class="card-title mb-0">Category Parent</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"> Select category parent</p>					
                            <select class="form-select" id="category_parent" name="category_parent">
                                <option value="0" selected>No Parent</option>	
								<?php if(!empty($categories)): ?>
									<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										   <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
								<?php endif; ?>								
                            </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
              

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Category Order</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">Enter category order value</p>
                       <input type="number" class="form-control" name="order" id="category-order-input" value="0" placeholder="Enter category order" required>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>

        </div>
        <!-- end row -->
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/ecom/admin/sweetalerts.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/dropzone/dropzone-min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/ecom/admin/common.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/ecom/admin/categories.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel\ecommerce-backend\resources\views/ecom/add-category.blade.php ENDPATH**/ ?>
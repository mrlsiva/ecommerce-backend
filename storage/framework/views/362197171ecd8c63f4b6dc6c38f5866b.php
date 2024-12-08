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
            Categories
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div>
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row g-4">
                            <div class="col-sm-auto">
                                <div>
                                    <a href="<?php echo e(route('category-create-form')); ?>" class="btn btn-success" id="addproduct-btn"><i
                                            class="ri-add-line align-bottom me-1"></i> Add Category</a>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control" id="searchProductList" placeholder="Search Categories...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                               
                            </div>
                            <div class="col-auto">
                                <div id="selection-element">
                                    <div class="my-n1 d-flex align-items-center text-muted">
                                        Select <div id="select-content" class="text-body fw-semibold px-1"></div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeItemModal">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                         <div id="table-category-list-all" class="table-card gridjs-border-none"></div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->


     <!-- removeItemModal -->
     <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
             </div>
             <div class="modal-body">
                 <div class="mt-2 text-center">
                     <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                         colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                     <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                         <h4>Are you Sure ?</h4>
                         <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Category?</p>
                     </div>
                 </div>
                 <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                     <button type="button" class="btn w-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
					 <form id="deleteCategory" method="POST">
						<?php echo csrf_field(); ?>
						<?php echo method_field('DELETE'); ?>
						<button type="submit" class="btn w-sm btn-danger">Yes, Delete It!</button>
					</form>                  
                 </div>
             </div>

         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
	<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('build/js/pages/ecom/admin/sweetalerts.init.js')); ?>"></script>   
    <script src="<?php echo e(URL::asset('build/libs/gridjs/gridjs.umd.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/ecom/admin/categories.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel\ecommerce-backend\resources\views/ecom/categories.blade.php ENDPATH**/ ?>
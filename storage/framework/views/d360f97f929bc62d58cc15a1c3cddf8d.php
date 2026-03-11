

<?php $__env->startSection('title', $category->name . ' Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4"><?php echo e($category->name); ?></h1>
        <?php if($category->description): ?>
            <p class="lead"><?php echo e($category->description); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="<?php echo e($product->image_url ?? 'https://via.placeholder.com/300'); ?>" 
                 class="card-img-top" 
                 alt="<?php echo e($product->name); ?>"
                 style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title"><?php echo e($product->name); ?></h5>
                <p class="card-text text-success fw-bold">Rs<?php echo e(number_format($product->price, 2)); ?></p>
                <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-primary w-100">
                    View Details
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12">
        <div class="alert alert-info">
            No products found in this category.
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="d-flex justify-content-center mt-4">
    <?php echo e($products->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/store/category.blade.php ENDPATH**/ ?>
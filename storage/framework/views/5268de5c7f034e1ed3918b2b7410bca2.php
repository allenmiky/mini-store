

<?php $__env->startSection('title', 'Home - FlownexStore'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-light p-5 rounded-3 mb-4">
    <div class="container py-4">
        <h1 class="display-4">Welcome to Flownex Store! 🛍️</h1>
        <p class="lead">Your one-stop shop for amazing products at best prices.</p>
        <hr class="my-4">
        <p>Shop from hundreds of products with fast delivery.</p>
        <a class="btn btn-primary btn-lg" href="<?php echo e(route('products')); ?>" role="button">
            Start Shopping
        </a>
    </div>
</div>

<?php if(isset($categories) && $categories->count() > 0): ?>
<div class="row mt-5">
    <h2 class="text-center mb-4">Shop by Category</h2>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title"><?php echo e($category->name); ?></h5>
                <p class="card-text text-muted"><?php echo e($category->products_count ?? 0); ?> Products</p>
                <a href="<?php echo e(route('category.show', $category->slug)); ?>" class="btn btn-outline-primary">
                    View Category
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<?php if(isset($latestProducts) && $latestProducts->count() > 0): ?>
<div class="row mt-5">
    <h2 class="text-center mb-4">Latest Products</h2>
    <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="<?php echo e($product->image_url ?? 'https://via.placeholder.com/300'); ?>" 
                 class="card-img-top" 
                 alt="<?php echo e($product->name); ?>"
                 style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title"><?php echo e($product->name); ?></h5>
                <p class="card-text text-success fw-bold">Rs<?php echo e(number_format($product->price, 2)); ?></p>
                <p class="card-text">
                    <small class="text-muted"><?php echo e($product->category->name ?? 'Uncategorized'); ?></small>
                </p>
                <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-primary w-100">
                    View Details
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/store/index.blade.php ENDPATH**/ ?>
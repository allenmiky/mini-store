

<?php $__env->startSection('title', 'All Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5>Filters</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('products')); ?>" method="GET">
                    <div class="mb-3">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control" value="<?php echo e(request('search')); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Sort By</label>
                        <select name="sort" class="form-control">
                            <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Newest First</option>
                            <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    <a href="<?php echo e(route('products')); ?>" class="btn btn-secondary w-100 mt-2">Clear Filters</a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 mb-4">
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    No products found.
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/store/products.blade.php ENDPATH**/ ?>
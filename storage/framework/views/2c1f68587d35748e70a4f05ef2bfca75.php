

<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <img src="<?php echo e($product->image_url ?? 'https://via.placeholder.com/600'); ?>" 
                 class="card-img-top" 
                 alt="<?php echo e($product->name); ?>"
                 style="height: 400px; object-fit: contain;">
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="mb-3"><?php echo e($product->name); ?></h1>
                
                <p class="text-muted mb-2">
                    Category: 
                    <a href="<?php echo e(route('category.show', $product->category->slug)); ?>">
                        <?php echo e($product->category->name); ?>

                    </a>
                </p>
                
                <h2 class="text-success mb-3">Rs<?php echo e(number_format($product->price, 2)); ?></h2>
                
                <div class="mb-3">
                    <span class="badge bg-<?php echo e($product->stock > 0 ? 'success' : 'danger'); ?> fs-6 p-2">
                        <?php echo e($product->stock > 0 ? 'In Stock' : 'Out of Stock'); ?>

                    </span>
                    
                    <?php if($product->stock > 0): ?>
                        <span class="ms-3 text-muted"><?php echo e($product->stock); ?> units available</span>
                    <?php endif; ?>
                </div>
                
                <?php if($product->stock > 0): ?>
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="number" 
                               id="quantity" 
                               class="form-control form-control-lg" 
                               value="1" 
                               min="1" 
                               max="<?php echo e($product->stock); ?>">
                    </div>
                    <div class="col-md-8">
                        <button class="btn btn-success btn-lg w-100" 
                                id="add-to-cart" 
                                data-product-id="<?php echo e($product->id); ?>">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="fas fa-times-circle"></i> Out of Stock
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if(isset($relatedProducts) && $relatedProducts->count() > 0): ?>
<div class="row mt-5">
    <h3 class="mb-4">Related Products</h3>
    <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="<?php echo e($related->image_url ?? 'https://via.placeholder.com/300'); ?>" 
                 class="card-img-top" 
                 alt="<?php echo e($related->name); ?>"
                 style="height: 150px; object-fit: cover;">
            <div class="card-body">
                <h6 class="card-title"><?php echo e($related->name); ?></h6>
                <p class="text-success fw-bold">Rs<?php echo e(number_format($related->price, 2)); ?></p>
                <a href="<?php echo e(route('product.show', $related->slug)); ?>" 
                   class="btn btn-sm btn-outline-primary w-100">
                    View Details
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>


   
                <div class="mb-4 mt-79">
                    <h5>Description:</h5>
                    <p class="text-muted"><?php echo e($product->description ?? 'No description available.'); ?></p>
                </div>

<?php $__env->startPush('scripts'); ?>
<script>
    $('#add-to-cart').click(function() {
        let productId = $(this).data('product-id');
        let quantity = $('#quantity').val();
        
        $.ajax({
            url: '<?php echo e(route("cart.add")); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    alert('✅ Product added to cart successfully!');
                    updateCartCount();
                } else {
                    alert('❌ ' + response.message);
                }
            },
            error: function() {
                alert('❌ Error adding to cart. Please try again.');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/store/product.blade.php ENDPATH**/ ?>
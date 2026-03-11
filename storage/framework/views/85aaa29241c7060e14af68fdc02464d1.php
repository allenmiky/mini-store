

<?php $__env->startSection('title', 'Shopping Cart'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="mb-4">Shopping Cart</h1>

<?php if(empty($cart)): ?>
<div class="text-center py-5">
    <h3>Your cart is empty</h3>
    <a href="<?php echo e(route('products')); ?>" class="btn btn-primary mt-3">
        Continue Shopping
    </a>
</div>
<?php else: ?>
<div class="row">
    <div class="col-md-8">
        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-3" id="cart-item-<?php echo e($id); ?>">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="<?php echo e($item['image'] ?? 'https://via.placeholder.com/150'); ?>" 
                         class="img-fluid rounded-start" 
                         alt="<?php echo e($item['name']); ?>"
                         style="height: 150px; object-fit: cover;">
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title"><?php echo e($item['name']); ?></h5>
                            <button class="btn btn-sm btn-danger remove-item" data-product-id="<?php echo e($id); ?>">
                                Remove
                            </button>
                        </div>
                        <p class="card-text"><strong>Price:</strong> Rs<?php echo e(number_format($item['price'], 2)); ?></p>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Quantity:</label>
                                <input type="number" class="form-control quantity-input" 
                                       value="<?php echo e($item['quantity']); ?>" 
                                       min="1" 
                                       max="<?php echo e($item['stock']); ?>"
                                       data-product-id="<?php echo e($id); ?>">
                            </div>
                            <div class="col-md-4">
                                <strong>Subtotal:</strong>
                                <span class="item-subtotal">Rs<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cart Summary</h5>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total:</span>
                    <strong class="cart-total">Rs<?php echo e(number_format($total, 2)); ?></strong>
                </div>
                <a href="<?php echo e(route('products')); ?>" class="btn btn-outline-primary w-100 mb-2">
                    Continue Shopping
                </a>
                <a href="<?php echo e(route('cart.clear')); ?>" class="btn btn-outline-danger w-100" 
                   onclick="return confirm('Clear cart?')">
                    Clear Cart
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $('.quantity-input').on('change', function() {
        let productId = $(this).data('product-id');
        let quantity = $(this).val();
        
        $.ajax({
            url: '<?php echo e(route("cart.update")); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    $(`#cart-item-${productId} .item-subtotal`).text('Rs' + response.item_total.toFixed(2));
                    $('.cart-total').text('Rs' + response.cart_total.toFixed(2));
                }
            }
        });
    });
    
    $('.remove-item').on('click', function() {
        let productId = $(this).data('product-id');
        
        if (confirm('Remove item from cart?')) {
            $.ajax({
                url: '<?php echo e(route("cart.remove")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        $(`#cart-item-${productId}`).fadeOut(300, function() {
                            $(this).remove();
                            $('.cart-total').text('Rs' + response.cart_total.toFixed(2));
                            updateCartCount();
                            if ($('.cart-item').length === 0) {
                                location.reload();
                            }
                        });
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/cart/index.blade.php ENDPATH**/ ?>
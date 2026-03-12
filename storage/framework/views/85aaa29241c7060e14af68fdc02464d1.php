

<?php $__env->startSection('title', 'Shopping Cart'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="mb-4">Shopping Cart</h1>

    <?php if(empty($cart)): ?>
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-shopping-cart fa-4x text-muted"></i>
        </div>
        <h3>Your cart is empty</h3>
        <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
        <a href="<?php echo e(route('products')); ?>" class="btn btn-primary mt-3">
            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
        </a>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-md-8">
            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card mb-3 shadow-sm" id="cart-item-<?php echo e($id); ?>">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img src="<?php echo e($item['image'] ?? 'https://via.placeholder.com/150'); ?>" 
                             class="img-fluid rounded-start p-2" 
                             alt="<?php echo e($item['name']); ?>"
                             style="height: 150px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title"><?php echo e($item['name']); ?></h5>
                                    <p class="card-text text-muted mb-1">
                                        <small>Stock: <?php echo e($item['stock'] ?? 'In Stock'); ?></small>
                                    </p>
                                </div>
                                <button class="btn btn-sm btn-outline-danger remove-item" 
                                        data-product-id="<?php echo e($id); ?>"
                                        title="Remove item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <div class="row mt-3 align-items-center">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <label class="me-2 mb-0"><strong>Price:</strong></label>
                                        <span class="fw-bold text-primary"> <?php echo e(number_format($item['price'], 2)); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <label class="me-2 mb-0"><strong>Qty:</strong></label>
                                        <input type="number" 
                                               class="form-control form-control-sm quantity-input" 
                                               style="width: 80px;"
                                               value="<?php echo e($item['quantity']); ?>" 
                                               min="1" 
                                               max="<?php echo e($item['stock'] ?? 10); ?>"
                                               data-product-id="<?php echo e($id); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-end">
                                        <small class="text-muted d-block">Subtotal:</small>
                                        <strong class="item-subtotal text-success">
                                             <?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?>

                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Cart Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span class="cart-subtotal"> <?php echo e(number_format($total, 2)); ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span> <?php echo e(number_format($shipping ?? 0, 2)); ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (10%):</span>
                        <span> <?php echo e(number_format($tax ?? 0, 2)); ?></span>
                    </div>
                    
                    <?php if(isset($discount) && $discount > 0): ?>
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount:</span>
                        <span>- <?php echo e(number_format($discount, 2)); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total:</strong>
                        <strong class="cart-total text-primary h5 mb-0"> <?php echo e(number_format($total, 2)); ?></strong>
                    </div>
                    
                    <!-- Checkout Button - Important -->
                    <a href="<?php echo e(route('checkout')); ?>" class="btn btn-success w-100 mb-2">
                        <i class="fas fa-lock me-2"></i>Proceed to Checkout
                    </a>
                    
                    <a href="<?php echo e(route('products')); ?>" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                    </a>
                    
                    <a href="<?php echo e(route('cart.clear')); ?>" class="btn btn-outline-danger w-100" 
                       onclick="return confirm('Are you sure you want to clear your cart?')">
                        <i class="fas fa-trash me-2"></i>Clear Cart
                    </a>
                    
                    <!-- Payment Methods Icons -->
                    <div class="text-center mt-3">
                        <small class="text-muted d-block mb-2">We Accept</small>
                        <i class="fab fa-cc-visa fa-2x text-secondary me-1"></i>
                        <i class="fab fa-cc-mastercard fa-2x text-secondary me-1"></i>
                        <i class="fab fa-cc-amex fa-2x text-secondary me-1"></i>
                        <i class="fab fa-cc-paypal fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Update quantity
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
                    // Update item subtotal
                    $(`#cart-item-${productId} .item-subtotal`).text(' ' + response.item_total.toFixed(2));
                    
                    // Update cart totals
                    $('.cart-subtotal').text(' ' + response.cart_total.toFixed(2));
                    $('.cart-total').text(' ' + response.cart_total.toFixed(2));
                    
                    // Show success message (optional)
                    toastr.success('Cart updated successfully');
                } else {
                    toastr.error(response.message || 'Failed to update cart');
                }
            },
            error: function(xhr) {
                toastr.error('Error updating cart');
                console.error(xhr.responseText);
            }
        });
    });
    
    // Remove item
    $('.remove-item').on('click', function() {
        let productId = $(this).data('product-id');
        
        if (confirm('Remove this item from cart?')) {
            $.ajax({
                url: '<?php echo e(route("cart.remove")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        // Fade out and remove item
                        $(`#cart-item-${productId}`).fadeOut(300, function() {
                            $(this).remove();
                            
                            // Update totals
                            $('.cart-subtotal').text(' ' + response.cart_total.toFixed(2));
                            $('.cart-total').text(' ' + response.cart_total.toFixed(2));
                            
                            // Update cart count in navbar
                            updateCartCount(response.cart_count);
                            
                            // If cart is empty, reload to show empty cart message
                            if ($('.cart-item').length === 0) {
                                location.reload();
                            }
                        });
                        
                        toastr.success('Item removed from cart');
                    }
                },
                error: function(xhr) {
                    toastr.error('Error removing item');
                    console.error(xhr.responseText);
                }
            });
        }
    });
    
    
    // Update cart count function
    function updateCartCount(count) {
        $('.cart-count').text(count);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/cart/index.blade.php ENDPATH**/ ?>
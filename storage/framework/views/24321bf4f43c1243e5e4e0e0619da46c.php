

<?php $__env->startSection('title', 'Order Confirmed'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Success Header -->
    <div class="text-center mb-5">
        <div class="mb-4">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="fas fa-check fa-3x"></i>
            </div>
        </div>
        <h1 class="display-5 fw-bold text-success mb-3">Thank You for Your Order!</h1>
        <p class="lead text-muted">Your order has been placed successfully.</p>
    </div>

    <!-- Order Details Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-receipt text-primary me-2"></i>
                        Order Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Order Info -->
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted d-block mb-1">Order Number</small>
                                <strong class="h6"><?php echo e($order->order_number); ?></strong>
                                <br>
                                <small class="text-muted">Placed on <?php echo e($order->created_at->format('F j, Y')); ?></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted d-block mb-1">Order Status</small>
                                <span class="badge bg-warning text-dark px-3 py-2"><?php echo e(ucfirst($order->status)); ?></span>
                                <br>
                                <small class="text-muted">Payment: 
                                    <span class="badge <?php echo e($order->payment_status == 'paid' ? 'bg-success' : 'bg-warning'); ?>">
                                        <?php echo e(ucfirst($order->payment_status)); ?>

                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($item->product && $item->product->image_url): ?>
                                                <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product_name); ?>" 
                                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-box text-secondary"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ms-3">
                                                <span class="fw-bold"><?php echo e($item->product_name); ?></span>
                                                <?php if($item->options): ?>
                                                    <small class="text-muted d-block">
                                                        <?php $__currentLoopData = json_decode($item->options, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e(ucfirst($key)); ?>: <?php echo e($value); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                                    <td class="text-end">$<?php echo e(number_format($item->price, 2)); ?></td>
                                    <td class="text-end fw-bold">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="row justify-content-end mt-4">
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-3">Order Summary</h6>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span>$<?php echo e(number_format($order->subtotal, 2)); ?></span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping:</span>
                                    <span>$<?php echo e(number_format($order->shipping_cost, 2)); ?></span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tax:</span>
                                    <span>$<?php echo e(number_format($order->tax, 2)); ?></span>
                                </div>
                                
                                <?php if($order->discount > 0): ?>
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span class="text-muted">Discount:</span>
                                    <span>-$<?php echo e(number_format($order->discount, 2)); ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <hr class="my-3">
                                
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span class="text-primary h5 mb-0">$<?php echo e(number_format($order->total, 2)); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping & Payment Info -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-truck text-primary me-2"></i>
                                Shipping Information
                            </h6>
                            <address class="mb-0">
                                <strong><?php echo e($order->customer_first_name); ?> <?php echo e($order->customer_last_name); ?></strong><br>
                                <?php echo e($order->shipping_address); ?><br>
                                <?php if($order->shipping_apartment): ?>
                                    <?php echo e($order->shipping_apartment); ?><br>
                                <?php endif; ?>
                                <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_zip); ?><br>
                                <?php echo e($order->shipping_country); ?><br>
                                <abbr title="Phone">P:</abbr> <?php echo e($order->customer_phone); ?><br>
                                <abbr title="Email">E:</abbr> <?php echo e($order->customer_email); ?>

                            </address>
                            <hr>
                            <div>
                                <small class="text-muted">Shipping Method:</small>
                                <span class="badge bg-info text-dark ms-2"><?php echo e(ucfirst($order->shipping_method)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                Payment Information
                            </h6>
                            
                            <div class="d-flex align-items-center mb-3">
                                <?php if($order->payment_method == 'card'): ?>
                                    <i class="fas fa-credit-card fa-2x text-secondary me-3"></i>
                                    <div>
                                        <span class="fw-bold">Credit/Debit Card</span><br>
                                        <small class="text-muted">
                                            <?php if($order->transaction_id): ?>
                                                Transaction: <?php echo e(substr($order->transaction_id, -8)); ?>

                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    
                                <?php elseif($order->payment_method == 'paypal'): ?>
                                    <i class="fab fa-paypal fa-2x text-primary me-3"></i>
                                    <div>
                                        <span class="fw-bold">PayPal</span><br>
                                        <small class="text-muted">
                                            <?php if($order->transaction_id): ?>
                                                Transaction: <?php echo e(substr($order->transaction_id, -8)); ?>

                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    
                                <?php elseif($order->payment_method == 'cod'): ?>
                                    <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                                    <div>
                                        <span class="fw-bold">Cash on Delivery</span><br>
                                        <small class="text-muted">Pay when you receive</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Payment Status:</span>
                                    <span class="badge <?php echo e($order->payment_status == 'paid' ? 'bg-success' : 'bg-warning'); ?>">
                                        <?php echo e(ucfirst($order->payment_status)); ?>

                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Order Date:</span>
                                    <span><?php echo e($order->created_at->format('M d, Y h:i A')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-5">
                <div>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-home me-2"></i>Continue Shopping
                    </a>
                    
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-history me-2"></i>View Orders
                    </a>
                    <?php endif; ?>
                </div>
                
                <button onclick="window.print()" class="btn btn-light">
                    <i class="fas fa-print me-2"></i>Print Receipt
                </button>
            </div>

            <!-- Email Confirmation Message -->
            <div class="alert alert-success mt-4 mb-0">
                <i class="fas fa-envelope me-2"></i>
                A confirmation email has been sent to <strong><?php echo e($order->customer_email); ?></strong>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<?php $__env->startPush('styles'); ?>
<style>
@media print {
    .navbar, .footer, .btn, .alert {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/checkout/success.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Orders</h2>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
        </a>
    </div>

    <?php if($orders->isEmpty()): ?>
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
        <h4>No orders yet</h4>
        <p class="text-muted">Looks like you haven't placed any orders.</p>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-primary mt-3">
            Start Shopping
        </a>
    </div>
    <?php else: ?>
    <div class="row">
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <small class="text-muted">Order #</small>
                            <h6 class="mb-0"><?php echo e($order->order_number); ?></h6>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Date</small>
                            <p class="mb-0"><?php echo e($order->created_at->format('M d, Y')); ?></p>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Total</small>
                            <p class="mb-0 fw-bold">$<?php echo e(number_format($order->total, 2)); ?></p>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                <?php
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger'
                                    ][$order->status] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo e($statusClass); ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="<?php echo e(route('orders.show', $order)); ?>" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-4">
        <?php echo e($orders->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/orders/index.blade.php ENDPATH**/ ?>
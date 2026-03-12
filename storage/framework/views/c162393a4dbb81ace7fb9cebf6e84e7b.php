

<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Products</h3>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">Add New Product</a>
    </div>
    <div class="card-body">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td>
                        <img src="<?php echo e($product->image_url ?? 'https://via.placeholder.com/50'); ?>" width="50" height="50" style="object-fit: cover;">
                    </td>
                    <td><?php echo e($product->name); ?></td>
                    <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                    <td>Rs<?php echo e(number_format($product->price, 2)); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($product->stock > 0 ? 'success' : 'danger'); ?>">
                            <?php echo e($product->stock); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge bg-<?php echo e($product->status == 'active' ? 'success' : 'danger'); ?>">
                            <?php echo e($product->status); ?>

                        </span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-sm btn-info">Edit</a>
                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mini-store\resources\views/admin/products/index.blade.php ENDPATH**/ ?>
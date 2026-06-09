<?php if($paginator->hasPages()): ?>
    <nav>
        <ul class="pagination">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="disabled" aria-disabled="true"><span>Sebelumnya</span></li>
            <?php else: ?>
                <li><a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">Sebelumnya</a></li>
            <?php endif; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li><a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">Selanjutnya</a></li>
            <?php else: ?>
                <li class="disabled" aria-disabled="true"><span>Selanjutnya</span></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/vendor/pagination/simple-default.blade.php ENDPATH**/ ?>
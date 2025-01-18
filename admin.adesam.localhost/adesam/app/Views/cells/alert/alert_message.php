<?php if (!empty(session()->getFlashData('success'))): ?>
    <section class="mt-4">
        <div class="alert alert-success d-flex align-items-center mb-0 border-radius" role="alert">
            <i class='bx bxs-check-circle me-2'></i>
            <div>
                <?= session()->getFlashData('success'); ?>
            </div>
        </div>
    </section>
<?php elseif (!empty(session()->getFlashData('fail'))): ?>
    <section class="mt-4">
        <div class="alert alert-danger d-flex align-items-center mb-0 border-radius" role="alert">
            <i class='bx bxs-error me-2'></i>
            <div>
                <?= session()->getFlashData('fail'); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if (!empty(session()->getFlashData('success'))): ?>
    <section class="my-4">
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class='bx bxs-check-circle me-2'></i>
            <div>
                <?= session()->getFlashData('success'); ?>
            </div>
        </div>
    </section>
<?php elseif (!empty(session()->getFlashData('fail'))): ?>
    <section class="my-4">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class='bx bxs-error me-2'></i>
            <div>
                <?= session()->getFlashData('fail'); ?>
            </div>
        </div>
    </section>
<?php elseif (!empty(session()->getFlashData('successes'))): ?>
    <section class="my-4">
        <?php foreach (session()->getFlashData('successes') as $value): ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class='bx bxs-check-circle me-2'></i>
                <p class="mb-0"><?= $value; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
<?php elseif (!empty(session()->getFlashData('fails'))): ?>
    <section class="my-4">
        <?php foreach (session()->getFlashData('fails') as $value): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class='bx bxs-error me-2'></i>
                <p class="mb-0"><?= $value; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
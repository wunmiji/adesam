<?= $this->include('include/header'); ?>

<main>
    <section class="mb-5">
        <?= $this->renderSection('corousel'); ?>
    </section>

    <section class="container">
        <?= $this->renderSection('content') ?>
    </section>
</main>

<?= $this->include('include/footer'); ?>
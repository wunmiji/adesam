<div class="my-4">
    <?php $validation = \Config\Services::validation(); ?>
    <form action="<?= $action; ?>" method="POST">
        <div class="row row-cols-1">

            <div>
                <input type="hidden" name="parentId" value="<?= $uuid; ?>" />
            </div>
            <div class="col mb-4">
                <textarea class="form-control" name="comments" id="commentTextarea" rows="5"
                    placeholder="Add to discussion"></textarea>
                <?php if ($validation->getError('comments')): ?>
                    <span class="text-danger text-sm">
                        <?= $error = $validation->getError('comments'); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="col">
                <button type="submit" name="submit" class="btn primary-btn">Post Comment</button>
            </div>
        </div>
    </form>
</div>
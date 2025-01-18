<div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header justify-content-between">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filters</h5>
        <i class='bx bx-x bx-md' role="button" data-bs-dismiss="offcanvas" aria-label="Close"></i>
    </div>
    <div class="offcanvas-body">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <?php if (isset($categories)): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Category
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body px-0">
                            <div class="d-flex flex-column row-gap-2">
                                <?php if (empty($categories)): ?>
                                    <p>No data yet</p>
                                <?php else: ?>
                                    <?php $categoryIndex = 0; ?>
                                    <?php foreach ($categories as $category): ?>
                                        <?php $categoryIndex++; ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="category-checkbox"
                                                value="<?= $category->slug; ?>" id="categoryCheckBox<?= $categoryIndex; ?>">
                                            <label class="form-check-label w-100" for="categoryCheckBox<?= $categoryIndex; ?>">
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-0"><?= $category->name; ?></p>
                                                    <p class="mb-0"><?= '(' . $category->countProducts . ')'; ?></p>
                                                </div>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Price
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body px-0">
                        <div class="d-flex justify-content-between">
                            <input type="text" name="min_price" id="min-price-input" class="form-control" value="0"
                                placeholder="Min" style="width: 100px" onkeypress="return onlyNumberKey(event)"
                                maxlength="7" />
                            <input type="text" name="max_price" id="max-price-input" class="form-control" value=""
                                placeholder="Max" style="width: 100px" onkeypress="return onlyNumberKey(event)"
                                maxlength="7" />
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($tags)): ?>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Tags
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body px-0">
                        <div class="d-flex flex-wrap column-gap-4 row-gap-2">
                            <?php if (empty($tags)): ?>
                                <p>No data yet</p>
                            <?php else: ?>
                                <?php $tagIndex = 0; ?>
                                <?php foreach ($tags as $tag): ?>
                                    <?php $tagIndex++; ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="tag-checkbox"
                                            value="<?= $tag->slug; ?>" id="tagCheckBox<?= $tagIndex; ?>">
                                        <label class="form-check-label" for="tagCheckBox<?= $tagIndex; ?>">
                                            <?= $tag->name; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                        Sort
                    </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body px-0">
                        <div class="d-flex flex-column row-gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort-radio" value="alphabet"
                                    id="sortCheckBox1">
                                <label class="form-check-label" for="sortCheckBox1">
                                    Alphabetically, A to Z
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort-radio" value="alphabet-desc"
                                    id="sortCheckBox2">
                                <label class="form-check-label" for="sortCheckBox2">
                                    Alphabetically, Z to A
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort-radio" value="date"
                                    id="sortCheckBox3">
                                <label class="form-check-label" for="sortCheckBox3">
                                    Date, old to new
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort-radio" value="date-desc"
                                    id="sortCheckBox4">
                                <label class="form-check-label" for="sortCheckBox4">
                                    Date, new to old
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort-radio" value="price"
                                    id="sortCheckBox5">
                                <label class="form-check-label" for="sortCheckBox5">
                                    Price, low to high
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort-radio" value="price-desc"
                                    id="sortCheckBox6">
                                <label class="form-check-label" for="sortCheckBox6">
                                    Price, high to low
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                        Show
                    </button>
                </h2>
                <div id="flush-collapseFive" class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body px-0">
                        <div class="d-flex flex-column row-gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show-radio" value="5"
                                    id="showCheckBox1">
                                <label class="form-check-label" for="showCheckBox1">
                                    5
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show-radio" value="10"
                                    id="showCheckBox2">
                                <label class="form-check-label" for="showCheckBox2">
                                    10
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show-radio" value="20"
                                    id="showCheckBox3">
                                <label class="form-check-label" for="showCheckBox3">
                                    20
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show-radio" value="30"
                                    id="showCheckBox4">
                                <label class="form-check-label" for="showCheckBox4">
                                    30
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show-radio" value="40"
                                    id="showCheckBox5">
                                <label class="form-check-label" for="showCheckBox5">
                                    40
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show-radio" value="50"
                                    id="showCheckBox6">
                                <label class="form-check-label" for="showCheckBox6">
                                    50
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="my-3 d-flex justify-content-between">
            <a role="button" class="btn primary-btn" id="reply-btn">Reset</a>
            <a href="" class="btn primary-btn w-50" id="apply-btn">Apply</a>
        </div>
    </div>
</div>
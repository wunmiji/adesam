<form action="<?= '/search'; ?>" name="searchForm">
    <div class="input-group input-group-lg">
        <input type="text" class="form-control" placeholder="Search" name="q" style="border-color: #f2f3f8;"
            value="<?= $searchText; ?>" id="<?= $searchId; ?>">
        <button class="btn primary-btn" type="submit" value="submit"
            onclick="return searchValidation('<?= $searchId; ?>')">Search</button>
    </div>
</form>
<?= view('layout/header', ['title' => 'Product / Asset Entry']) ?>

<div class="form-container">
    <div style="text-align: center; margin-bottom: 25px;">
        <div class="card-icon" style="margin: 0 auto;"><?= get_icon('layer') ?></div>
        <h2 style="margin-top: 15px; margin-bottom: 0;">Inventory Management</h2>
    </div>

    <form action="/product/store" method="post" id="productForm" novalidate>
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" id="name" maxlength="25" placeholder="e.g. Dell Latitude Laptop" required>
            <div class="validation-status-icon"></div>
            <div id="nameError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Category / Type</label>
            <input type="text" name="category" id="category" placeholder="e.g. Electronics, Furniture" required>
            <div class="validation-status-icon"></div>
            <div id="categoryError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Unit Price (INR)</label>
            <input type="number" name="price" id="price" step="0.01" placeholder="0.00" required>
            <div class="validation-status-icon"></div>
            <div id="priceError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock" id="stock" placeholder="Initial units in stock" required>
            <div class="validation-status-icon"></div>
            <div id="stockError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Description / Features</label>
            <textarea name="description" id="description" placeholder="Brief technical specifications..." style="width: 100%; border-radius: 12px; padding: 12px; border: 1px solid var(--border); background: #f8fafc; font-family: inherit; font-size: 14px;" required></textarea>
            <div class="validation-status-icon"></div>
            <div id="descError" class="validation-error"></div>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('/product') ?>" class="btn-secondary">Check Inventory</a>
            <button type="submit" class="btn-submit" id="submitBtn">Log Product</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= base_url('js/form-validations.js') ?>"></script>

<script>
    $(document).ready(function() {
        const validator = new FormValidator();
        validator.initLiveIcons('#productForm');

        $('#name').on('input blur', function() {
            const val = $(this).val().trim();
            if (val === "") {
                validator.showError('#nameError', 'Product name is required.');
            } else {
                validator.hideError('#nameError');
            }
        });

        $('#category').on('input blur', function() {
            const val = $(this).val().trim();
            if (val === "") {
                validator.showError('#categoryError', 'Category is required.');
            } else {
                validator.hideError('#categoryError');
            }
        });

        $('#price').on('input blur', function() {
            const val = $(this).val();
            if (val === "" || val < 0) {
                validator.showError('#priceError', 'Valid price is required.');
            } else {
                validator.hideError('#priceError');
            }
        });

        $('#stock').on('input blur', function() {
            const val = $(this).val();
            if (val === "" || val < 0) {
                validator.showError('#stockError', 'Valid stock count is required.');
            } else {
                validator.hideError('#stockError');
            }
        });

        $('#description').on('input blur', function() {
            const val = $(this).val().trim();
            if (val === "") {
                validator.showError('#descError', 'Product description is required.');
            } else {
                validator.hideError('#descError');
            }
        });

        $('#productForm').on('submit', function(e) {
            let isValid = true;
            
            if ($('#name').val().trim() === "") {
                validator.showError('#nameError', 'Product name is required.');
                isValid = false;
            }
            if ($('#category').val().trim() === "") {
                validator.showError('#categoryError', 'Category is required.');
                isValid = false;
            }
            if ($('#price').val() === "" || $('#price').val() < 0) {
                validator.showError('#priceError', 'Valid price is required.');
                isValid = false;
            }
            if ($('#stock').val() === "" || $('#stock').val() < 0) {
                validator.showError('#stockError', 'Valid stock count is required.');
                isValid = false;
            }
            if ($('#description').val().trim() === "") {
                validator.showError('#descError', 'Product description is required.');
                isValid = false;
            }
            
            if (!isValid) e.preventDefault();
        });
    });
</script>

<?= view('layout/footer') ?>
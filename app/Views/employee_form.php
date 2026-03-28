<?= view('layout/header', ['title' => 'Employee Registration']) ?>

<div class="form-container">
    <div style="text-align: center; margin-bottom: 25px;">
        <div class="card-icon" style="margin: 0 auto;"><?= get_icon('admin') ?></div>
        <h2 style="margin-top: 15px; margin-bottom: 0;">Employee Profile</h2>
    </div>

    <form action="/employee/store" method="post" id="employeeForm" novalidate>
        <div class="form-group">
            <label>Employee Name</label>
            <input type="text" name="name" id="name" maxlength="20" placeholder="Full legal name" required>
            <div class="validation-status-icon"></div>
            <div id="nameError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Official Email</label>
            <input type="email" name="email" id="email" maxlength="25" placeholder="staff@university.edu" required>
            <div class="validation-status-icon"></div>
            <div id="emailError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Department / Division</label>
            <input type="text" name="department" id="department" maxlength="25" placeholder="e.g. Engineering, HR" required>
            <div class="validation-status-icon"></div>
            <div id="deptError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Salary / Annual CTC (LPA)</label>
            <input type="number" name="salary" id="salary" placeholder="Enter amount in Lakhs" required>
            <div class="validation-status-icon"></div>
            <div id="salaryError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Joining Date</label>
            <input type="date" name="joining_date" id="joining_date" required>
            <div class="validation-status-icon"></div>
            <div id="dateError" class="validation-error"></div>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('/employee') ?>" class="btn-secondary">View HR Directory</a>
            <button type="submit" class="btn-submit" id="submitBtn">Create Profile</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= base_url('js/form-validations.js') ?>"></script>

<script>
    $(document).ready(function() {
        const validator = new FormValidator();
        validator.initLiveIcons('#employeeForm');

        $('#name').on('input blur', function(e) {
            if (e.type === 'input') this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            validator.validateName($(this).val(), '#nameError');
        });

        $('#email').on('input blur', function() {
            validator.validateEmail($(this).val(), '#emailError');
        });

        $('#salary').on('input blur', function() {
             validator.validateSalary($(this).val(), '#salaryError');
        });

        $('#department').on('input blur', function() {
            if ($(this).val().trim() === "") {
                validator.showError('#deptError', 'Department is required.');
            } else {
                validator.hideError('#deptError');
            }
        });

        $('#joining_date').on('change blur', function() {
            if ($(this).val() === "") {
                validator.showError('#dateError', 'Joining date is required.');
            } else {
                validator.hideError('#dateError');
            }
        });

        $('#employeeForm').on('submit', function(e) {
            let isValid = true;
            if (!validator.validateName($('#name').val(), '#nameError')) isValid = false;
            if (!validator.validateEmail($('#email').val(), '#emailError')) isValid = false;
            if (!validator.validateSalary($('#salary').val(), '#salaryError')) isValid = false;
            
            if ($('#department').val().trim() === "") {
                validator.showError('#deptError', 'Department is required.');
                isValid = false;
            }
            if ($('#joining_date').val() === "") {
                validator.showError('#dateError', 'Joining date is required.');
                isValid = false;
            }

            if (!isValid) e.preventDefault();
        });
    });
</script>

<?= view('layout/footer') ?>
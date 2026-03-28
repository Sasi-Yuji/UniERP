<?= view('layout/header', ['title' => 'Course Registration']) ?>

<div class="form-container">
    <div style="text-align: center; margin-bottom: 25px;">
        <div class="card-icon" style="margin: 0 auto;"><?= get_icon('report') ?></div>
        <h2 style="margin-top: 15px; margin-bottom: 0;">Course Enrollment</h2>
    </div>

    <form action="/course/store" method="post" id="courseForm" novalidate>
        <div class="form-group">
            <label>Student Name</label>
            <input type="text" name="student_name" id="name" maxlength="20" placeholder="Registered student name" required>
            <div class="validation-status-icon"></div>
            <div id="nameError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Academic Email</label>
            <input type="email" name="email" id="email" maxlength="25" placeholder="student@university.edu" required>
            <div class="validation-status-icon"></div>
            <div id="emailError" class="validation-error"></div>
        </div>


        <div class="form-group">
            <label>Select Semester</label>
            <select name="semester" id="sem" required>
                <option value="" disabled selected>Select Semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
                <option value="7">Semester 7</option>
                <option value="8">Semester 8</option>
            </select>
            <div class="validation-status-icon"></div>
            <div id="semError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Course Name / Code</label>
            <input type="text" name="course_name" id="course_name" maxlength="25" placeholder="e.g. CS101 - Algorithms" required>
            <div class="validation-status-icon"></div>
            <div id="courseError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Tuition Fees / Total (INR)</label>
            <input type="number" name="fees" id="fees" placeholder="Enter amount" required>
            <div class="validation-status-icon"></div>
            <div id="feesError" class="validation-error"></div>
        </div>


        <div class="form-actions">
            <a href="<?= base_url('/course') ?>" class="btn-secondary">View Registry</a>
            <button type="submit" class="btn-submit" id="submitBtn">Submit Registration</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= base_url('js/form-validations.js') ?>"></script>

<script>
    $(document).ready(function() {
        const validator = new FormValidator();
        validator.initLiveIcons('#courseForm');

        $('#name').on('input blur', function(e) {
            if (e.type === 'input') this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            validator.validateName($(this).val(), '#nameError');
        });

        $('#email').on('input blur', function() {
            validator.validateEmail($(this).val(), '#emailError');
        });

        $('#sem').on('change blur', function() {
            validator.validateSem($(this).val(), '#semError');
        });

        $('#course_name').on('input blur', function() {
            validator.validateCourse($(this).val(), '#courseError');
        });

        $('#fees').on('input blur', function() {
            const val = $(this).val().trim();
            if (val === "" || val < 0) {
                validator.showError('#feesError', 'Valid fees amount is required.');
            } else {
                validator.hideError('#feesError');
            }
        });

        $('#courseForm').on('submit', function(e) {
            let isValid = true;
            if (!validator.validateName($('#name').val(), '#nameError')) isValid = false;
            if (!validator.validateEmail($('#email').val(), '#emailError')) isValid = false;
            if (!validator.validateSem($('#sem').val(), '#semError')) isValid = false;
            if (!validator.validateCourse($('#course_name').val(), '#courseError')) isValid = false;
            
            const feesVal = $('#fees').val().trim();
            if (feesVal === "" || feesVal < 0) {
                validator.showError('#feesError', 'Valid fees amount is required.');
                isValid = false;
            }

            if (!isValid) e.preventDefault();
        });
    });
</script>

<?= view('layout/footer') ?>
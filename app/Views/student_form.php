<?= view('layout/header', ['title' => 'Student Registration']) ?>

<div class="form-container">
    <div style="text-align: center; margin-bottom: 25px;">
        <div class="card-icon" style="margin: 0 auto;"><?= get_icon('academic') ?></div>
        <h2 style="margin-top: 15px; margin-bottom: 0;">Student Registration</h2>
    </div>

    <form action="/save" method="post" id="studentForm" novalidate>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" id="name" maxlength="20" placeholder="Enter student's full name" required autofocus>
            <div class="validation-status-icon"></div>
            <div id="nameError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" id="email" maxlength="25" placeholder="example@university.edu" required>
            <div class="validation-status-icon"></div>
            <div id="emailError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" id="phone" placeholder="Mobile number" required>
            <div class="validation-status-icon"></div>
            <div id="phoneError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Program / Course</label>
            <input type="text" name="course" id="student_course" maxlength="25" placeholder="e.g. Computer Science" required>
            <div class="validation-status-icon"></div>
            <div id="courseError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" id="student_city" maxlength="25" placeholder="Residential city" required>
            <div class="validation-status-icon"></div>
            <div id="cityError" class="validation-error"></div>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('/student') ?>" class="btn-secondary">View Enrolled Students</a>
            <button type="submit" class="btn-submit">Complete Registration</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="<?= base_url('js/form-validations.js') ?>"></script>

<script>
    $(document).ready(function() {
        const validator = new FormValidator();
        const phoneInput = document.querySelector("#phone");
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "in",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        validator.initLiveIcons('#studentForm');

        function updatePhoneAttrs() {
            const countryData = iti.getSelectedCountryData();
            if (countryData && countryData.iso2 === 'in') {
                phoneInput.setAttribute('maxlength', '10');
            } else {
                phoneInput.setAttribute('maxlength', '15');
            }
        }
        
        phoneInput.addEventListener("countrychange", updatePhoneAttrs);
        updatePhoneAttrs();

        $('#name').on('input blur', function(e) {
            if (e.type === 'input') this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            validator.validateName($(this).val(), '#nameError');
        });

        $('#email').on('input blur', function() {
            validator.validateEmail($(this).val(), '#emailError');
        });

        $('#phone').on('input blur', function(e) {
            if (e.type === 'input') this.value = this.value.replace(/[^0-9]/g, '');
            validator.validateMobile(iti, $(this).val(), '#phoneError');
        });

        $('#student_course').on('input blur', function() {
            if ($(this).val().trim() === "") {
                validator.showError('#courseError', 'Course is required.');
            } else {
                validator.hideError('#courseError');
            }
        });

        $('#student_city').on('input blur', function() {
            if ($(this).val().trim() === "") {
                validator.showError('#cityError', 'City is required.');
            } else {
                validator.hideError('#cityError');
            }
        });

        $('#studentForm').on('submit', function(e) {
            let isValid = true;
            if (!validator.validateName($('#name').val(), '#nameError')) isValid = false;
            if (!validator.validateEmail($('#email').val(), '#emailError')) isValid = false;
            if (!validator.validateMobile(iti, $('#phone').val(), '#phoneError')) isValid = false;
            
            if ($('#student_course').val().trim() === "") {
                validator.showError('#courseError', 'Course is required.');
                isValid = false;
            }
            if ($('#student_city').val().trim() === "") {
                validator.showError('#cityError', 'City is required.');
                isValid = false;
            }

            if (!isValid) e.preventDefault();
        });
    });
</script>

<?= view('layout/footer') ?>
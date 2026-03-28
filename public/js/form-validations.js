class FormValidator {
    
    /**
     * Show error message
     * @param {string} elementId - ID of error message element (e.g., '#nameError')
     * @param {string} message - Error message to display
     */
    showError(elementId, message) {
        const $el = $(elementId);
        $el.text(message).addClass('visible');
        $el.closest('.form-group').removeClass('success').addClass('error');
    }

    /**
     * Hide error message
     * @param {string} elementId - ID of error message element
     */
    hideError(elementId) {
        const $el = $(elementId);
        $el.removeClass('visible');
        $el.text('');
        // Only mark as success if there was some input
        const input = $el.closest('.form-group').find('input, select, textarea');
        if (input.val() && input.val().trim() !== '') {
            $el.closest('.form-group').removeClass('error').addClass('success');
        } else {
            $el.closest('.form-group').removeClass('error').removeClass('success');
        }
    }

    /**
     * Validate Full Name
     */
    validateName(value, errorId = '#nameError') {
        const val = value.trim();
        const nameRegex = /^[a-zA-Z\s]+$/;
        
        if (val === "") {
            this.showError(errorId, 'Name is required.');
            return false;
        }
        else if (!nameRegex.test(val)) {
            this.showError(errorId, 'Name must contain only letters and spaces.');
            return false;
        }
        else if (val.length > 20) {
            this.showError(errorId, 'Name must not exceed 20 characters.');
            return false;
        }
        else {
            this.hideError(errorId);
            return true;
        }
    }

    /**
     * Validate Email Address
     */
    validateEmail(value, errorId = '#emailError') {
        const val = value.trim();
        const emailParts = val.split('@');
        
        if (val === "") {
            this.showError(errorId, 'Email is required.');
            return false;
        } 
        else if (emailParts.length !== 2) {
            this.showError(errorId, 'Invalid email. Include an @ symbol.');
            return false;
        } 
        else if (!/[a-zA-Z]/.test(emailParts[0])) {
            this.showError(errorId, 'Email must contain letters before @.');
            return false;
        } 
        else if (/\d/.test(emailParts[1])) {
            this.showError(errorId, 'Numbers are not allowed in the domain after @.');
            return false;
        } 
        else if (emailParts[1].toLowerCase().includes('gmail') && emailParts[1].toLowerCase() !== 'gmail.com') {
            this.showError(errorId, 'Invalid domain. Did you mean exactly gmail.com?');
            return false;
        } 
        else if (!/^[a-zA-Z.-]+\.[a-zA-Z]{2,}$/.test(emailParts[1])) {
            this.showError(errorId, 'Domain must be valid (e.g., domain.com).');
            return false;
        }
        else if (val.length > 25) {
            this.showError(errorId, 'Email must not exceed 25 characters.');
            return false;
        }
        else {
            this.hideError(errorId);
            return true;
        }
    }

    /**
     * Validate Mobile Number
     */
    validateMobile(iti, value, errorId = '#mobileError') {
        const val = value.trim();
        
        if (!iti) {
            if (val === "") {
                 this.showError(errorId, 'Mobile number is required.');
                 return false;
            }
            if (!/^[0-9]{10}$/.test(val)) {
                 this.showError(errorId, 'Mobile number must be 10 digits.');
                 return false;
            }
            this.hideError(errorId);
            return true;
        }

        const countryData = iti.getSelectedCountryData();
        const iso = countryData && countryData.iso2 ? countryData.iso2.toLowerCase() : '';
        const dialCode = countryData && countryData.dialCode ? countryData.dialCode : '';
        const countryName = countryData && countryData.name ? countryData.name : 'selected country';
        
        if (val === "") {
            this.showError(errorId, 'Mobile number is required.');
            return false;
        }
        
        if (iso === 'in' || dialCode === '91') {
            if (!/^[6-9]/.test(val)) {
                this.showError(errorId, 'Indian numbers must start with 6, 7, 8, or 9.');
                return false;
            }
            if (val.length !== 10) {
                this.showError(errorId, 'Indian mobile numbers must be exactly 10 digits.');
                return false;
            }
        } else {
            if (val.length > 15) {
                this.showError(errorId, 'Mobile numbers cannot exceed 15 digits.');
                return false;
            }
        }

        if (iti.isValidNumber()) {
            this.hideError(errorId);
            return true;
        } 
        else {
            const errorMsg = iso === 'in' || dialCode === '91' 
                ? 'Invalid Indian mobile number format.' 
                : 'Invalid format for ' + countryName + '.';
            this.showError(errorId, errorMsg);
            return false;
        }
    }

    /**
     * Validate Date of Birth
     */
    validateDOB(value, errorId = '#dobError', minAge = 18) {
        const val = value;
        
        if (val === "" || !val) {
            this.showError(errorId, 'Date of birth is required.');
            return false;
        }
        
        const dob = new Date(val);
        const today = new Date();
        
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        if (age < minAge) {
            this.showError(errorId, 'You must be at least ' + minAge + ' years old.');
            return false;
        }
        
        this.hideError(errorId);
        return true;
    }

    /**
     * Validate Salary (Annual CTC in LPA)
     */
    validateSalary(value, errorId = '#salaryError') {
        const val = parseFloat(value);
        if (isNaN(val) || value === "") {
            this.showError(errorId, 'Annual salary is required.');
            return false;
        }
        if (val <= 0) {
            this.showError(errorId, 'Salary must be a positive number.');
            return false;
        }
        if (val > 100) {
            this.showError(errorId, 'Salary seems too high (limit 100 LPA).');
            return false;
        }
        this.hideError(errorId);
        return true;
    }

    /**
     * Validate Semester selection
     */
    validateSem(value, errorId = '#semError') {
        if (!value || value === "") {
            this.showError(errorId, 'Semester is required.');
            return false;
        }
        this.hideError(errorId);
        return true;
    }

    /**
     * Validate Course Name/Code
     */
    validateCourse(value, errorId = '#courseError') {
        const val = value.trim();
        if (val === "") {
            this.showError(errorId, 'Course is required.');
            return false;
        }
        if (val.length < 3) {
            this.showError(errorId, 'Course must be at least 3 characters.');
            return false;
        }
        this.hideError(errorId);
        return true;
    }

    /**
     * Validate Incident Description (CKEditor content)
     */
    validateIncident(value, errorId = '#incidentError') {
        const val = value.replace(/<[^>]*>/g, '').trim();
        if (val === "") {
            this.showError(errorId, 'Description is required.');
            return false;
        }
        if (val.length < 10) {
            this.showError(errorId, 'Description must be at least 10 characters.');
            return false;
        }
        this.hideError(errorId);
        return true;
    }

    /**
     * Initialize live icons for any input
     */
    initLiveIcons(formId) {
        const self = this;
        $(formId).find('input, select, textarea').on('input blur change', function() {
            const $group = $(this).closest('.form-group');
            const val = $(this).val() ? $(this).val().toString().trim() : "";
            const isRequired = $(this).prop('required');
            const labelText = $group.find('label').text().replace('*', '').trim();
            const errorDiv = $group.find('.validation-error');
            const errorId = errorDiv.length ? '#' + errorDiv.attr('id') : null;

            if (val !== "") {
                $group.removeClass('error').addClass('success');
                if (errorId) self.hideError(errorId);
            } else if (isRequired) {
                $group.removeClass('success').addClass('error');
                if (errorId) {
                    self.showError(errorId, labelText + ' is required.');
                }
            } else {
                $group.removeClass('success').removeClass('error');
                if (errorId) self.hideError(errorId);
            }
        });
    }
}

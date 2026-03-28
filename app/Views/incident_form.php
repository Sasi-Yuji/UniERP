<?= view('layout/header', ['title' => 'Report Incident']) ?>

<!-- CKEditor -->
<script src="https://cdn.jsdelivr.net/npm/ckeditor4@4.22.1/ckeditor.js"></script>

<div class="form-container" style="max-width: 800px;">
    <div style="text-align: center; margin-bottom: 25px;">
        <div class="card-icon" style="margin: 0 auto;"><?= get_icon('minus') ?></div>
        <h2 style="margin-top: 15px; margin-bottom: 0;">Incident Report</h2>
    </div>

    <form action="/incident/save" method="post" id="incidentForm" novalidate>
        <div class="form-group">
            <label>Incident Title / Subject</label>
            <input type="text" name="title" id="title" placeholder="Short summary of the issue" required>
            <div class="validation-status-icon"></div>
            <div id="titleError" class="validation-error"></div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Department Involved</label>
                <select name="department" id="department" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="IT">IT Services</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Library">Library</option>
                    <option value="Admissions">Admissions</option>
                    <option value="Security">Security</option>
                </select>
                <div class="validation-status-icon"></div>
                <div id="deptError" class="validation-error"></div>
            </div>

            <div class="form-group">
                <label>Urgency / Priority</label>
                <select name="priority" id="priority" required>
                    <option value="" disabled selected>Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Critical">Critical / Urgent</option>
                </select>
                <div class="validation-status-icon"></div>
                <div id="priorityError" class="validation-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label>Incident Date</label>
            <input type="date" name="date" id="date" required>
            <div class="validation-status-icon"></div>
            <div id="dateError" class="validation-error"></div>
        </div>

        <div class="form-group">
            <label>Detailed Incident Description</label>
            <textarea name="description" id="description" placeholder="Please provide specific details..." required></textarea>
            <div class="validation-status-icon"></div>
            <div id="incidentError" class="validation-error"></div>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('/incident') ?>" class="btn-secondary">View Incident Logs</a>
            <button type="submit" class="btn-submit" id="submitBtn">Submit Report</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= base_url('js/form-validations.js') ?>"></script>

<script>
    $(document).ready(function() {
        CKEDITOR.config.versionCheck = false;
        CKEDITOR.replace('description');
        const validator = new FormValidator();
        validator.initLiveIcons('#incidentForm');

        $('#incidentForm').on('submit', function(e) {
            let isValid = true;
            CKEDITOR.instances.description.updateElement();
            const descValue = $('#description').val();

            if ($('#title').val().trim() === "") {
                validator.showError('#titleError', 'Title is required.');
                isValid = false;
            } else {
                validator.hideError('#titleError');
            }

            if ($('#department').val() === null) {
                validator.showError('#deptError', 'Please select a department.');
                isValid = false;
            } else {
                validator.hideError('#deptError');
            }

            if ($('#priority').val() === null) {
                validator.showError('#priorityError', 'Please select a priority.');
                isValid = false;
            } else {
                validator.hideError('#priorityError');
            }

            if ($('#date').val() === "") {
                validator.showError('#dateError', 'Date is required.');
                isValid = false;
            } else {
                validator.hideError('#dateError');
            }

            if (!validator.validateIncident(descValue, '#incidentError')) isValid = false;

            if (!isValid) e.preventDefault();
        });
    });
</script>

<?= view('layout/footer') ?>
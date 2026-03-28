<?= view('layout/header', ['title' => 'Dashboard']) ?>

<main class="dashboard-container">
    <header class="dashboard-header">
        <h1>Welcome to UniERP</h1>
        <p>Your centralized University Administration & Management System</p>
    </header>

    <div class="dashboard-grid">
        <!-- Student Module -->
        <div class="module-card">
            <div class="card-icon"><?= get_icon('academic') ?></div>
            <h3>Student Center</h3>
            <p>Enrollments & Records</p>
            <div class="card-actions">
                <a href="<?= base_url('/student') ?>" class="btn-card btn-card-list">List</a>
                <a href="<?= base_url('/student/create') ?>" class="btn-card btn-card-add">Add</a>
            </div>
        </div>

        <!-- Employee Module -->
        <div class="module-card">
            <div class="card-icon"><?= get_icon('admin') ?></div>
            <h3>HRMS Portal</h3>
            <p>Faculty & Staff Management</p>
            <div class="card-actions">
                <a href="<?= base_url('/employee') ?>" class="btn-card btn-card-list">List</a>
                <a href="<?= base_url('/employee/create') ?>" class="btn-card btn-card-add">Add</a>
            </div>
        </div>

        <!-- Course Module -->
        <div class="module-card">
            <div class="card-icon"><?= get_icon('report') ?></div>
            <h3>Course Registry</h3>
            <p>Semester Registrations</p>
            <div class="card-actions">
                <a href="<?= base_url('/course') ?>" class="btn-card btn-card-list">List</a>
                <a href="<?= base_url('/course/create') ?>" class="btn-card btn-card-add">Register</a>
            </div>
        </div>

        <!-- Product Module -->
        <div class="module-card">
            <div class="card-icon"><?= get_icon('layer') ?></div>
            <h3>Inventory</h3>
            <p>University Assets & Stock</p>
            <div class="card-actions">
                <a href="<?= base_url('/product') ?>" class="btn-card btn-card-list">List</a>
                <a href="<?= base_url('/product/create') ?>" class="btn-card btn-card-add">Add</a>
            </div>
        </div>

        <!-- Incident Module -->
        <div class="module-card">
            <div class="card-icon"><?= get_icon('minus') ?></div>
            <h3>Incident Logs</h3>
            <p>Safety & Maintenance</p>
            <div class="card-actions">
                <a href="<?= base_url('/incident') ?>" class="btn-card btn-card-list">Logs</a>
                <a href="<?= base_url('/incident/add') ?>" class="btn-card btn-card-add">Report</a>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section to fill empty space and add value -->
    <div class="activity-panel">
        <div class="activity-header">
            <h4>Live System Overview</h4>
            <span class="activity-time">Updated: <?= date('H:i') ?></span>
        </div>
        <div class="activity-list">
            <div class="activity-item">
                <span class="activity-dot"></span>
                <span>New Student Enrollment</span>
                <span class="activity-time">2m ago</span>
            </div>
            <div class="activity-item">
                <span class="activity-dot" style="background: var(--success)"></span>
                <span>Course Registration Open</span>
                <span class="activity-time">5m ago</span>
            </div>
            <div class="activity-item">
                <span class="activity-dot" style="background: var(--warning)"></span>
                <span>Incident Report Filed</span>
                <span class="activity-time">12m ago</span>
            </div>
            <div class="activity-item">
                <span class="activity-dot"></span>
                <span>Staff Profile Updated</span>
                <span class="activity-time">1h ago</span>
            </div>
        </div>
    </div>
</main>

<?= view('layout/footer') ?>

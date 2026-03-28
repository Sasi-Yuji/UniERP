<?= view('layout/header', ['title' => 'Employee List']) ?>

<div class="table-container">
    <h2>Employee List</h2>
    <a href="/employee/create" class="btn-add" style="margin-bottom:15px;">Add New Employee</a>
    
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th style="width: 150px;">Name</th>
                <th style="width: 150px;">Department</th>
                <th style="width: 100px;">Salary</th>
                <th>Email</th>
                <th style="width: 120px;">Joining Date</th>
                <th style="width: 110px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($employees as $emp): ?>
            <tr data-id="<?= $emp['id'] ?>">
                <td class="id-col"><?= $emp['id'] ?></td>
                <td class="editable" data-field="name"><?= $emp['name'] ?></td>
                <td class="editable" data-field="department"><?= $emp['department'] ?></td>
                <td class="editable" data-field="salary"><?= $emp['salary'] ?></td>
                <td class="editable" data-field="email"><?= $emp['email'] ?></td>
                <td class="editable" data-field="joining_date"><?= $emp['joining_date'] ?></td>
                <td>
                    <button class="btn-edit btn-action btn-primary" title="Edit"><?= get_icon('edit') ?></button>
                    <button class="btn-delete btn-action btn-danger" title="Delete"><?= get_icon('minus') ?></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="<?= base_url('js/uniAlert.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#myTable thead tr').clone(true).addClass('filter-row').appendTo('#myTable thead');
        $('#myTable thead .filter-row th').each(function(i) {
            var title = $(this).text();
            if (title !== 'Actions') {
                $(this).html('<input type="text" placeholder="Search '+title+'..." class="column-search-input" />');
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            } else {
                $(this).html('');
            }
        });

        var table = $('#myTable').DataTable({
            orderCellsTop: true
        });

        // Inline Edit
        $('#myTable tbody').on('click', '.btn-edit', function() {
            var tr = $(this).closest('tr');
            if(tr.hasClass('editing')) return;
            tr.addClass('editing');

            tr.find('.editable').each(function() {
                var val = $(this).text();
                var field = $(this).attr('data-field');
                var type = 'text';
                if(field === 'email') type = 'email';
                if(field === 'salary') type = 'number';
                if(field === 'joining_date') type = 'date';
                
                $(this).html('<input type="'+type+'" class="edit-input" data-field="'+field+'" value="'+val+'" style="width:100%; box-sizing:border-box; padding:5px;">');
            });

            $(this).parent().html('<button class="btn-save btn-action btn-success" title="Save"><?= get_icon('tick') ?></button> <button class="btn-cancel btn-action btn-secondary" title="Cancel"><?= get_icon('close') ?></button>');
        });

        // Cancel Edit
        $('#myTable tbody').on('click', '.btn-cancel', function() {
            var tr = $(this).closest('tr');
            tr.removeClass('editing');
            tr.find('.editable').each(function() {
                var input = $(this).find('input');
                var val = input[0].defaultValue; 
                $(this).text(val);
                table.cell(this).invalidate();
            });
            $(this).parent().html('<button class="btn-edit btn-action btn-primary" title="Edit"><?= get_icon('edit') ?></button> <button class="btn-delete btn-action btn-danger" title="Delete"><?= get_icon('minus') ?></button>');
        });

        // Save Edit
        $('#myTable tbody').on('click', '.btn-save', function() {
            var tr = $(this).closest('tr');
            var id = tr.attr('data-id');
            var updatedData = { id: id };
            tr.find('.edit-input').each(function() {
                updatedData[$(this).attr('data-field')] = $(this).val();
            });

            $.post('<?= base_url('/employee/ajaxUpdate') ?>', updatedData, function(response) {
                if(response.status === 'success') {
                    tr.removeClass('editing');
                    tr.find('.editable').each(function() {
                        var val = $(this).find('input').val();
                        $(this).text(val); 
                        table.cell(this).data(val); 
                    });
                    tr.find('td:last').html('<button class="btn-edit btn-action btn-primary" title="Edit"><?= get_icon('edit') ?></button> <button class="btn-delete btn-action btn-danger" title="Delete"><?= get_icon('minus') ?></button>');
                    uniToast('Employee updated successfully!');
                }
            }, 'json');
        });

        // Delete
        $('#myTable tbody').on('click', '.btn-delete', function() {
            var tr = $(this).closest('tr');
            var id = tr.attr('data-id');

            uniConfirm('Are you sure you want to delete this employee?', 'Confirm Deletion').then(function(confirmed) {
                if(!confirmed) return;
                
                $.post('<?= base_url('/employee/ajaxDelete') ?>', {id: id}, function(response) {
                    if(response.status === 'success') {
                        table.row(tr).remove().draw(false);
                    }
                }, 'json');
            });
        });
    });
</script>

</body>
</html>
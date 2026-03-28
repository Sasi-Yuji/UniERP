<?= view('layout/header', ['title' => 'Student List']) ?>

<div class="table-container">
    <h2>Student List</h2>
    <a href="<?= base_url('/student/create') ?>" class="btn-add" style="margin-bottom:15px;">Add Student</a>
    
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th style="width: 200px;">Name</th>
                <th>Email</th>
                <th style="width: 150px;">Phone</th>
                <th style="width: 150px;">Course</th>
                <th style="width: 150px;">City</th>
                <th style="width: 110px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($students)): ?>
                <?php foreach($students as $row): ?>
                <tr data-id="<?= $row['id'] ?>">
                    <td class="id-col"><?= $row['id'] ?></td>
                    <td class="editable" data-field="name"><?= $row['name'] ?></td>
                    <td class="editable" data-field="email"><?= $row['email'] ?></td>
                    <td class="editable" data-field="phone"><?= $row['phone'] ?></td>
                    <td class="editable" data-field="course"><?= $row['course'] ?></td>
                    <td class="editable" data-field="city"><?= $row['city'] ?></td>
                    <td>
                        <button class="btn-edit btn-action btn-primary" title="Edit"><?= get_icon('edit') ?></button>
                        <button class="btn-delete btn-action btn-danger" title="Delete"><?= get_icon('minus') ?></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- jQuery and DataTables JS -->
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
                var type = (field === 'email') ? 'email' : 'text';
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
                var val = input[0].defaultValue; // Original value
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

            $.post('<?= base_url('/student/ajaxUpdate') ?>', updatedData, function(response) {
                if(response.status === 'success') {
                    tr.removeClass('editing');
                    tr.find('.editable').each(function() {
                        var val = $(this).find('input').val();
                        $(this).text(val); // Update DOM
                        table.cell(this).data(val); // Update DataTable backing data
                    });
                    tr.find('td:last').html('<button class="btn-edit btn-action btn-primary" title="Edit"><?= get_icon('edit') ?></button> <button class="btn-delete btn-action btn-danger" title="Delete"><?= get_icon('minus') ?></button>');
                    uniToast('Student updated successfully!');
                }
            }, 'json');
        });

        // Delete
        $('#myTable tbody').on('click', '.btn-delete', function() {
            var tr = $(this).closest('tr');
            var id = tr.attr('data-id');

            uniConfirm('Are you sure you want to delete this student?', 'Confirm Deletion').then(function(confirmed) {
                if(!confirmed) return;
                
                $.post('<?= base_url('/student/ajaxDelete') ?>', {id: id}, function(response) {
                    if(response.status === 'success') {
                        table.row(tr).remove().draw(false);
                    }
                }, 'json');
            });
        });
    });
</script>

<?= view('layout/footer') ?>

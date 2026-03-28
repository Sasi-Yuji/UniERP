<?= view('layout/header', ['title' => 'Incident Logs']) ?>

<div class="table-container">
    <h2>Incident Logs</h2>
    <a href="<?= base_url('/incident/add') ?>" class="btn-add" style="margin-bottom:15px;">Add Incident</a>
    
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th style="width: 150px;">Title</th>
                <th>Description</th>
                <th style="width: 140px;">Department</th>
                <th style="width: 100px;">Priority</th>
                <th style="width: 120px;">Date</th>
                <th style="width: 110px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($incidents as $i): ?>
            <tr data-id="<?= $i['id'] ?>">
                <td class="id-col"><?= $i['id'] ?></td>
                <td class="editable" data-field="title"><?= $i['title'] ?></td>
                <td class="editable" data-field="description"><?= $i['description'] ?></td>
                <td class="editable" data-field="department"><?= $i['department'] ?></td>
                <td class="editable" data-field="priority"><?= $i['priority'] ?></td>
                <td class="editable" data-field="date"><?= $i['date'] ?></td>
                <td>
                    <button class="btn-edit btn-action btn-primary" title="Edit"><?= get_icon('edit') ?></button>
                    <button class="btn-delete btn-action btn-danger" title="Delete"><?= get_icon('minus') ?></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    /* Fix CKEditor width in table */
    .ck-editor__editable_inline {
        min-height: 80px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
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
                var field = $(this).attr('data-field');
                
                if (field === 'description') {
                    var val = $(this).html();
                    $(this).html('<textarea class="edit-input" data-field="'+field+'" style="width:100%;">'+val+'</textarea>');
                    ClassicEditor
                        .create( $(this).find('textarea')[0] )
                        .then( editor => {
                            $(this).data('ckeditor', editor);
                        })
                        .catch( error => {
                            console.error( error );
                        });
                } else {
                    var val = $(this).text();
                    var type = 'text';
                    if(field === 'date') type = 'date';
                    $(this).html('<input type="'+type+'" class="edit-input" data-field="'+field+'" value="'+val+'" style="width:100%; box-sizing:border-box; padding:5px;">');
                }
            });

            $(this).parent().html('<button class="btn-save btn-action btn-success" title="Save"><?= get_icon('tick') ?></button> <button class="btn-cancel btn-action btn-secondary" title="Cancel"><?= get_icon('close') ?></button>');
        });

        // Cancel Edit
        $('#myTable tbody').on('click', '.btn-cancel', function() {
            var tr = $(this).closest('tr');
            tr.removeClass('editing');
            tr.find('.editable').each(function() {
                var field = $(this).attr('data-field');
                
                if (field === 'description') {
                    var editor = $(this).data('ckeditor');
                    if (editor) {
                        editor.destroy();
                        $(this).removeData('ckeditor');
                    }
                    var originalData = table.cell(this).data();
                    $(this).html(originalData); 
                } else {
                    var input = $(this).find('input');
                    var val = input[0].defaultValue; 
                    $(this).text(val);
                }
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
                var field = $(this).attr('data-field');
                if (field === 'description') {
                    var editor = $(this).parent().data('ckeditor');
                    if (editor) {
                        updatedData[field] = editor.getData();
                    } else {
                        updatedData[field] = $(this).val();
                    }
                } else {
                    updatedData[field] = $(this).val();
                }
            });

            $.post('<?= base_url('/incident/ajaxUpdate') ?>', updatedData, function(response) {
                if(response.status === 'success') {
                    tr.removeClass('editing');
                    tr.find('.editable').each(function() {
                        var field = $(this).attr('data-field');
                        var val;
                        if (field === 'description') {
                            var editor = $(this).data('ckeditor');
                            if (editor) {
                                val = editor.getData();
                                editor.destroy();
                                $(this).removeData('ckeditor');
                            } else {
                                val = $(this).find('textarea').val();
                            }
                            $(this).html(val); 
                            table.cell(this).data(val); 
                        } else {
                            val = $(this).find('input').val();
                            $(this).text(val); 
                            table.cell(this).data(val); 
                        }
                    });
                    tr.find('td:last').html('<button class="btn-edit btn-action btn-primary" title="Edit"><?= get_icon('edit') ?></button> <button class="btn-delete btn-action btn-danger" title="Delete"><?= get_icon('minus') ?></button>');
                    uniToast('Incident updated successfully!');
                }
            }, 'json');
        });

        // Delete
        $('#myTable tbody').on('click', '.btn-delete', function() {
            var tr = $(this).closest('tr');
            var id = tr.attr('data-id');

            uniConfirm('Are you sure you want to delete this incident?', 'Confirm Deletion').then(function(confirmed) {
                if(!confirmed) return;
                
                $.post('<?= base_url('/incident/ajaxDelete') ?>', {id: id}, function(response) {
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
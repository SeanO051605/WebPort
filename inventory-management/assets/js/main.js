// main.js for Inventory Management System

document.addEventListener('DOMContentLoaded', function() {
    console.log('Inventory Management System loaded.');
    // Add your JS code here
    // Select All functionality
    const selectAll = document.getElementById('select-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => {
                cb.checked = selectAll.checked;
                cb.closest('tr').style.background = selectAll.checked ? '#c8e6c9' : '';
            });
        });
    }
    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            this.closest('tr').style.background = this.checked ? '#c8e6c9' : '';
            if (!this.checked && selectAll.checked) selectAll.checked = false;
            if ([...rowCheckboxes].every(cb => cb.checked)) selectAll.checked = true;
        });
    });

    // Edit Selected
    const editBtn = document.getElementById('edit-selected');
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
            if (selected.length === 0) {
                alert('Please select at least one item to edit.');
            } else {
                window.location.href = 'index.php?ids=' + selected.join(',');
            }
        });
    }

    // Delete Selected
    const deleteBtn = document.getElementById('delete-selected');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
            if (selected.length === 0) {
                alert('Please select at least one item to delete.');
                return;
            }
            if (confirm('Delete selected item(s)?')) {
                window.location.href = '?delete=' + selected.join(',');
            }
        });
    }
});
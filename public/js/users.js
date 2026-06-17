document.addEventListener('DOMContentLoaded', () => {

    const tableBody = document.getElementById('users-table-body');
    const rowsPerPage = 4;
    let currentPage = 1;

    function displayTablePage(page) {
        const rows = tableBody.querySelectorAll('tr');
        currentPage = page;

        rows.forEach((row, index) => {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });

        document.querySelectorAll('.page-number-btn').forEach(btn => {
            if (parseInt(btn.textContent) === page) {
                btn.classList.add('active-page');
                btn.classList.remove('text-dark', 'bg-transparent');
            } else {
                btn.classList.remove('active-page');
                btn.classList.add('text-dark', 'bg-transparent');
            }
        });
    }

    const paginationContainer = document.querySelector('.pagination');
    paginationContainer.addEventListener('click', (e) => {
        e.preventDefault();
        const rows = tableBody.querySelectorAll('tr');
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        if (e.target.classList.contains('page-number-btn')) {
            displayTablePage(parseInt(e.target.textContent));
        }

        const arrowBtn = e.target.closest('.pagination-arrow');
        if (arrowBtn) {
            const action = arrowBtn.getAttribute('aria-label');
            if (action === 'First') displayTablePage(1);
            else if (action === 'Previous' && currentPage > 1) displayTablePage(currentPage - 1);
            else if (action === 'Next' && currentPage < totalPages) displayTablePage(currentPage + 1);
            else if (action === 'Last') displayTablePage(totalPages);
        }
    });

    let rowToEdit = null;
    let userIdToEdit = null;
    let rowToDelete = null;
    let userIdToDelete = null;

    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));

    const editForm = document.getElementById('edit-user-form');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');

    // ── Open modals ──────────────────────────────────────────────────────────
    tableBody.addEventListener('click', (e) => {
        const targetRow = e.target.closest('tr');
        if (!targetRow) return;

        if (e.target.classList.contains('btn-delete')) {
            rowToDelete = targetRow;
            userIdToDelete = e.target.dataset.id;
            const userName = targetRow.querySelector('.user-name-cell').textContent.trim();
            document.getElementById('delete-user-name').textContent = `"${userName}"`;
            deleteModal.show();
        }

        if (e.target.classList.contains('btn-edit')) {
            rowToEdit = targetRow;
            userIdToEdit = e.target.dataset.id;

            document.getElementById('edit-name').value = targetRow.querySelector('.user-name-cell').textContent.trim();
            document.getElementById('edit-room').value = targetRow.querySelector('.user-room-cell').textContent.trim();
            document.getElementById('edit-ext').value  = targetRow.querySelector('.user-ext-cell').textContent.trim();

            editModal.show();
        }
    });

    // ── Delete ────────────────────────────────────────────────────────────────
    confirmDeleteBtn.addEventListener('click', async () => {
        if (!rowToDelete || !userIdToDelete) return;

        confirmDeleteBtn.disabled = true;
        confirmDeleteBtn.textContent = 'Deleting...';

        try {
           const res = await fetch('/delete-user', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userIdToDelete })
            });

            const data = await res.json();

            if (data.success) {
                rowToDelete.style.transition = 'all 0.3s ease';
                rowToDelete.style.opacity    = '0';
                rowToDelete.style.transform  = 'translateX(20px)';

                setTimeout(() => {
                    rowToDelete.remove();

                    const rows       = tableBody.querySelectorAll('tr');
                    const totalPages = Math.ceil(rows.length / rowsPerPage);
                    if (currentPage > totalPages && currentPage > 1) currentPage = totalPages;
                    displayTablePage(currentPage);

                    deleteModal.hide();
                    rowToDelete    = null;
                    userIdToDelete = null;
                }, 300);
            } else {
                alert('Error: ' + (data.message || 'Could not delete user'));
            }
        } catch (err) {
            alert('Network error. Please try again.');
            console.error(err);
        } finally {
            confirmDeleteBtn.disabled    = false;
            confirmDeleteBtn.textContent = 'Delete';
        }
    });

    // ── Edit ──────────────────────────────────────────────────────────────────
    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!rowToEdit || !userIdToEdit) return;

        const saveBtn = editForm.querySelector('[type="submit"]');
        saveBtn.disabled    = true;
        saveBtn.textContent = 'Saving...';

        const newName = document.getElementById('edit-name').value.trim();
        const newRoom = document.getElementById('edit-room').value.trim();
        const newExt  = document.getElementById('edit-ext').value.trim();

        try {
            const res = await fetch('/update-user', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userIdToEdit, name: newName, room: newRoom, ext: newExt })
            });

            const data = await res.json();

            if (data.success) {
                rowToEdit.querySelector('.user-name-cell').textContent = newName;
                rowToEdit.querySelector('.user-room-cell').textContent = newRoom;
                rowToEdit.querySelector('.user-ext-cell').textContent  = newExt;

                editModal.hide();
                rowToEdit    = null;
                userIdToEdit = null;
            } else {
                alert('Error: ' + (data.message || 'Could not update user'));
            }
        } catch (err) {
            alert('Network error. Please try again.');
            console.error(err);
        } finally {
            saveBtn.disabled    = false;
            saveBtn.textContent = 'Save Changes';
        }
    });

    displayTablePage(1);
});
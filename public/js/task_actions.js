// public/js/task_actions.js

function handleTaskAction(action, taskId) {
    let url = '';
    let statusBadge = '';
    let rowClass = '';
    let disableButtons = false;
    let actionButtons = '';

    switch (action) {
        case 'accept':
            url = window.taskRoutes.accept.replace(':id', taskId);
            statusBadge = 'badge-info';
            rowClass = 'table-light';
            disableButtons = true;
            actionButtons = `
                <button class="btn btn-outline-warning btn-sm" onclick="handleTaskAction('complete', ${taskId})">
                    <i class="fas fa-clipboard-check"></i> Complete
                </button>
            `;
            break;
        case 'reject':
            url = window.taskRoutes.reject.replace(':id', taskId);
            break;
        case 'complete':
            url = window.taskRoutes.complete.replace(':id', taskId);
            statusBadge = 'badge-success';
            rowClass = 'table-light';
            disableButtons = true;
            actionButtons = '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Completed</span>';
            break;
    }

    $.ajax({
        url: url,
        type: 'PATCH',
        data: {
            _token: window.taskRoutes.csrfToken
        },
        success: function (response) {
            if (response.success) {
                if (action === 'reject') {
                    $(`#task-row-${taskId}`).fadeOut('slow', function () {
                        $(this).remove();
                    });
                } else {
                    $(`#task-row-${taskId}`)
                        .removeClass('table-warning table-light table-danger')
                        .addClass(rowClass);
                    $(`#task-status-${taskId}`)
                        .removeClass('badge-warning badge-info badge-success badge-danger')
                        .addClass(statusBadge)
                        .text(action === 'complete' ? 'Completed' : 'Processing');

                    if (disableButtons) {
                        $(`#task-actions-${taskId}`).html(actionButtons);
                    }
                }
            } else {
                alert(response.message);
            }
        },
        error: function (response) {
            alert('An error occurred while performing the action.');
        }
    });
}

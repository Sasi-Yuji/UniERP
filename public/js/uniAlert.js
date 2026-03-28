/* uniAlert.js - Branded Popup System */
function uniConfirm(message, title = 'Are you sure?') {
    return new Promise((resolve) => {
        // Inject modal if it doesn't exist
        if ($('#uni-modal-overlay').length === 0) {
            $('body').append(`
                <div id="uni-modal-overlay" class="uni-modal-overlay">
                    <div class="uni-modal">
                        <h3 id="uni-modal-title"></h3>
                        <p id="uni-modal-message"></p>
                        <div class="uni-modal-btns">
                            <button id="uni-modal-cancel" class="uni-modal-btn uni-modal-btn-cancel">Cancel</button>
                            <button id="uni-modal-confirm" class="uni-modal-btn uni-modal-btn-confirm">Confirm</button>
                        </div>
                    </div>
                </div>
            `);
        }

        const overlay = $('#uni-modal-overlay');
        $('#uni-modal-title').text(title);
        $('#uni-modal-message').text(message);
        
        overlay.addClass('active');

        // Reset confirm button text
        $('#uni-modal-confirm').text('Confirm').removeClass('uni-modal-btn-alert').addClass('uni-modal-btn-confirm');

        $('#uni-modal-confirm').off('click').on('click', function() {
            overlay.removeClass('active');
            resolve(true);
        });

        $('#uni-modal-cancel').off('click').on('click', function() {
            overlay.removeClass('active');
            resolve(false);
        });
    });
}

function uniAlert(message, title = 'Success') {
    // Inject modal if it doesn't exist
    if ($('#uni-modal-overlay').length === 0) {
        $('body').append(`
            <div id="uni-modal-overlay" class="uni-modal-overlay">
                <div class="uni-modal">
                    <h3 id="uni-modal-title"></h3>
                    <p id="uni-modal-message"></p>
                    <div class="uni-modal-btns">
                        <button id="uni-modal-cancel" class="uni-modal-btn uni-modal-btn-cancel">Cancel</button>
                        <button id="uni-modal-confirm" class="uni-modal-btn uni-modal-btn-confirm">OK</button>
                    </div>
                </div>
            </div>
        `);
    }

    const overlay = $('#uni-modal-overlay');
    $('#uni-modal-title').text(title);
    $('#uni-modal-message').text(message);
    
    // Adjust for Alert (Hide cancel, change confirm color)
    $('#uni-modal-cancel').hide();
    $('#uni-modal-confirm').text('OK').removeClass('uni-modal-btn-confirm').addClass('uni-modal-btn-alert');

    overlay.addClass('active');

    $('#uni-modal-confirm').off('click').on('click', function() {
        overlay.removeClass('active');
    });
}

function uniToast(message) {
    if ($('#uni-toast-container').length === 0) {
        $('body').append('<div id="uni-toast-container" class="uni-toast-container"></div>');
    }

    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="uni-toast">
            <div class="uni-toast-icon">✓</div>
            <div class="uni-toast-message">${message}</div>
        </div>
    `;

    $('#uni-toast-container').append(toastHtml);

    setTimeout(() => {
        $(`#${toastId}`).addClass('fade-out');
        setTimeout(() => {
            $(`#${toastId}`).remove();
        }, 400);
    }, 3000);
}

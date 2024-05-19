// toast
const SwalToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

// function for handle error response
function errorMessage(xhr, textStatus, error) {
    let errorResponse = JSON.parse(xhr.responseText);
    let errorMessages = errorResponse.errors;
    let errorMessage = errorMessages;
    if (xhr.status === 422) {
        errorMessage = "Validation error:\n";
        const response = xhr.responseJSON
        for (const message of response.message) {
            for (const [key, value] of Object.entries(message)) {
                errorMessage += value + "\n"
            }
        }
        showToastNotification('error', errorMessage)
    } else if (xhr.status === 401) {
        showToastNotification('error', errorResponse.message + '. Please login again.')

        $.ajax({
            url: '/apis/auth/logout',
            method: 'POST',
            success: function(response) {
                window.location.href = '/login';
            },
            error: function() {
                window.location.href = '/login';
            }
        });
    } else if (xhr.status === 400) {
        errorMessage = errorResponse.result !== null && errorResponse.result != undefined ? (errorResponse
            .result.message === null ? errorResponse
            .message : errorResponse.result.message) : errorResponse.message;
        if (Array.isArray(errorMessage)) {
            errorMessage = ''
            for (const message of errorResponse.result.message) {
                errorMessage += message + '\n'
            }
        }
        if (errorMessage == 'Token is Empty') { // jika token kosong, logout & redirect ke halaman login
            showToastNotification('error', errorMessage + '. Please login again.')

            $.ajax({
                url: '/apis/auth/logout',
                method: 'POST',
                success: function(response) {
                    window.location.href = '/login';
                },
                error: function() {
                    window.location.href = '/login';
                }
            });
        } else {
            showToastNotification('error', errorMessage ?? xhr.statusText)
        }
    } else {
        errorMessage = errorResponse.result !== null && errorResponse.result != undefined ? (errorResponse
            .result.message === null ? errorResponse
            .message : errorResponse.result.message) : errorResponse.message;
        errorMessage = Array.isArray(errorMessage) ? errorMessage.join('\n') : errorMessage
        showToastNotification('error', errorMessage ?? xhr.statusText)

        // jika token kosong, logout & redirect ke halaman login
        if (errorMessage != null) if (errorMessage.toLowerCase().includes('token')) {
            $.ajax({
                url: '/apis/auth/logout',
                method: 'POST',
                success: function(response) {
                    window.location.href = '/login';
                },
                error: function() {
                    window.location.href = '/login';
                }
            });
        }
    }
}

// function show toast notification
function showToastNotification(icon, text) {
    if (icon == 'error') {
        return Swal.fire({
            icon,
            text,
            title: "Terjadi suatu kesalahan!",
        })
    } else {
        return SwalToast.fire({
            icon: icon,
            text: text,
        })
    }
}
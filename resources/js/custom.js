(function (NioApp, $) {
    'use strict';


    window.success = function (message, callback) {
        Swal.fire(
            "Success!",
            message,
            "success"
        ).then(result => {
            if (result.value && callback) {
                callback();
            }
        });
    };

    window.warning = function (message, callback) {
        Swal.fire(
            "Warning!",
            message,
            "warning"
        ).then(result => {
            if (result.value && callback) {
                callback();
            }
        });
    };

    window.error = function (message, callback) {
        Swal.fire(
            "Error!",
            message,
            "error"
        ).then(result => {
            if (result.value && callback) {
                callback();
            }
        });
    };

})(NioApp, jQuery);

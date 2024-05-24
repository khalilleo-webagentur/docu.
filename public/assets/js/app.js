$(document).ready(function () {

    setTimeout(function () {
        $(".alert").alert('close').fadeOut();
    }, 10000);

    if ($('#clipboard').length) {
        $('#clipboard').on('click', function (e) {
            let link = $('#link').text();
            copyContent(link);
            swal('', 'Link (' + link + ') is copied to clipboard.', 'success');
        });
    }

    if ($('.three-dots').length) {
        $('.three-dots').on('click', function () {
            $('.dataId').val($(this).attr('data-id'));
        });
    }

     let modal = $('.modal');
     modal.on('shown.bs.modal', function () {
         $(this).find('[autofocus]').focus();
     });

     if ($('.btnLike').length) {

        let i = $('.btnLike').attr('data-id');

        console.log(i);

        if (isLocalStorageAvailable && window.localStorage.getItem('LIKE'+i) === '1') {
            $('.btnLike').prop('disabled', 'true');
            console.log('already liked ..')
        }

        $('.btnLike').on('click', function () {
            let i = $('.btnLike').attr('data-id');
            if (isLocalStorageAvailable) {
               window.localStorage.setItem('LIKE'+i, '1')
            }
        });
    }

    if ($('.btnDisLike').length) {

        let i = $('.btnDisLike').attr('data-id');

        console.log(i);

        if (isLocalStorageAvailable && window.localStorage.getItem('DIS_LIKE'+i) === '1') {
            $('.btnDisLike').prop('disabled', 'true');
            console.log('already liked ..')
        }

        $('.btnDisLike').on('click', function () {
            let i = $('.btnDisLike').attr('data-id');
            if (isLocalStorageAvailable) {
               window.localStorage.setItem('DIS_LIKE'+i, '1')
               window.localStorage.removeItem('LIKE'+i);
            }
        });
    }
});

function isLocalStorageAvailable() { return typeof (Storage) !== "undefined" }

async function copyContent(text) {
    try {
        if (isLocalStorageAvailable) {
            await navigator.clipboard.writeText(text);
        }
    } catch (err) {
        swal('', 'clipboard is not avialble on your Browser.', 'warning');
    }
}

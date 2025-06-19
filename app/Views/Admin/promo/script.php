<script>
    var $status = '<?= isset(session()->get('message')[0]) ? session()->get('message')[0] : '' ?>'
    var $message = '<?= isset(session()->get('message')[1]) ? session()->get('message')[1] : '' ?>'
    console.log($status);
    if ($status == 200) {
        Toast.fire({
            timer: 2000,
            icon: 'success',
            title: $message
        });
    } else if ($status == 400) {
        Toast.fire({
            timer: 2000,
            icon: 'error',
            title: $message
        });
    }
</script>
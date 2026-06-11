<script src="<?php echo e(asset('assets/js/jquery.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- <script src="<?php echo e(asset('assets/vendor/swiper/swiper-bundle.min.js')); ?>"></script> -->
<script src="<?php echo e(asset('assets/js/dz.carousel.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/settings.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js" integrity="sha384-/KNQL8Nu5gCHLqwqfQjA689Hhoqgi2S84SNUxC3roTe4EhJ9AfLkp8QiQcU8AMzI" crossorigin="anonymous"></script>
<script>
     const socket = io("https://socket-banksampah.grooject.com/", {
        transports: ["websocket"]
    });

    socket.on('realtime_sensor', (data) => {
        console.log(data.sensor_name);
        if (data.sensor_name == 'bankSampah1-sensor1') {
            $('#bankSampah1-sensor1').text(data.value);
        } else if (data.sensor_name == 'bankSampah1-sensor2') {
            $('#bankSampah1-sensor2').text(data.value);
        } else if (data.sensor_name == 'bankSampah1-sensor3') {
            $('#bankSampah1-sensor3').text(data.value);
        } else {
            $('#bankSampah1-sensor4').text(data.value);
        }
    })
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({})
    })

    $("#checkbox").click(function() {
        if ($("#checkbox").is(':checked')) {
            $("#e1 > option").prop("selected", "selected");
            $("#e1").trigger("change");
        } else {
            $("#e1 > option").removeAttr("selected");
            $("#e1").val("");
            $("#e1").trigger("change");
        }
    });

    function logout() {
        $.ajax({
            type: 'POST',
            url: '/logout',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "<?php echo e(csrf_token()); ?>"
            },
            success: function(data) {
                location.reload();
            },
            error: function(data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

    function modalDeleteMobile(url, link) {
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_method": 'delete',
                "_token": "<?php echo e(csrf_token()); ?>"
            },
            success: function(data) {
                window.location.href = link
                console.log(data);
            },
            error: function(data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }
</script>
<?php echo $__env->yieldPushContent('script'); ?>
<?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/layout-mobile/components/foot.blade.php ENDPATH**/ ?>
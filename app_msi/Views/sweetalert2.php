<?php 
if ($s2Icono == 'success'): ?>
    <script>
        console.log('swtalert -> Swal2 -> msgToast');
        Swal.fire({
            position: 'top-end',
            title: '<?php echo $s2Titulo; ?>',
            text: '<?php echo $s2Texto; ?>',
            icon: '<?php echo $s2Icono; ?>',
            toast: '<?php echo $s2Toast; ?>',
            showConfirmButton: false,
            background: '#E0FFFF',
            timer: 2000,
        });
    </script>

<?php endif; ?>

<?php
if($s2Icono == 'error' || $s2Icono == 'warning'): ?>
    <script>
        console.log('swtalert -> Swal2 -> noToast');
        Swal.fire({
            title: '<?php echo $s2Titulo; ?>',
            text: '<?php echo $s2Texto; ?>',
            icon: '<?php echo $s2Icono; ?>',
            confirmButtonColor: '#dd6b55',
            footer: '<a href><?php echo $s2Footer; ?></a>',
         //footer: '<a href>Why do I have this issue?</a>'
        });
    </script>
<?php endif; ?>
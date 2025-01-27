
<?php
if($s2Icono == 'error'): ?>
    <script>
        console.log('swtalert -> Swal2 -> noToast');
        Swal.fire({
            title: '<?php echo $s2Titulo; ?>',
            text: '<?php echo $s2Texto; ?>',
            icon: '<?php echo $s2Icono; ?>',
         //   footer: 'Hola',
        });
    </script>
<?php endif; ?>
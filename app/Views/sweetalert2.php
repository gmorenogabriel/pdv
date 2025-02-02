<?php 
switch ($s2Icono) {
    case 'success': ?>
        <script>
            console.log('swtalert -> Swal2 -> msgToast');
            Swal.fire({
                position: 'top-end',
                title: '<?php echo $s2Titulo; ?>',
                text: '<?php echo $s2Texto; ?>',
                icon: '<?php echo $s2Icono; ?>',
                toast: <?php echo $s2Toast ? 'true' : 'false'; ?>,
                showConfirmButton: false,
                background: '#E0FFFF',
                timer: 2000,
            });
        </script>
        <?php
        break;

    case 'info': ?>
        <script>
            console.log('swtalert -> Swal2 -> noToast');
            Swal.fire({
                title: '<?php echo $s2Titulo; ?>',
                text: '<?php echo $s2Texto; ?>',
                icon: '<?php echo $s2Icono; ?>',
                confirmButtonColor: '#dd6b55',
                <?php if (!empty($s2Footer)): ?>
                    footer: '<a href><?php echo $s2Footer; ?></a>',
                <?php endif; ?>
            });
        </script>
        <?php
        break;

    case 'error':
    case 'warning': ?>
        <script>
            console.log('swtalert -> Swal2 -> noToast');
            Swal.fire({
                title: '<?php echo $s2Titulo; ?>',
                text: '<?php echo $s2Texto; ?>',
                icon: '<?php echo $s2Icono; ?>',
                confirmButtonColor: '#dd6b55',
                <?php if (!empty($s2Footer)): ?>
                    footer: '<a href><?php echo $s2Footer; ?></a>',
                <?php endif; ?>
            });
        </script>
        <?php
        break;
}
?>

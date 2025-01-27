
<style type="text/css">
#dvPreview
{
    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=image);
    min-height: 400px;
    min-width: 400px;
    display: none;
}
</style>
<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan">

    <?php if (session('msg')) : ?>
        <div class="alert alert-success mt-3">
            <?= session('msg') ?>
        </div>
    <?php endif ?>    

    <form method="post" action="<?php echo base_url('UploadMultipleFiles/uploadFiles');?>" 
    enctype="multipart/form-data">
      <div class="form-group mt-3">
        <input type="file" name='images[]' id="fileupload" multiple="" class="form-control">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-danger">Upload</button>
      </div>

    <!-- <div id="dvPreview"> -->
    <div class="gallery"></div>

    </form>

  </div>
  <!--
</body>

</html>
-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $('#fileupload').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});
// Show Un archivo
// $(function () {
//     $("#fileupload").change(function () {
//         $("#dvPreview").html("");
//         var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
//         if (regex.test($(this).val().toLowerCase())) {
//             if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) {
//                 $("#dvPreview").show();
//                 $("#dvPreview")[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(this).val();
//             }
//             else {
//                 if (typeof (FileReader) != "undefined") {
//                     $("#dvPreview").show();
//                     $("#dvPreview").append("<img />");
//                     var reader = new FileReader();
//                     reader.onload = function (e) {
//                         $("#dvPreview img").attr("src", e.target.result);
//                     }
//                     reader.readAsDataURL($(this)[0].files[0]);
//                 } else {
//                     alert("This browser does not support FileReader.");
//                 }
//             }
//         } else {
//             alert("Please upload a valid image file.");
//         }
//     });
// });
</script>
<style type="text/css">
#previewFoto{
    width: auto;
    height: 100px;
    max-height: 100px;
    display: block;
    margin: 0 auto;
}    
.input_file{
    background-image: url('data:image/png;base64,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');
    margin: 0;
    width: auto;
    cursor: pointer;
}
.input_file input{
    cursor: pointer;   
}
#btnUpload{
    margin-right: 35px;
}
</style>
<!-- Modal -->
<div id="modalMedia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subir imagen</h4>
            </div>
            <form role="form" id="frmUploadImage" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fotoTrabajador">Foto</label>
                        <br class="clear" />
                        <img class="round" id="previewFoto" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGoAAABqCAYAAABUIcSXAAAHK0lEQVR4Ae2b30sVTxTAx7IMy0iih1ChIBHrpZcwEAIffAnyD+p/8akXRaEf9lBaUUZqihneItLKtPxRaD9Isx9qXz7zZe2q97brdWZ3z/UMLHt3dnf2zPnMmXPm7N6STCbzx2hJvQb2pF5CFdBqQEEJGQgKSkEJ0YAQMdWiFJQQDQgRUy1KQQnRgBAx1aIUlBANCBFTLUpBCdGAEDHVohSUEA0IEVMtSkEJ0YAQMdWiFJQQDQgRUy1KQQnRgBAx1aIUlBANCBFTLUpBCdGAEDHVohSUEA0IEbPUpZx79qiBbtbn2tra5qqCjp2AAtCLFy/M48ePjcL6y+Ho0aPm0qVLZmVl5W9lgb+cgOLZy8vL5uXLlxbUnz/6vwN0Ul1dbUpKSgpEs/E2Z6BotrTUaXMbJRV45AoSXVenImQAKCghoLzPVfgrIp9i9VtMb2y+gyivoIBz+PBhU1NTY8rKyooSFoDm5ubs5ioUz2XkXkEhOCHqhQsXzJEjR4oSFNbU19dnPnz4kEu/zuq8ggqkPHDggDl06JCdAoO6YtljUfv37/fenVhAYVnF7Ke8U/IdngeOVkogsXfvXu9BQaFQY7GoQoWL4z4G08+fP8379+/Nly9f7KK9qqrK+lTApaXsalBY+tTUlLlz54559erVerBDpHr+/HnT0NBgysvLU8Fq14IiCMCKbty4YSO2ffv2rQP5/v27efjwoT1ubGyMJVhYf3ieH7s2M0FGe3R01CwsLGxJnALx9+/fNsn88ePHLefz6NJr9a4EhV8i2w8EgHG8uQDr06dPdtt8LonjVIJCST4Lvml1dTV0XRflGp9yZrftVyPZT4r4G0iM9Pv373sLlbEgFuCVlZV5X82w7uOaioqKnBYXsTvOLksdKHrW29tr7t27Zx16tpN31WssindnZ86csTlIoOQqJ0+eNITqaVgHpgoU1jQ5OWmdOIq7deuWzaP5gAWcU6dOmebmZguN4IE69my1tbWmqanJHDx4MBWgUhWe49j7+/vtApTpiQ1YZN7Pnj0b6lNyWUVY3blz58yJEyfM0NCQzYAzKE6fPm2tDUguvncIkyHK+dSAAgrfXLx9+9YC4ZjC6AYWWQKmKupdTkVY0bFjx8zFixfX/VUQbADJ5bOiAMl3TSpAoXwWmaxrFhcXNzhvzn379s3cvXvXKrKuri4yLO4lPRT2LizwUb9+/cqnp8TrU+OjxsbGbDon1wgOIkECjNevX9vQOormaGtwcNDew/WAk1oSB4XyPn/+bJ4/f24tJ98aiqlvdnbW5uUIOHIBzYZAOxMTEzZyJE305MmTDVNq9rUSficOimkHK3nz5k2ovoD67t07Ow3y+jufhVCPbyMw+fHjh00TkXjlTSzTW777QgVI8IJEQaEw0jSZTMYqNIoCsRQy3teuXbOWmMsCqXv27Nn6VMoxvu/Bgwemu7vb+sNc9yXIIfTRiYIiRRNYU1TFAZNtenratLe3WwDZ9wbwR0ZGLJAAPnusa3h42Ny+fdt8/frVW+YjVOsFXJAYKBTHKMfZ428ChUbtAz6L1xStra02sgvuo62nT5/aKTKoC/Y8g8GBv+rq6sprkcH1adonBgrfxPQ0MzNT8MjGkggwrly5YmEBD0vjDwuE5fngU0/w0tHR4f3rIVewEwGFonjt/ejRo/VFZqEdIpNAFHj9+nVrIUACPtD+VThPAAMsfF4+qP9qI85ziSx4US6Qgm8UdtphpjuyGiyM2aJMpYBBDqC2tbWZlpYWm9/j0y+mx7SV2C2K6YqPFQcGBkJHfVRloXTSPaybeGObHVyEtYFlAbezs9P6y6WlpW3dH9a+q/Oxg2K09/T0RBr12+0kSt8OpKB97mF9hVy8YgFcIe0E7fnYxwqKkU+kx7opbf+lQjamPCyd8B2rBxb1bEmX2EGRMUijDwhAIBvJYTL2ZEEozAJJl1hBJd3ZqM8HDN/53bx504yPj0e9zet1iYEKXi147d0OGgcWYfvVq1ftuoymwkL+HTwu9NZEwnPeDxEaSyhM1cBiSqyvr08MVqygsCL+J3X58mUJjLbImGQkGCuooOdSrCmQNw37WEAR3jIa0xA9uVZ6XOG7V1B0glcLhLms+Iux0EdSYb6Ld1Dz8/P2q9e0LXBdKRZQfJjjO4r1CgplEDWRfyvmEsf05x0UgJKMloplgCS24C0WBcbVDwUVl6Z3+BxnU1/gTHWa+58ISxF8l6tSkslknKSGeX1BmOpSOFedTKodIt3jx487iQidWRR/+uLf5Fo2aiCYaTbWbv/IGSge7Uqo7Xej+O/QYEIIYwWloIRoQIiYalEKSogGhIipFqWghGhAiJhqUQpKiAaEiKkWpaCEaECImGpRCkqIBoSIqRaloIRoQIiYalEKSogGhIipFqWghGhAiJhqUQpKiAaEiKkWpaCEaECImGpRCkqIBoSIqRYlBNR/SR7uypAmSTsAAAAASUVORK5CYII="/>            
                        <p class="help-block text-center" style="font-size: 12px;">(Archivo en JPG o PNG, máximo 500Kb ó 300x300 pixeles)</p>
                        <div class="clearfix"></div>
                        <div class="input_file">
                            <span></span>
                            <input type="file" accept="image/*" id="documentCustomImagen" name="documentCustomImagen" onchange="loadFile(event)" />
                        </div>

                        <button type="submit" id="btnUpload" class="btn btn-primary pull-right disabled"> <i class="fa fa-upload"></i> &nbsp; Subir imagen</button>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
function loadFile(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('previewFoto');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    $("#btnUpload").removeClass('disabled');
};


$("#frmUploadImage").on('submit',(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
        data: new FormData(this),
        dataType: 'json',
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,
        beforeSend: function(){
            $("#btnUpload").replaceWith('<button id="btnUploading" type="button" class="btn btn-warning pull-right"> <i class="fa fa-cog fa-spin"></i> &nbsp; Subiendo...</button>')
        },
        success: function (json) {
            $("#btnUploading").replaceWith('<a id="btnInsert" href="#" data-source="'+json.filename+'" class="btn btn-success pull-right"> <i class="fa fa-plus"></i> &nbsp; Insertar imagen</a>')
        }
    });
}));


$(document).on('click','#btnInsert', function(e){
    e.preventDefault();
    var src = $(this).data('source');
    var tag = '<img src="<?php echo BASE_URL ?>/private/uploads/images/'+src+'">';
    if(navigator.userAgent.match(/MSIE/i)){
        methods.insertTextAtSelection.apply(this,[tag,'html']);
    }
    else{
        document.execCommand('insertHTML',false,tag);
    }

    $("#btnInsert").replaceWith('<button type="submit" id="btnUpload" class="btn btn-primary pull-right disabled"> <i class="fa fa-upload"></i> &nbsp; Subir imagen</button>');

    $("#modalMedia").modal('hide');

});

</script>


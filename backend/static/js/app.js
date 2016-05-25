function calcFileSize(file){
    var size = Math.round(file.size * 100 / 1024) / 100;
    var unit = "KB";
    if(size > 1024) {
        size = Math.round(size*100/1024)/100;
        unit = "MB";
    }
    return size + " " + unit;
}

$(document).ready(function(){
    $("[data-toggle='tooltip']").tooltip();
    $('.fileinput-button > input[type="file"]').on("change", function(){
        $(this).parent().next().html($(this).val() + " - " + calcFileSize(this.files[0]));
    });
});
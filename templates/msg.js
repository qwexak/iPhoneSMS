/**
 * Created by svk on 05.12.2015.
 */


$(document).ready(function () {

//    $("#phone-num").change(function () {
	$("#phone-num").chosen({search_contains: true}).change(function () {

        //alert( this.value );

        $.post("/", {rowid: this.value}, function (data) {
            var msg = $("#messages");
            $("#msgcount").html("Сообщений <span class='badge'>" + data.length + "</span>");
            msg.html('');
            $.each(data, function () {

                var textalign = this.is_from_me ? " text-right" : "";
                var label = this.is_from_me ? "primary" : "default";
                msg.append("<div class='col-md-6 col-md-offset-3" + textalign + "'>" +
                    "<span style='white-space: normal;' class='label label-" + label + "'>" + this.date + "</span>" +
                    "</br><small>" + this.text + "</small</div>");
            });
        }, "json");
    });
});
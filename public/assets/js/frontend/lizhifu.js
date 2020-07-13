define(['jquery', 'bootstrap', 'frontend'], function ($, undefined, Frontend) {
    var Controller = {
        trade: function () {
            $(document).on("click", ".row-money label[data-type]", function () {
                $(".row-money label[data-type]").removeClass("active");
                $(this).addClass("active");
                $("#col-custom").toggleClass("hidden", $(this).data("type") === "fixed");
                $("input[name=amount]").val($(this).data("value"));
                if ($(this).data("type") === 'custom') {
                    $("input[name=custommoney]").trigger("focus").trigger("change");
                }
            });
            $(document).on("click", ".row-paytype label", function () {
                $(".row-paytype label").removeClass("active");
                $(this).addClass("active");
                $("input[name=channel_id]").val($(this).data("value"));
            });
            $(document).on("keyup change", ".custommoney", function () {
                $("input[name=amount]").val($(this).val());
            });
        }
    };
    return Controller;
});
if (!WOOSVIADM) {
    var WOOSVIADM = {}
} else {
    if (WOOSVIADM && typeof WOOSVIADM !== "object") {
        throw new Error("WOOSVIADM is not an Object type")
    }
}
WOOSVIADM.isLoaded = false;
WOOSVIADM.STARTS = function ($) {
    return{NAME: "Application initialize module", VERSION: 1.0, init: function () {
            this.loadInits();
        }, loadInits: function () {

            if ($('input#woosvi_defaultprod').prop("checked")) {
                var table = $('form#mainform table.form-table tbody');
                table.find('tr:nth-child(1),tr:nth-child(2),tr:nth-child(3)').hide();
            }
            $('input#woosvi_defaultprod').on('change', function () {
                var table = $('form#mainform table.form-table tbody');
                if ($(this).prop("checked")) {
                    $("tr:nth-child(1) input,tr:nth-child(3) input").prop("checked", false);
                    $("tr:nth-child(2) input").val(3);
                    table.find('tr:nth-child(1),tr:nth-child(2),tr:nth-child(3)').toggle();
                } else {
                    table.find('tr:nth-child(1),tr:nth-child(2),tr:nth-child(3)').toggle();
                }
            });
        }
    }
}(jQuery);
jQuery(document).ready(function () {
    WOOSVIADM.STARTS.init();
});
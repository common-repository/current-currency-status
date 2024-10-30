jQuery(document).ready(function ($) {
    
    $.noConflict();
    
    var Current_currency = {

        container: $('table.ccs-table'),

        content: 'tr.css-base',

        config: {
            apikey: '',
            wrraper: 0
        },

        url: 'https://openexchangerates.org/api/latest.json?app_id=',

        init: function (config) {

            $.extend(this.config, config);

            this.fetch();
        },

        setMoney: function () {
            if (typeof fx !== "undefined" && fx.rates) {
                fx.rates = this.currency.rates;
                fx.base = this.currency.base;
            } else {
                var fxSetup = {
                    rates: this.currency.rates,
                    base: this.currency.base
                }
            }
        },

        attached: function (data) {

            this.currency = data;

            this.setMoney();

            var tr = this.container.find(this.content);
            if (tr.length > 0) {
                return false;
            }
            if (this.config.wrraper) {
                this.adminWrapper();
            } else {
                this.wrapper();
            }
        },

        wrapper: function () {
            var cn = this.container,
                    options = this.getOptions();
            cn.removeClass('ccs-hidden')
                    .append("<tr valign='top' class='css-base'><td scope='row'><label for='tablecell'> <strong>Currency Base: <code>" + this.currency.base + "</code></strong></label></td><td scope='row'><input type='text' value='' id='baseval' class='' /></td></tr>")
                    .append("<tr valign='top' class='css-base'><td scope='row'><select class='ccrates'> " + options.join("") + "</select></td><td><input type='text' id='toval' class=''></td></tr>");
        },

        getOptions: function () {
            var options = [];
            $.each(this.currency.rates, function (k, v) {
                options.push("<option value='" + k + "' >" + k + "</option>");
            });
            return options;
        },

        adminWrapper: function () {
            var cn = this.container,
                    options = this.getOptions();
            cn.append("<tr valign='top' class='alternate css-base'><td scope='row'><label for='tablecell'> <strong>Currency Base: <code>" + this.currency.base + "</code></strong></label></td><td><input type='text' value='' id='baseval' class='regular-text' /></td></tr>")
                    .append("<tr valign='top' class='css-base'><td scope='row'><select class='ccrates'> " + options.join("") + "</select></td><td><input type='text' id='toval' class='regular-text'></td></tr>");
        },

        fetch: function () {
            var self = this;
            $.getJSON(this.url + this.config.apikey + '', function (data) {
                self.attached(data);
            }).error(function () {
                alert("error");
            });
        }
    };

    $(".ccs-container").on('click', '#ccgetcurrency', function () {
        Current_currency.init({
            apikey: ccStatus.apikey,
            wrraper: parseInt(ccStatus.wrraper)
        });
        $(this).text('Reload').val('Reload');
    }).on('change', '.ccrates', function () {
        $("#toval").val(fx.convert(
                $('#baseval').val(), {from: Current_currency.currency.base, to: $(this).val()}
        ));
    }).on('keyup', '#baseval', function () {
        $("#toval").val(fx.convert(
                $(this).val(), {from: Current_currency.currency.base, to: $('.ccrates').val()}
        ));
    });
});

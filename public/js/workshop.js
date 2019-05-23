function initData() {
    let customersData = {};

    let workshopId = ($('#workshop').val());
    let fpurl = window.location.origin + '/free-places/' + workshopId;
    $.ajax({
        url: fpurl,
        type: 'GET',
        crossDomain: false,
        async: false,
        success: function (data) {
            $('.free-places').html(data);
        },
        error: function (e) {
            console.log(e.message);
        }
    });

    let gcurl = window.location.origin + '/get-customers';
    $.ajax({
        url: gcurl,
        type: 'GET',
        crossDomain: false,
        async: false,
        success: function (data) {
            customersData = data;
        },
        error: function (e) {
            console.log(e.message);
        }
    });

    $("#name").on('focus', function () {
        $(this).autocomplete({
            source: customersData.customers.map(function (val, key) {
                return {
                    label: [val.first_name, val.last_name],
                    value: val.first_name + ' ' + val.last_name
                };
            }),
            change: function () {
                let nameArray = this.value.split(' ');
                let firstName = nameArray[0];
                let lastName = nameArray[1];
                let customer = {};

                for (var i = 0; i < customersData.customers.length; i++) {
                    if (customersData.customers[i].first_name === firstName && customersData.customers[i].last_name === lastName) {
                        customer = customersData.customers[i];
                    }
                }
                if (null !== customer.default_address.phone) {
                    $(this).next().next('input').val(customer.default_address.phone);
                }
            }
        });
    });

    $(".guest").on('focus', function () {
        $(this).autocomplete({
            source: customersData.customers.map(function (val, key) {
                return {
                    label: [val.first_name, val.last_name],
                    value: val.first_name + ' ' + val.last_name
                };
            }),
            change: function () {
                let nameArray = this.value.split(' ');
                let firstName = nameArray[0];
                let lastName = nameArray[1];
                let customer = {};

                for (var i = 0; i < customersData.customers.length; i++) {
                    if (customersData.customers[i].first_name === firstName && customersData.customers[i].last_name === lastName) {
                        customer = customersData.customers[i];
                    }
                }
                $(this).next().next('input').val(customer.email);
            }
        });
    });
}

window.onload = initData;

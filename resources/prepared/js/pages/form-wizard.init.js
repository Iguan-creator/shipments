$(document).ready(function () {
    const wizard = $("#new-shipment");
    const validations = $(".for-validation");


    wizard.smartWizard({
        //theme: "dots",
        transition: {
            animation: 'fade',
        },
        autoAdjustHeight: false,
        lang: {next: 'Далее', previous: 'Назад'}
    });

    // Show wizard after type selection
    $('#shipment_type_select').change(() => {
        $("#new-shipment, #data_header").removeClass('d-none');
    });

    $('[name="client"]').change(() => {
        $('.delivery-place-block').removeClass('d-none');
        $('.delivery-place-notification').addClass('d-none');
    });

    $('.wizard-select').change(() => goNext());

    validations.parsley().forEach(function (element) {
        element.on('field:success', () => goNext());
    });

    function goNext() {
        wizard.smartWizard('next');
    }

    // Add and remove contractors
    const contractor = $('.contractor-selector').clone();
    const port = $('.port-selector').clone();
    const contractors_holder = $('#contractor-selectors-holder');
    const ports_holder = $('#port-selectors-holder');
    activateContractorsRemovers();
    selectActivate();

    $('#add-contractor').click(() => {
        let new_contractor = contractor.clone();
        contractors_holder.append(new_contractor);
        selectActivate();
        activateContractorsRemovers();
    });

    $('#add-port').click(() => {
        let new_port = port.clone();
        ports_holder.append(new_port);
        selectActivate();
        activateContractorsRemovers();
    });

    function activateContractorsRemovers() {
        $('.multiple-input-delete').click(function () {
            $(this).closest('.multiple-input-selector').remove();
        });
    }

    function selectActivate() {
        $('[data-plugin="customselect"]').select2({
            language: {
                noResults: function () {
                    return 'Совпадений не найдено';
                }
            }
        });
    }
});

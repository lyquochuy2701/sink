(function($) {
    "use strict";

    $(function() {
        setTimeout(function() {
            if ('redux' in $ && 'ajax_save' in $.redux) {
                var redux_ajax_save = $.redux.ajax_save;
                $.redux.ajax_save = function(button) {
                    $('fieldset.redux-container-media input.upload-height, fieldset.redux-container-media input.upload-width, fieldset.redux-container-media input.upload-thumbnail').remove();
                    redux_ajax_save(button);
                };
            }
            if (!('framework_confirmation' in azexo) || azexo.framework_confirmation == '0') {
                $('.redux-group-tab-link-a').on('click', function() {
                    if ($(this).find('.group_title').text() == azexo.templates_configuration ||
                            $(this).find('.group_title').text() == azexo.fields_configuration ||
                            $(this).find('.group_title').text() == azexo.post_types_settings ||
                            $(this).find('.group_title').text() == azexo.woocommerce_templates_configuration) {
                        alert(azexo.section_alert);
                    }
                });
                $(document).on('click', function(event) {
                    if ($(event.target).closest('.vc_control-btn-edit, [data-vc-control="edit"]').length) {
                        $(event.target).closest('[data-model-id]').each(function() {
                            if ($(this).is('[data-element_type*="azexo"]')) {
                                alert(azexo.element_alert);
                            }
                        });
                    }
                });
            }
        }, 0);
    });
})(jQuery);

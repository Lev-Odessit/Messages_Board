// $(function(){
//
//     (function asideHeightConf(){
//         var aside = $('aside.sidebar'),
//             contentSection = $('section.content'),
//             asideHeight = aside.height(),
//             contentSectionHeight = contentSection.height();
//
//         if ( contentSectionHeight > asideHeight ) {
//             aside.height(contentSectionHeight);
//         }
//     })();
//
//     var appCheckerForm = {
//
//         initialize: function () {
//             this.setUpListeners();
//         },
//
//         setUpListeners: function () {
//             form = $('form.form-horizontal');
//             form.on('submit', appCheckerForm.submitForm);
//             form.on('keydown', 'input', appCheckerForm.removeError);
//         },
//
//         submitForm: function (e) {
//
//             var form = $(this),
//                 submitBtn = form.find('button[type="submit"]');
//
//             if ( appCheckerForm.validateForm(form) === false ) {
//                 return false;
//             }
//
//             submitBtn.attr('disabled', 'disabled');
//
//         },
//
//         validateForm: function (form) {
//             var inputs = form.find('input'),
//                 valid = true;
//
//             inputs.tooltip('destroy');
//
//             $.each(inputs, function (i, val) {
//                 var input = $(val),
//                     inputVal = input.val(),
//                     formGroup = input.parents('.form-group'),
//                     label = formGroup.find('label').text().toLowerCase(),
//                     textError = "Введите " + label;
//
//                 if (inputVal.length === 0) {
//                     formGroup.addClass('has-error').removeClass('has-success');
//                     input.tooltip({
//                         trigger: 'manual',
//                         placement: 'right',
//                         title: textError
//                     }).tooltip('show');
//                     valid = false;
//                 }
//                 else {
//                     formGroup.addClass('has-success').removeClass('has-error');
//                 }
//
//             });
//
//             return valid;
//         },
//
//         removeError: function () {
//             $(this).tooltip('destroy').parents('.form-group').removeClass('has-error');
//         }
//
//     };
//
//     var appAlertRemove = {
//
//         initialize : function () {
//             this.setUpListeners();
//         },
//
//         setUpListeners : function () {
//             form = $('form');
//             form.on('focus', 'input', appAlertRemove.hideAlert );
//             setTimeout( appAlertRemove.hideAlert, 5000);
//         },
//
//         hideAlert : function () {
//             var alert = $('.alert');
//             alert.slideUp();
//         }
//
//     };
//
//     appCheckerForm.initialize();
//     appAlertRemove.initialize();
//
// });